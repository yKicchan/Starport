<?php
/**
 * リクエストの振り分けを行うクラス
 *
 * @package mvc
 * @author  yKicchan
 */
class Dispatcher
{
    /**
     * システムのルートディレクトリ
     *
     * @var string
     */
    private $sysRoot;

    /**
     * システムの初期設定をするコンストラクタ
     */
    public function __construct() { $this->setSysRoot(); }

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
     * URLパラメータからの振り分け処理
     */
    public function dispatch()
    {
        // URLパラメータの取得
        $params = $this->getParams();

        // パラメータからコントローラのクラス名を取得
        $className = $this->getClassName($params);

        // インスタンス生成
        $controller = new $className();

        // コントローラにシステムルートを渡しておく
        $controller->setSysRoot($this->sysRoot);

        // アクションメソッド取得
        $action = $this->getMethodName($params, $controller);

        // パラメータをコントローラクラスにセット
        $controller->setParams($params);

        // アクションメソッド実行
        $controller->$action();
    }

    /**
     * URLパラメータを分割して返すメソッド
     *
     * @return array 分割されたURLパラメータ
     */
    private function getParams()
    {
        // パラメータの取得
        $url = $_GET['url'];

        // 宛先が指定されていたらそこのURLを使う
        if(isset($_SESSION['url'])){
            $url = $_SESSION['url'];
            unset($_SESSION['url']);
        }

        // 末尾の"/"を削除
        $param = preg_replace("/\/?$/", '', $url);

        // パラメータを "/" で分割して配列に格納
        $params = array();
        if ($param != '') {
            $params = explode('/', $param);
        }
        return $params;
    }

    /**
     * 受け取ったパラメータからコントローラのクラス名を生成するメソッド
     *
     * @param  array $params URLパラメータ
     * @return string        コントローラのクラス名
     */
    private function getClassName($params)
    {
        // 1番目のパラメータをコントローラ名として取得
        $controller = 'index';
        if (count($params) > 0) {
            $controller = $params[0];
        }

        // コントローラークラス名を生成
        $className = ucfirst(strtolower($controller)) . 'Controller';

        // クラスの存在確認、なければ404
        if(!class_exists($className)){
            throw new Exception('Not Found');
        }
        return $className;
    }

    /**
     * 受け取ったURLパラメータからアクションメソッド名を返すメソッド
     *
     * @param  array $params URLパラメータ
     * @return string        アクションメソッド名
     */
    private function getMethodName($params, $controller)
    {
        // 2番目のパラメーターをアクション名として取得
        $action= 'index';
        if (count($params) > 0) {
            $action= $params[1];
        }

        // アクションメソッド名を生成
        $methodName = $action . 'Action';

        // メソッドの存在確認、なければ404
        if (!method_exists($controller, $methodName)) {
            throw new Exception('Not Found');
        }
        return $methodName;
    }
}
