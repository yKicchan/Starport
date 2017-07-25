<?php
session_start();

// エラー表示モード
ini_set( 'display_errors', 1 );

// タイムゾーンを日本に設定
date_default_timezone_set('Asia/Tokyo');

// システムのルートディレクトリパス
define('ROOT_PATH', realpath('/var/www/html/starport'));

// クラスファイルをinclude_pathに追加
$includes = array(ROOT_PATH . '/Lib', ROOT_PATH . '/Models', ROOT_PATH . '/Controllers');
$incPath = implode(PATH_SEPARATOR, $includes);
set_include_path(get_include_path() . PATH_SEPARATOR . $incPath);

/**
 * オートローダーの宣言
 * クラスがない時にこのメソッドが呼ばれる
 *
 * @var string クラス名
 */
spl_autoload_register(function ($class) {

    // Facebookのクラスのとき
    if(strpos($class, 'Facebook') !== false){
        facebook_autoload($class);
        return;
    }
    // 自作クラスの呼び出し
    include_once $class . '.php';
});

/**
 * html特殊文字のエスケープ
 *
 * @param  string $value エスケープ対象
 * @return string        エスケープ処理後
 */
function h($value) { return trim(htmlspecialchars($value, ENT_QUOTES, 'UTF-8')); }

// リクエスト振り分け
$dispatcher = new Dispatcher();
$dispatcher->setSysRoot(ROOT_PATH);
try {
    $dispatcher->dispatch();
} catch (Exception $e) {
    header("HTTP/1.0 404 Not Found");
    $controller = new AppController();
    $controller->disp("/Error/404.php");
}
