<?php
/**
 * モデルクラス
 *
 * @package     starport
 * @subpackage  Model
 * @author      yKicchan
 */
class AppModel extends Model
{
    /**
     * DBの初期設定をするコンストラクタ
     */
    public function __construct()
    {
        // 親クラスのコンストラクタ実行
        parent::__construct();

        // DBの設定
        require '../Config/database.php';
        $this->initDb($info);
    }
}
