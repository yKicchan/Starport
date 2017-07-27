<?php
/**
 * コントローラの基底クラス
 *
 * @package     mvc
 * @author      yKicchan
 */
abstract class Controller
{
    /**
     * Viewとデータを共有するための変数
     *
     * @var array
     */
    private $data;

    /**
     * POST変数
     *
     * @var Post
     */
    private $post;

    /**
     * GET変数
     *
     * @var Get
     */
    private $get;

    /**
     * システムのルートディレクトリ
     *
     * @var string
     */
    private $sysRoot;

    /**
     * Viewのディレクトリパス
     *
     * @var string
     */
    private $viewDir;

    /**
     * 3つ目以降のURLパラメータ
     *
     * @var array
     */
    private $params;

    /**
     * フィールドを初期化するコンストラクタ
     */
    public function __construct()
    {
        $this->post = new Post();
        $this->get = new Get();
        $this->data = array();
        $this->params = array();
    }

    /**
     * Viewと共有するデータをセットするメソッド
     *
     * @param string $key  キー
     * @param mixed $value 値
     */
    public function set($key, $value) { $this->data[$key] = $value; }

    /**
     * Viewと共有するデータを返すメソッド
     *
     * @param string $key キー
     * @return array      共有データ
     */
    public function get($key = null)
    {
        if($key == null){
            return $this->data;
        }
        return $this->data[$key];
    }

    /**
     * POST送信されてきたデータを返すメソッド
     *
     * @param  string $key キー
     * @return mixed       POST送信されてきたデータ
     */
    public function getPost($key = null) { return $this->post->get($key); }

    /**
     * GET送信されてきたデータを返すメソッド
     * @param  string $key キー
     * @return mixed       GET送信されてきたデータ
     */
    public function getGet($key = null) { return $this->get->get($key); }

    /**
     * システムのルートを設定する、デフォルトは/var/www/html
     *
     * @param string $path システムルートのパス
     */
    public function setSysRoot($path = "/var/www/html") { $this->sysRoot = $path; }

    /**
     * システムのルートを返す
     *
     * @return string システムルート
     */
    public function getSysRoot() { return $this->sysRoot; }

    /**
     * Viewのディレクトパスを設定できるセッター
     *
     * @param string $path Viewのディレクトリパス
     */
    public function setViewDir($path) { $this->viewDir = $this->getSysRoot() . $path; }

    /**
     * Viewのディレクトリパスを返す
     * @return string Viewのディレクトリパス
     */
    public function getViewDir() { return $this->viewDir; }

    /**
     * Viewファイルを読み込みページを表示する
     *
     * @param string $fileName 読み込むファイル名
     */
    public abstract function disp($fileName);

    /**
     * 分割された３つ目以降のURLパラメータをセットするメソッド
     * @param array $params URLパラメータ
     */
    public function setParams($params)
    {
        for ($i = 2; $i < count($params); $i++) {
            $this->params[$i - 2] = $params[$i];
        }
    }

    /**
     * インデックスで指定されたパラメータを返す
     * パラメータが存在しない時はfalseを返す
     *
     * @param  integer $index パラメータの場所
     * @return mixed          パラメータ、false
     */
    public function getParam($index = 0)
    {
        if (isset($this->params[$index])) {
            return $this->params[$index];
        }
        return false;
    }

    /**
     * サイトのURLを返す(http://exam.com)
     *
     * @return string URL
     */
    public function getHostName() { return (isset($_SERVER['HTTPS']) ? "https" : "http" ) . "://{$_SERVER['HTTP_HOST']}"; }


    /**
     * HTML特殊文字のエスケープ処理
     *
     * @param  string $str エスケープ処理する文字列
     * @return string      エスケープ処理した文字列
     */
    public static function escape($str) { return trim(htmlspecialchars($str, ENT_QUOTES, 'UTF-8')); }
}
