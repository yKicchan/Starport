<?php
/**
 * コンテンツ表を扱うクラス
 *
 * @package     starport
 * @subpackage  Models
 * @author      yKicchan
 */
class Content extends AppModel
{
    /**
     * コンテンツ情報を取得する
     * @param  integer $id コンテンツID
     * @return array      コンテンツ情報
     */
    public function get($id = 0)
    {
        $sql = "SELECT * FROM content";
        if ($id != 0) {
            $sql .= " WHERE `id` = $id";
        }
        $rows = $this->find($sql);
        if ($id != 0){
            return $rows[0];
        }
        return $rows;
    }

    /**
     * ジャンルIDからコンテンツを割り出す
     *
     * @param  integer $id ジャンルID
     * @return array       ジャンルのコンテンツ
     */
    public function getByGenre($id)
    {
        $sql = "SELECT * FROM content WHERE genre_id = $id";
        return $this->find($sql);
    }

    /**
     * ジャンル名とコンテンツ名を結合した名前を返す
     *
     * @return array ジャンル名-コンテンツ名
     */
    public function getZipName($id = 0)
    {
        $sql = "SELECT genre.name AS genreName, content.name AS contentName
                FROM genre, content
                WHERE genre.id = content.genre_id";
        if($id != 0){
            $sql .= " AND content.id = $id";
        }
        $rows = $this->find($sql);
        $names = array();
        foreach ($rows as $row) {
            $names[] = $row['genreName'] . '-' . $row['contentName'];
        }
        if($id != 0){
            return $names[0];
        }
        return $names;
    }
}
