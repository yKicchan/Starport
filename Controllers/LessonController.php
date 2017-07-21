<?php
/**
 * レッスン情報に関するページの処理を行うクラス
 * 
 * @package     starport
 * @subpackage  Controllers
 * @author      yKicchan
 */
class LessonController extends AppController
{
    /**
     * レッスンの詳細情報を表示するページ
     *
     * @return void
     */
    public function detailAction()
    {
        // URLからレッスンidを取得
        $id = $this->getIdFromUrl("/[0-9]+/");

        // レッスンとその作成者情報を取得
        $model = new Lesson();
        $lesson = $model->get($id);
        $model = new User();
        $user = $model->getByLesson($id);
        $model = new Contact();

        // Viewと共有するデータをセット
        $this->set('lesson', $lesson);
        $this->set('user', $user);
        $this->set('isContacted', $model->isContacted($lesson['id'], $user['facebook_id']));

        // レッスン詳細ページ表示
        $this->disp('/Lesson/lessonpage.php');
    }

    /**
     * ジャンルページ
     *
     * @return void
     */
    public function genreAction()
    {
        // パラメータの取得
        $param = $this->getParam();

        // パラメータによって表示するページを決める
        if ($param === false) {
            $this->notFound();
        }

        // ジャンルからレッスン情報を抽出
        $genreObj = new Genre();
        $lessonObj = new Lesson();
        $genre = $genreObj->getByUrl($param);
        $lesson = $lessonObj->getByGenre($genre['id']);

        // 各レッスンの作成者情報を取得
        $userObj = new User();
        $user = array();
        foreach ($lesson as $l) {
            $user[] = $userObj->getByLesson($l['id']);
        }

        // 改行を削除
        Lesson::delBreak($lesson, 'about');

        // Viewと共有するデータをセット
        $this->set('lesson', $lesson);
        $this->set('user', $user);
        $this->set('param', $param);

        // ジャンルページ表示
        $this->disp('/Lesson/genrepage.php');
    }

    /**
     * レッスン登録ページ
     * URLのパラメータによって表示するページを決める
     *
     * @return void
     */
    public function registerAction()
    {
        // パラメータの取得
        $method = $this->getParam();

        // パラメータによって表示するページを決める
        if($method !== false && method_exists($this, $method)) {
            $this->$method();
        } else {
            $this->notFound();
        }
    }

    /**
     * レッスン登録情報入力ページ
     *
     * @return void
     */
    private function input()
    {
        // ユーザ情報とジャンル情報を取得
        $user = (new User())->get($_SESSION['user_id']);
        $genreContent = (new Content())->getAllZipGenreName();

        // Viewと共有するデータをセット
        $this->set('user', $user);
        $this->set('genreContent', $genreContent);

        // レッスン情報入力ページ
        $this->disp('/Lesson/Register/input.php');
    }

    /**
     * レッスン登録確定ページ
     *
     * @return void
     */
    private function complete()
    {
        // POSTデータの取得
        $post = $this->getPost();

        // フォームからの送信チェック
        if (!isset($post['submit'])) {
            header("Location:/");
            return;
        }

        // 項目の入力チェック
        if (!$this->checkPostValue($post)) {
            // 入力内容に不備があった場合再度入力画面表示
            $lesson = array(
                "name"  => $post['lesson_name'],
                "about" => $post['lesson_about'],
                "genre" => $post['lesson_genre'],
                "image" => $post['lesson_image']
            );
            $this->set('lesson', $lesson);
            $this->input();
            return;
        }

        // 入力内容をエスケープ
        $post['lesson_name']  = mysqli_real_escape_string(Controller::escape($post['lesson_name']));
        $post['lesson_about'] = mysqli_real_escape_string(Controller::escape($post['lesson_about']));
        $post['lesson_genre'] = $post['lesson_genre'];

        // 改行コードを改行タグに変換
        $post['lesson_about'] = str_replace(array("\\r\\n", "\\r", "\\n"), "<br>", $post['lesson_about']);
        $post['lesson_about'] = str_replace("&lt;br&gt;", "<br>", $post['lesson_about']);

        // 選択された画像が最後にアップロードされたものでない時
        if (isset($_SESSION['fileName']) && $post['lesson_image'] != $_SESSION['fileName']) {
            if (!(new Lesson())->isUsedImage($_SESSION['fileName'])) {
                // 残っている使われない画像を削除
                echo "<pre>" . var_dump($_SESSION['fileName']) . '/' . $post['fileName'] . "</pre>";
                unlink($this->getSysRoot() . "/htdocs/uploads/{$_SESSION['user_id']}/{$_SESSION['fileName']}");
            }
        }

        // アップロードされたカバー画像の時はパスを設定
        if ($post['cover'] == "custom") {
            $post['lesson_image'] = "/uploads/{$_SESSION['user_id']}/{$post['lesson_image']}";
        }

        // 登録情報のセット
        $data = array('name'       => $post['lesson_name'],
                      'about'      => $post['lesson_about'],
                      'content_id' => $post['lesson_genre'],
                      'image'      => $post['lesson_image'],
                      'created_at' => date('Y-m-d H:i:s'),
                      'user_id'    => $_SESSION['user_id']);

        // 登録実行
        if((new Lesson)->insert($data)) {

            // 登録成功した時、セッションの保存内容をリセット
            unset($_SESSION['lesson_name']);
            unset($_SESSION['lesson_about']);
            unset($_SESSION['lesson_genre']);
            unset($_SESSION['fileName']);

            // 登録完了画面表示
            $this->disp('/Lesson/Register/complete.php');
        } else {
            // 登録失敗時
            echo "なんかしっぱいしてもうたわ";
        }
    }

