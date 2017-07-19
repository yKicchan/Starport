<?php
/**
 *
 */
class Contact extends AppModel
{
    /**
     * コンタクト情報を取得する
     * @param  integer $lessonId レッスンID
     * @param  integer $userId   ユーザID
     * @return void
     */
    public function get($lessonId, $userId)
    {
        $sql = "SELECT * FROM contact WHERE lesson_id = $lessonId AND user_id = $userId";
        $row = $this->query($sql);
        return $row[0];
    }

    /**
     * コンタクト履歴があるかどうかを判定する
     * @param  integer  $lessonId レッスンID
     * @param  integer  $userId   ユーザID
     * @return boolean            true or false
     */
    public function isContacted($lessonId, $userId)
    {
        //コンタクト情報を取得
        $rows = $this->get($lessonId, $userId);

        //コンタクト履歴があったかを返す
        return count($rows) > 0;
    }
}
