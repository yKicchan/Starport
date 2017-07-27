<?php
/**
 * ログインに関するページの処理をするクラス
 *
 * @package     starport
 * @subpackage  Controllers
 * @author      yKicchan
 */
class SystemController extends AppController
{
    /**
     * ログインに関するページ
     *
     * @return void
     */
    public function SignInAction()
    {
        // Facebookの初期設定
        $this->setFacebook();

        // パラメータの取得
        $method = $this->getParam();

        // パラメータによって表示するページを決める
        if($method !== false && method_exists($this, $method)) {
            if ($method == "auth") {
                $this->$method('signin', 'login');
            } else{
                $this->$method();
            }
        } else {
            throw new Exception();
        }
    }

    /**
     * ログイン、会員登録を選択するページ
     *
     * @return void
     */
    public function selectAction()
    {
        $this->disp('/System/login.php');
    }

    /**
     * ログイン処理を実行するページ
     *
     * @return void
     */
    private function login()
    {
        // Facebookのユーザ情報を取得
        $response = $this->facebook->get('/me?fields=id', $this->helper->getAccessToken());
        $user = $response->getGraphUser();
        $model = new User();
        if ($model->isExist($user['id'])) {
            $user = $model->get($user['id']);
            $_SESSION['user_id'] = $user['facebook_id'];
            $_SESSION['user_img'] = $user['facebook_photo_url'];

            // 遷移先の設定
            $url = "/user/profile/" . $_SESSION['user_id'] . '/';
            if(isset($_SESSION['url'])){
                $url = $_SESSION['url'];
                unset($_SESSION['url']);
            }
            header("Location:" . $url);
            return;
        } else {
            $this->disp('/System/pleaseSignup.html');
        }
    }

    /**
     * Facebook認証するメソッド
     *
     * @return void
     */
    private function auth($action, $param)
    {
        // リダイレクト先の設定
        $loginUrl = $this->helper->getLoginUrl($this->getHostName() . "/system/{$action}/{$param}/", ['email']);

        // ログインページに遷移
        header("Location:$loginUrl");
    }

    /**
     * ログアウト処理するメソッド
     *
     * @return void
     */
    public function signOutAction()
    {
        // セッションを破棄
        session_destroy();
        // Cookieを無効化
        setcookie('url', '', time() - 1);
        // トップページへ遷移
        header("Location:/");
    }

    /**
     * ユーザ登録ページ
     * @return void
     */
    public function signUpAction()
    {
        // Facebookの初期設定
        $this->setFacebook();

        // パラメータの取得
        $method = $this->getParam();
        // パラメータによって表示するページを決める
        if($method !== false && method_exists($this, $method)) {
            if ($method == "auth") {
                $this->$method('signup', 'input');
            } else{
                $this->$method();
            }
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
        // アクセストークン取得
        if (!isset($_SESSION['accessToken'])) {
            $_SESSION['accessToken'] = $this->helper->getAccessToken();

            // ユーザ情報取得
            $response = $this->facebook->get('/me?fields=id,first_name,last_name,email', $_SESSION['accessToken']);
            $user = $response->getGraphUser();
            $photo_url = 'https://graph.facebook.com/' . $user['id'] . '/picture?width=150&height=150';

            // セッションにユーザ情報を保存
            $_SESSION['fb_id'] = $user['id'];
            $_SESSION['fb_photo_url'] = $photo_url;
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
        }

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
        $this->disp('/System/Signup/input.php');
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
            $this->disp('/System/Signup/input.php');
        } else {
            // 入力内容に不備がなかった場合登録内容確認画面表示
            $this->disp('/System/Signup/confirm.php');
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
            header("Location:/");
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
        $mail->sendMail("/Signup/{$_SESSION['fb_id']}.txt");

        // ユーザIDとプロフ画像をセッションに保存
        $user_id = $_SESSION['fb_id'];
        $image = $_SESSION['fb_photo_url'];
        $_SESSION = array();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_img'] = $image;
        $this->disp('/System/Signup/complete.php');
    }
}
