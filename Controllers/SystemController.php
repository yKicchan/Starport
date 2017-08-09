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
    public function signInAction()
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
        if (!$this->isAuth()){
            return;
        }

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
        $_SESSION['auth'] = true;

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
        if (!isset($_SESSION['data']) && !$this->isAuth()){
            return;
        }

        // アクセストークン取得
        if (!isset($_SESSION['accessToken'])) {
            $_SESSION['accessToken'] = $this->helper->getAccessToken();

            // ユーザ情報取得
            $response = $this->facebook->get('/me?fields=id,first_name,last_name,email', $_SESSION['accessToken']);
            $user = $response->getGraphUser();
            $photo_url = 'https://graph.facebook.com/' . $user['id'] . '/picture?width=150&height=150';

            // セッションにユーザ情報を保存
            $data = array(
                'facebook_id'        => $user['id'],
                'first_name'         => $user['first_name'],
                'last_name'          => $user['last_name'],
                'email'              => $user['email'],
                'facebook_photo_url' => $photo_url);
            $_SESSION['data'] = $data;
        }

        // ユーザ重複確認
        $model = new User();
        if ($model->isExist($user['id'])) {
            //すでに会員登録されていたらログインしてマイページに遷移
            unset($_SESSION['data']);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_img'] = $photo_url;
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
        $data = $post['data'];
        if ((!isset($data['last_name']) || $data['last_name'] == '') ||
            (!isset($data['first_name']) || $data['first_name'] == '') ||
            (!isset($data['email']) || $data['email'] == '') ||
            (!isset($data['university']) || $data['university'] == '')) {
            $msg = "<h3><font color='red'>必須項目を入力してください！</font></h3>";

            // 利用規約同意チェック
        } else if (!isset($post['confirmation'])) {
            $msg = "<h3><font color='red'>利用規約に同意してください！</font></h3>";

            // メールアドレスの正規表現チェック
        } else if (!preg_match("/^[0-9a-zA-Z_\.\-]+@[0-9a-zA-Z_\-]+\.[0-9a-zA-Z_\.\-]+$/", $data['email'])) {
            $msg = "<h3><font color='red'>正しくメールアドレスを入力してください！</font></h3>";
        }
        // セッションのデータを更新
        foreach ($data as $key => $val) {
            $_SESSION['data'][$key] = $val;
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
        if (!isset($_SESSION['data'])) {
            header("Location:/");
        }
        // 入力情報取得
        $data = $_SESSION['data'];
        unset($_SESSION['data']);

        // 登録実行
        $data['created_at'] = date('Y-m-d H:i:s');
        $model = new User();
        foreach ($data as &$val) {
            $val = $model->escape($val);
        }
        unset($val);
        if (!$model->insert($data)) {
            header("Location:/");
            return;
        }

        // 登録確認メール送信
        $to = $data['email'];
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
        $mail->sendMail("/Signup/{$data['facebook_id']}.txt");

        // ユーザIDとプロフ画像をセッションに保存
        $_SESSION['user_id'] = $data['facebook_id'];
        $_SESSION['user_img'] = $data['facebook_photo_url'];
        $this->disp('/System/Signup/complete.php');
    }

    private function isAuth()
    {
        if (isset($_SESSION['auth'])) {
            unset($_SESSION['auth']);
            return true;
        } else {
            header("Location:/");
            return false;
        }
    }
}
