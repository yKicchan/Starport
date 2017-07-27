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

    /**
     * DELETE文を実行するメソッド
     *
     * @param  integer $id 行を特定する一意なID
     * @return boolean     クエリ実行結果
     */
    public function delete($id)
    {
        $sql = "DELETE FROM $this->tableName WHERE id = $id";
        $row = $this->query($sql);
        return $row[0];
    }
}
