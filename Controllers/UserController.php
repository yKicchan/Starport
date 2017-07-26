<?php
/**
 * ユーザー情報に関するページの処理を行うクラス
 *
 * @package     starport
 * @subpackage  Controllers
 * @author      yKicchan
 */
class UserController extends AppController
{
    /**
     * ユーザプロフィールページ
     *
     * @return void
     */
    public function profileAction()
    {
        // IDのユーザが存在しないならトップページへ
        $model = new User();
        $id = $this->getId();
        if (!$model->isExist($id)) {
            header("Location:" . '/');
            return;
        }

        // プロフィール編集されてきたとき
        $post = $this->getPost();
        if (isset($post['edit'])) {
            $this->editCommit($id);
        }

        // ユーザ情報を取得
        $user = $model->get($id);
        $model = new Lesson();
        $lesson = $model->getByUser($id);

        // エスケープ
        foreach ($lesson as &$val) {
            $val['name']  = h($val['name']);
            $val['about'] = h($val['about']);
        }

        // Viewと共有するデータをセット
        $this->set('user', $user);
        $this->set('lesson', $lesson);

        // ページを表示
        $this->disp('/User/userpage.php');
    }

    /**
     * ユーザ登録ページ
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
            throw new Exception();
        }
    }

    /**
     * 情報入力画面
     *
     * @return void
     */
    private function input()
    {
        // Facebookの初期設定
        $this->setFacebook();

        // アクセストークンの取得
        if(isset($_SESSION['accessToken'])){
            // 入力画面表示
            $this->disp('/User/Register/input.php');
            return;
        } else {
            $_SESSION['accessToken'] = $this->helper->getAccessToken();
        }
        // ユーザ情報を取得
        $response = $this->facebook->get('/me?fields=id,first_name,last_name,email', $_SESSION['accessToken']);
        $user = $response->getGraphUser();
        $photo_url = 'https://graph.facebook.com/' . $user['id'] . '/picture?width=150&height=150';

        // セッションにユーザ情報を保存
        $_SESSION['fb_id'] = $user['id'];
        $_SESSION['fb_photo_url'] = $photo_url;
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['email'] = $user['email'];

        // ユーザ重複確認
        if ((new User)->isExist($user['id'])) {
            //すでに会員登録されていたらログインしてマイページに遷移
            $user_id = $_SESSION['fb_id'];
            $user_img = $_SESSION['fb_photo_url'];
            $_SESSION = array();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_img'] = $user_img;
            header("Location:/user/profile/{$_SESSION['user_id']}");
            return;
        }
        $this->disp('/User/Register/input.php');
    }

    /**
     * 入力情報確認画面
     *
     * @return void
     */
    private function confirm()
    {
        // 不正アクセス対策
        $post = $this->getPost();
        if (!isset($post['submit'])) {
            header("Location:/");
            return;
        }

        // 必須項目の入力チェック
        if ((!isset($post['last_name']) || $post['last_name'] == '') ||
                (!isset($post['first_name']) || $post['first_name'] == '') ||
                (!isset($post['email']) || $post['email'] == '') ||
                (!isset($post['university']) || $post['university'] == '') ||
                (!isset($post['faculty']) || $post['faculty'] == '') ||
                (!isset($post['introduction']) || $post['introduction'] == '')) {
            $msg = "<h3><font color='red'>必須項目を入力してください！</font></h3>";

            // 利用規約同意チェック
        } else if (!isset($post['confirmation'])) {
            $msg = "<h3><font color='red'>利用規約に同意してください！</font></h3>";

            // メールアドレスの正規表現チェック
        } else if (!preg_match("/^[0-9a-zA-Z_\.\-]+@[0-9a-zA-Z_\-]+\.[0-9a-zA-Z_\.\-]+$/", $post['email'])) {
            $msg = "<h3><font color='red'>正しくメールアドレスを入力してください！</font></h3>";
        }

        // 入力内容をエスケープ
        $model = new AppModel();
        foreach ($post as $key => $val) {
            $_SESSION[$key] = $model->escape($val);
        }

        // 入力内容に不備があった場合再度入力画面表示
        if (isset($msg)) {
            $this->set('msg', $msg);
            $this->disp('/User/Register/input.php');
        } else {
            // 入力内容に不備がなかった場合登録内容確認画面表示
            $this->disp('/User/Register/confirm.php');
        }
    }

