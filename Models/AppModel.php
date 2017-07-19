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

    /**
     * UPDATE文を実行するメソッド
     *
     * @param  integer $id   更新するレコードの一意なID
     * @param  array   $data 更新するレコードのデータ
     * @return boolean       クエリ実行結果
     */
    public function update($id, $data)
    {
        // SET句の代入式作成
        $substitution = array();
        foreach ($data as $key => $value) {
            $substitution[] = "$key=$value";
        }
        $set = implode(',', $substitution);
        $sql = "UPDATE $this->tableName SET $set WHERE id = $id";
        return $this->query($sql);
    }

    /**
     * IDと一致したレコードを返すメソッド
     *
     * @param  integer $id 行を特定する一意なID
     * @return array       レコード
     */
    public function get($id)
    {
        $sql = "SELECT * FROM $tableName WHERE id = $id";
        $row = $this->query($sql);
        return $row[0];
    }

}
