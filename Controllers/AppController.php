<?php
/**
 * コントローラクラス
 *
 * @package     starport
 * @subpackage  Controller
 * @author      yKicchan
 */
class AppController extends Controller
{
    /**
     * FacebookAPIを扱うためのオブジェクト
     *
     * @var Facebook
     */
    protected $facebook;

    /**
     * FacebookAPIを使うためのオブジェクト
     *
     * @var FacebookRedirectLoginHelper
     */
    protected $helper;

    /**
     * アプリの初期設定
     */
    public function __construct()
    {
        parent::__construct();
        $this->setViewDir('/Views');

        // ジャンル情報を取得
        $model = new Genre();
        $genre = $model->getAll();
        $model = new Content();
        $content = array(array());
        foreach ($genre as $g) {
            $contents = $model->getByGenre($g['id']);
            foreach ($contents as $c) {
                $content[$g['id']][] = $c;
            }
        }
        $this->set('genre', $genre);
        $this->set('content', $content);

        // 公開ページか
        $url = $_SERVER['REQUEST_URI'];
        if ($this->isPublicPage($url)) {
            unset($_SESSION['url']);
        } else if (!preg_match("/^\/system\/.+$/", $url) && !isset($_SESSION['user_id'])) {
            $_SESSION['url'] = $url;
            header("Location:/system/login/select/");
        }
    }

    /**
     * Viewファイルを読み込みページを表示する
     *
     * @param string $fileName 読み込むファイル名
     */
    public function disp($fileName)
    {
        $data = $this->get();

        $exceptionPages = array('top'   => '/toppage.php',
                                'genre' => '/Lesson/genrepage.php');
        require_once '../Views/header.php';
        if(array_search($fileName, $exceptionPages) !== false){
            require_once '../Views' . $fileName;
        }else{
            require_once '../Views/header-genres.php';
            require_once '../Views' . $fileName;
        }
        require_once '../Views/footer.php';
    }

    /**
     * URLからIDを正規表現抽出するメソッド
     *
     * @return integer ID
     */
    public function getId()
    {
        $id = array();
        preg_match("/[0-9]+/", $_SERVER['REQUEST_URI'], $id);
        return $id[0];
    }

    /**
     * FacebookAPIの初期設定
     *
     * @return void
     */
    protected function setFacebook()
    {
        // Facebook用のオートローダーの呼び出し
        require_once '../Vendor/Facebook/autoload.php';

        // アプリの設定
        require_once '../Config/facebook.php';
        $this->facebook = $info;

        // ヘルパーの生成
        $this->helper = $this->facebook->getRedirectLoginHelper();
    }

    /**
     * 公開ページかどうかを判定する
     * 公開ページとは、ログイン画面、会員登録画面以外の
     * 閲覧にログインが必要でないページのこと
     *
     * @param  string  $url アクセスされてきたURL
     * @return boolean      公開ページならtrue
     */
    private function isPublicPage($url)
    {
        // 公開ページのURLの正規表現
        $patterns = array("/^\/$/",
                          "/^\/ajax\/.+$/",
                          "/^\/info\/.+$/",
                          "/^\/lesson\/genre\/[a-z]+\/$/");
        // 公開ページか判定
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }
        return false;
    }
}
