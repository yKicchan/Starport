<?php

/**
 * ユーザ表を扱うクラス
 *
 * @package     starport
 * @subpackage  Models
 * @author      yKicchan
 */
class User extends AppModel
{
    /**
     * UPDATE文を実行するメソッド
     *
     * @param  integer $id   更新するレコードの一意なID
     * @param  array   $data 更新するレコードのデータ
     * @return boolean       クエリ実行結果
     */
    public function update($id, $data)
    {
        $substitution = array();
        foreach ($data as $key => $val) {
            if (empty($val)) {
                $substitution[] = "$key = NULL";
            } else {
                $substitution[] = "$key = '$val'";
            }
        }
        $set = implode(',', $substitution);
        $sql = "UPDATE `user` SET $set WHERE `facebook_id` = '$id'";
        return $this->mysqli->query($sql);
    }

    /**
     * DELETE文を実行するメソッド
     *
     * @param  integer $id 行を特定する一意なID
     * @return boolean     クエリ実行結果
     */
    public function delete($id)
    {
        // IDと一致する行を削除するDELETE文
        $sql = "DELETE FROM user WHERE facebook_id = ${id}";

        // 実行結果
        return $this->query($sql);
    }

    /**
     * 特定のユーザ情報を取得するメソッド
     *
     * @param  integer $id ユーザID
     * @return array       ユーザ情報
     */
    public function get($id)
    {
        $sql = "SELECT * FROM `user` WHERE `facebook_id` = $id";
        $row = $this->query($sql);
        return $row[0];
    }

    /**
     * ユーザが存在するかを判定するメソッド
     *
     * @param  integer $id ユーザID
     * @return boolean     存在していたらtrueを返す、存在しないときはfalse
     */
    public function isExist($id)
    {
        //ユーザー情報を取得
        $rows = $this->get($id);

        //ユーザ情報が存在しているかを返す
        return count($rows) > 0;
    }

    /**
     * レッスンの作成者を取得するメソッド
     * @param  integer $id レッスンID
     * @return array       作成者情報
     */
    public function getByLesson($id)
    {
        $sql = "SELECT * FROM `user` WHERE `facebook_id` = (SELECT `user_id` FROM `lesson` WHERE `id` = $id)";
        $row = $this->query($sql);
        return $row[0];
    }

    /**
     * ユーザ登録処理をするメソッド
     *
     * @param array $info ユーザ情報
     */
    public function Register($info)
    {

    }
}