    /**
     * 登録完了画面
     *
     * @return void
     */
    private function complete()
    {
        // Facebook連携チェック
        if ($_SESSION['fb_id'] == '' || !isset($_SESSION['fb_id'])) {
            return;
        }

        // 登録
        $data = array('facebook_id' => $_SESSION['fb_id'],
                      'last_name'   => $_SESSION['last_name'],
                      'first_name'  => $_SESSION['first_name'],
                      'email'       => $_SESSION['email'],
                      'university'  => $_SESSION['university'],
                      'faculty'     => $_SESSION['faculty'],
                      'course'      => $_SESSION['course'],
                      'phrase'      => $_SESSION['phrase'],
                      'introduction'=> $_SESSION['introduction'],
                      'twitter'     => $_SESSION['twitter'],
                      'instagram'   => $_SESSION['instagram'],
                      'created_at'  => date('Y-m-d H:i:s'),
                      'facebook_photo_url' => $_SESSION['fb_photo_url']);

        if (!(new User)->insert($data)) {
        }
        // 登録確認メール送信
        $to = $_SESSION['email'];
        $subject = "Starportcomへようこそ！";
        $host = $this->getHostName();
        $body = <<<EOT
ユーザ登録が完了しました！

まずは、自分の興味のあるレッスンを見つけてみませんか？
Starportでは、あなたの好みにあったジャンルのレッスンを見つけることができます。
スキルを交換して、自分の新しい力を引き出しましょう！！

もちろん、あなた自身もレッスンを開講することができます。
{$host}/lesson/register

※レッスンの開講にはメールアドレスの確認が必要です。
下記リンクにアクセスして、認証を完了してください。
{$host}/confirm-mail?type=confirm

---------------------------------------------
Starport運営チーム
このメールアドレスは送信専用です。
何かありましたらお問い合わせフォームよりご連絡ください。
お問合せ: {$host}/info/contact
---------------------------------------------
EOT;
        $mail = new Mail($to, $subject, $body);
        $mail->send_mail();

        // ユーザIDとプロフ画像をセッションに保存
        $user_id = $_SESSION['fb_id'];
        $image = $_SESSION['fb_photo_url'];
        $_SESSION = array();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_img'] = $image;
        $this->disp('/User/Register/complete.php');
    }

    /**
     * プロフィールの編集内容を確定する
     *
     * @param  string $id ユーザーID
     * @return void
     */
    private function editCommit($id)
    {
        // 編集されたユーザIDが自分自身か判定
        if ($id != $_SESSION['user_id']) {
            header("HTTP/1.0 403 Forbidden");
            return;
        }

        // データをエスケープ処理をしてユーザ情報を更新
        $post = $this->getPost();
        $model = new User();
        $post['last_name']    = $model->escape($post['last_name']);
        $post['first_name']   = $model->escape($post['first_name']);
        $post['university']   = $model->escape($post['university']);
        $post['faculty']      = $model->escape($post['faculty']);
        $post['course']       = $model->escape($post['course']);
        $post['introduction'] = $model->escape($post['introduction']);
        $post['phrase']       = $model->escape($post['phrase']);

        $data = array('last_name'    => $post['last_name'],
                      'first_name'   => $post['first_name'],
                      'university'   => $post['university'],
                      'faculty'      => $post['faculty'],
                      'course'       => $post['course'],
                      'introduction' => $post['introduction'],
                      'phrase'       => $post['phrase']);

        $model->update($id, $data);
    }
}