    /**
     * 必須項目の入力チェック
     *
     * @return boolean
     */
    private function checkPostValue($post)
    {
        try {
            // 必須項目の入力チェック
            if ((!isset($post['lesson_name']) || $post['lesson_name'] == '') ||
                (!isset($post['lesson_about']) || $post['lesson_about'] == '')){
                throw new RuntimeException('未入力の項目があります！');

            // レッスンの名前の文字数チェック
            } else if (mb_strlen($post['lesson_name']) > 15) {
                throw new RuntimeException('名前は15文字以内で入力してください！');

            // レッスンの説明の文字数チェック
            } else if (mb_strlen($post['lesson_about']) > 400) {
                throw new RuntimeException('レッスンの説明は400文字以内で入力してください！');

            // ジャンルの選択チェック
            } else if (!isset($post['lesson_genre']) || $post['lesson_genre'] == '-1') {
                throw new RuntimeException('ジャンルを選択してください！');

            // ファイルの選択チェック
            } else if (!isset($post['lesson_image'])) {
                throw new RuntimeException('カバー画像を選択してください！');
            }
        } catch (RuntimeException $e) {
            // エラーが出た場合メッセージの表示
            $msg = "<h3><font color='red'>" . $e->getMessage() . "</font></h3>";
            $this->set('msg', $msg);
            return false;
        }
        return true;
    }

    /**
     * レッスンのコンタクト申請
     *
     * @return void
     */
    public function contactAction()
    {
        //受講者(送信側)の情報を取得
        $model = new User();
        $sender = $model->get($_SESSION['user_id']);
        $lessonId = $this->getIdFromUrl("/[0-9]+/");

        //講師(受信側)のユーザ情報、レッスン情報を取得
        $recever['user'] = $model->getByLesson($lessonId);
        $model = new Lesson();
        $recever['lesson'] = $model->get($lessonId);

        //コンタクト履歴を保存
        date_default_timezone_set('Asia/Tokyo');
        $model = new Contact();
        $data = array('lesson_id'    => $lessonId,
                      'user_id'      => $sender['facebook_id'],
                      'contacted_at' => date('Y-m-d H:i:s'));

        if(!$model->insert($data)){
            // エラー
            exit;
        }

        // 宛先アドレス
        $to = $recever['user']['email'];
        // 件名
        $subject = $recever['lesson']['name'] . "の受講申請";
        // 本文
        $body = <<<EOT
{$recever['user']['last_name']}さん、こんにちは！
Starport運営チームです！

{$sender['last_name']}さんがあなたの登録しているレッスン"{$recever['lesson']['name']}"の話を聞きたいと、依頼があります。
まずは{$sender['last_name']}さんのプロフィールを見てみましょう。
http://{$_SERVER['HTTP_HOST']}/user/profile/{$sender['facebook_id']}

その後、{$sender['last_name']}さんのプロフィールからFacebookのフレンド依頼をし、Messengerで日時と場所をご相談することをオススメします！

それでは{$sender['last_name']}さんとのお時間を思いっきり楽しんでください！

--------------------------------------------
Starport運営チーム
このメールアドレスは送信専用です。
何かありましたらお問い合わせフォームよりご連絡ください。
お問合せ: http://{$_SERVER['HTTP_HOST']}/info/contact
--------------------------------------------
EOT;
        // メール送信
        (new Mail($to, $subject, $body))->send_mail();
        "<h2>{$recever['user']['name']}さんにメールが送信されました！</h2>" .
        "<p>{$recever['user']['name']}さんからFacebookで連絡が来るのを待っていてください。</p>";
    }
}
