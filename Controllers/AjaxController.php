<?php
/**
 * 非同期通信処理クラス
 *
 * @package     starport
 * @subpackage  Controller
 * @author      yKicchan
 */
class AjaxController extends AppController
{
    /**
     * コンストラクタ
     * Content-TypeをJSON形式に設定しておく
     */
    public function __construct()
    {
        parent::__construct();
        if (!$this->isAjax()) {
            http_response_code(400);
            die("Ajaxで通信しなさい");
        }
        header('Content-Type: application/json');
    }

    /**
     * Ajaxによる通信かどうかを判定
     *
     * @return boolean True or False
     */
    public function isAjax() { return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'; }

    /**
     * ファイルをアップロードするメソッド
     * 保存結果を出力する
     *
     * @return void
     */
    public function fileUploadAction()
    {
        $fileName = '';
        try {
            // ファイルの保存処理
            $fileName = $this->saveFile();
        } catch (RuntimeException $e) {
            // エラーが出た時はメッセージを返す
            http_response_code(400);
            echo $e->getMessage();
            return;
        }
        // パスがセッションに残っていたらそのパスのファイルは使われないので削除する
        if (isset($_SESSION['fileName']) && $_SESSION['fileName'] != $fileName) {
            if (!(new Lesson)->isUsedImage($_SESSION['fileName'])) {
                unlink($this->getSysRoot() . "/htdocs/uploads/{$_SESSION['user_id']}/{$_SESSION['fileName']}");
            }
        }
        // セッションにファイルを保存
        $_SESSION['fileName'] = $fileName;

        // ファイルの保存先のパスを返す
        $response['fileName'] = $fileName;
        echo json_encode($response);
    }

    /**
     * ファイルを保存する
     *
     * @return string 保存したファイルのパス
     */
    private function saveFile()
    {
        // ファイルのエラーチェック
        if (!isset($_FILES['file']['error']) || !is_int($_FILES['file']['error'])) {
            throw new RuntimeException("エラーが発生しました");
        }
        // $_FILES['file']['error'] の値を確認
        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK: // OK
                break;
            case UPLOAD_ERR_NO_FILE:   // ファイル未選択
                throw new RuntimeException('ファイルが選択されていません');
            case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
            case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過
                throw new RuntimeException('ファイルサイズが大きすぎます');
            default:
                throw new RuntimeException('その他のエラーが発生しました');
        }
        // 定義サイズチェック(2MB)
        if($_FILES['file']['size'] > 2000000){
            throw new RuntimeException('ファイルサイズが大きすぎます');
        }
        // mimeタイプのチェック
        $path = $_FILES['file']['tmp_name'];
        $mime = preg_replace("/ [^ ]*/", "", trim(shell_exec('file -bi ' . escapeshellcmd($path))));
        // 許可する拡張子のリスト
        $extensions = array(
            'jpeg' => 'image/jpeg;',
            'jpg'  => 'image/jpg;',
            'png'  => 'image/png;',
            'gif'  => 'image/gif;',
            'bmp'  => 'image/bmp;',
            'psd'  => 'image/x-photoshop;'
        );
        $ext = array_search($mime, $extensions);
        if($ext === false){
            throw new RuntimeException($mime);
        }

        $fileName = sprintf('%s.%s', sha1_file($_FILES['file']['tmp_name']), $ext);

        // ファイルを保存する
        $dir = $this->getSysRoot() . "/htdocs/uploads/{$_SESSION['user_id']}/";
        if(!file_exists($dir)){
            mkdir($dir, 0755);
        }
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $dir . $fileName)) {
            throw new RuntimeException('ファイル保存時にエラーが発生しました');
        }
        chmod($dir . $fileName, 0744);
        return $fileName;
    }

    /**
     * レッスン情報を取得する
     *
     * @return void
     */
    public function getLessonAction()
    {
        // パラメータのチェック
        $get = $this->getGet();
        if (!isset($get['genre'])) {
            http_response_code(400);
            return;
        }
        if (!isset($get['limit'])) {
            $get['limit'] = 20;
        }
        if (!isset($get['offset'])) {
            $get['offset'] = 0;
        }

        // レッスン情報の取得
        $model = new Genre();
        $get['genre'] = $model->getByUrl($get['genre']);
        $model = new Lesson();
        $lesson = $model->getByGenre($get['genre']['id'], $get['limit'], $get['offset']);
        $model = new User();
        $user = array();
        foreach ($lesson as $l) {
            $user[] = $model->getByLesson($l['id']);
        }
        $result = array('lesson' => $lesson,
                        'user'   => $user);
        echo json_encode($result);
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
        $lessonId = intval($this->getIdFromUrl("/[0-9]+/"));

        //講師(受信側)のユーザ情報、レッスン情報を取得
        $recever['user'] = $model->getByLesson($lessonId);
        $model = new Lesson();
        $recever['lesson'] = $model->get($lessonId);

        // 宛先アドレス
        $to = $recever['user']['email'];
        // 件名
        $subject = $recever['lesson']['name'] . "の受講申請";
        // 本文
        $host = $this->getHostName();
        $body = <<<EOT
{$recever['user']['last_name']}さん、こんにちは！
Starport運営チームです！

{$sender['university']}の{$sender['last_name']}さんが、あなたの登録しているレッスン"{$recever['lesson']['name']}"の話を聞きたいと、依頼があります。
まずは{$sender['last_name']}さんのプロフィールを見てみましょう。
{$host}/user/profile/{$sender['facebook_id']}

その後、{$sender['last_name']}さんのプロフィールからFacebookのフレンド依頼をし、Messengerで日時と場所をご相談することをオススメします！

それでは{$sender['last_name']}さんとのお時間を思いっきり楽しんでください！

--------------------------------------------
Starport運営チーム
このメールアドレスは送信専用です。
何かありましたらお問い合わせフォームよりご連絡ください。
お問合せ: {$host}/info/contact
--------------------------------------------
EOT;
        // メール送信
        $mail = new Mail($to, $subject, $body);
        if (!$mail->sendMail("../Log/Mail/$lessonId.txt")) {
            http_response_code(400);
            $response = "メールの送信に失敗しました";
            echo json_encode($response);
            return;
        }

        //コンタクト履歴を保存
        $model = new Contact();
        $data = array('lesson_id'    => $lessonId,
                      'user_id'      => $sender['facebook_id'],
                      'contacted_at' => date('Y-m-d H:i:s'));
        if(!$model->insert($data)){
            http_response_code(500);
            echo json_encode("MYSQL error");
            return;
        }
        $response  = "<h2>{$recever['user']['name']}さんにメールが送信されました！</h2>";
        $response .= "<p>{$recever['user']['name']}さんからFacebookで連絡が来るのを待っていてください。</p>";
        echo json_encode($response);
    }
}
