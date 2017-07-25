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
    public function loginAction()
    {
        // Facebookの初期設定
        $this->setFacebook();

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
     * ログイン、会員登録を選択するページ
     *
     * @return void
     */
    private function select()
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
        $_SESSION['user_id'] = '1711495782511126';
        $_SESSION['user_img'] = 'https://graph.facebook.com/1711495782511126/picture?width=150&amp;height=150';
        $user['id'] = $_SESSION['user_id'];
        // $response = $this->facebook->get('/me?fields=id', $this->helper->getAccessToken());
        // $user = $response->getGraphUser();
        if ((new User)->isExist($user['id'])) {
            // $user = $userObj->get();
            // $_SESSION['user_id'] = $user['facebook_id'];
            // $_SESSION['user_img'] = $user['facebook_photo_url'];

            // 遷移先の設定
            $url = "/user/profile/" . $_SESSION['user_id'] . '/';
            if(isset($_SESSION['url'])){
                $url = $_SESSION['url'];
                unset($_SESSION['url']);
            }
            header("Location:" . $url);
        } else {
            $this->disp('/System/pleaseRegister.html');
        }
    }

    /**
     * Facebook認証するメソッド
     *
     * @return void
     */
    private function auth()
    {
        // リダイレクト先の設定
        $loginUrl = $this->helper->getLoginUrl("http://starport.dev/system/login/login/");

        // ログインページに遷移
        // header("Location:$loginUrl");
        header("Location:/system/login/login/");
    }

    /**
     * ログアウト処理するメソッド
     *
     * @return void
     */
    public function logoutAction()
    {
        // セッションを破棄
        session_destroy();
        // Cookieを無効化
        setcookie('url', '', time() - 1);
        // トップページへ遷移
        header("Location:/");
    }
}
