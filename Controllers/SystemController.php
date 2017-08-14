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
     *
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
                $this->$method('signup', 'step01');
            } else{
                $this->$method();
            }
        } else {
            throw new Exception();
        }
    }

    /**
     * プロフィール情報入力
     *
     * @return void
     */
    private function step01()
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
        $this->disp('/System/Signup/step01.php');
    }

    /**
     * 入力情報の確認
     *
     * @return void
     */
    private function step02()
    {
        $post = $this->getPost();
        if (!isset($post['submit']) && !isset($_SESSION['data']['facebook_id'])) {
            header("Location:/");
            return;
        }

        // セッションに入力内容を保存
        if (isset($post['submit'])) {
            foreach ($post['data'] as $key => $val) {
                $_SESSION['data'][$key] = $val;
            }
        }
        $this->disp('/System/Signup/step02.php');
    }

    /**
     * 登録完了
     *
     * @return void
     */
    private function step03()
    {
        $post = $this->getPost();
        if (!isset($post['submit']) && !isset($_SESSION['data']['facebook_id'])) {
            header("Location:/");
            return;
        }
        // 入力情報取得
        $data = $_SESSION['data'];
        unset($_SESSION['data']);

        // 登録実行
        $data['created_at'] = date('Y-m-d H:i:s');
        $model = new User();
        foreach ($data as $key => $val) {
            if (empty($val)) {
                unset($data[$key]);
            } else {
                $data[$key] = $model->escape($val);
            }
        }
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

        $this->set('email', $data['email']);
        $this->disp('/System/Signup/step03.php');
    }

    /**
     * Facebook認証されてきたかどうか
     *
     * @return boolean 認証されてきたらtrue
     */
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
