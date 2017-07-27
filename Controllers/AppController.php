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

    private $publicPages;

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

        // 公開ページの登録
        $this->publicPages[] = '/';
        foreach ($genre as $val) {
            $this->publicPages[] = "/lesson/genre/{$val['url']}/";
        }
        $this->publicPages[] = "/info/attitude/";
        $this->publicPages[] = "/info/use/";
        $this->publicPages[] = "/info/privacy/";
        $this->publicPages[] = "/info/teams/";
        $this->publicPages[] = "/info/terms/";
        $this->publicPages[] = "/info/contact/";

        // 公開ページの時保存している遷移先を削除
        if (in_array($_SERVER['REQUEST_URI'], $this->publicPages)) {
            unset($_SESSION['url']);
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
     * ユーザのログイン状態を調査する
     * ログインされていなければ遷移先を保存してログインページへ遷移
     *
     * @return boolean ログイン状況
     */
    public function checkLoginStatus()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        $_SESSION['url'] = $_SERVER['REQUEST_URI'];
        header("Location:/system/login/select/");
        return false;
    }
}
