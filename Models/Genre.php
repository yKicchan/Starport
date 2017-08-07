<?php
/**
 * ジャンル表を扱うクラス
 *
 * @package     starport
 * @subpackage  Models
 * @author      yKicchan
 */
class Genre extends AppModel
{
    /**
    * ジャンル情報を取得するメソッド
    *
    * @param  integer $id ジャンルID
    * @return array       ジャンル情報
    */
    public function get($id = 0)
    {
        $sql = "SELECT * FROM `genre`";
        if ($id != 0) {
            $sql .= " WHERE `id` = $id";
        }
        $row = $this->find($sql);
        if ($id != 0) {
            return $row[0];
        }
        return $row;
    }

    /**
     * URL文字列から一致するジャンル情報を抽出する
     *
     * @param  string $url URL文字列
     * @return array      ジャンル情報
     */
    public function getByUrl($url)
    {
        $sql = "SELECT * FROM genre WHERE url = '$url'";
        $row = $this->find($sql);
        return $row[0];
    }
}
