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
    public function delete($id)
    {

    }

    public function update($id, $date)
    {

    }

    public function get($id)
    {

    }

    public function getByGenre($id)
    {
        $sql = "SELECT * FROM content WHERE genre_id = $id";
        return $this->query($sql);
    }

    public function getAllZipGenreName()
    {
        $rows = $this->getAll();
        $genre = (new Genre)->getAll();
        foreach ($rows as &$row) {
            foreach ($genre as $g) {
                if($row['genre_id'] == $g['id']){
                    $row['name'] = $g['name'] . '-' . $row['name'];
                }
            }
        }
        unset($row);
        return $rows;
    }

    public function getGenreName($id = 0)
    {
        $sql = "SELECT genre.name AS genreName, content.name AS contentName FROM genre, content WHERE genre.id = content.genre_id";
        if($id != 0){
            $sql .= " AND content.id = $id";
        }
        $rows = $this->query($sql);
        $names = array();
        foreach ($rows as $row) {
            $names[] = $row['genreName'] . '-' . $row['contentName'];
        }
        if($id == 0){
            return $names;
        }
        return $names[0];
    }
}
