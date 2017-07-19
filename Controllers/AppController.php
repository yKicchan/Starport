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
        $this->setNotFoundPath('/404.php');

        $genre = (new Genre())->getAll();
        $contentObj = new Content();
        $content = array(array());
        foreach ($genre as $g) {
            $contents = $contentObj->getByGenre($g['id']);
            foreach ($contents as $c) {
                $content[$g['id']][] = $c;
            }
        }
        $this->set('genre', $genre);
        $this->set('content', $content);
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
        require_once '/var/www/html/starport' . '/Views/header.php';
        if(array_search($fileName, $exceptionPages) !== false){
            require_once '/var/www/html/starport' . '/Views' . $fileName;
        }else{
            require_once '/var/www/html/starport' . '/Views/header-genres.php';
            require_once '/var/www/html/starport' . '/Views' . $fileName;
        }
        require_once '/var/www/html/starport' . '/Views/footer.php';
    }

    /**
     * URLからIDを正規表現抽出するメソッド
     *
     * @return integer ID
     */
    public function getIdFromUrl($pattern)
    {
        $id = array();
        preg_match($pattern, $_SERVER['REQUEST_URI'], $id);
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
     * サイトのURLを返す
     * @return string URL
     */
    public function getHostName() { return "http://starport.dev"; }
}
