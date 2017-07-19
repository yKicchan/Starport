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
    public function delete($id)
    {

    }

    public function update($id, $date)
    {

    }

    public function get($id)
    {

    }

    public function getByUrl($url)
    {
        $sql = "SELECT * FROM genre WHERE url = '$url'";
        $row = $this->query($sql);
        return $row[0];
    }
}
