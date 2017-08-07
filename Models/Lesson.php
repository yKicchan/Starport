<?php

/**
 * レッスン表を扱うクラス
 *
 * @package     starport
 * @subpackage  Models
 * @author      yKicchan
 */
class Lesson extends AppModel
{
    /**
     * DELETE文を実行するメソッド
     *
     * @param  integer $id 行を特定する一意なID
     * @return boolean     クエリ実行結果
     */
    public function delete($id)
    {
        // IDと一致する行を削除するDELETE文
        $sql = "DELETE FROM lesson WHERE id = $id";

        // 実行結果
        return $this->query($sql);
    }

    /**
     * レッスンの情報を取得するメソッド
     *
     * @param  integer $id レッスンID
     * @return array       レッスン情報
     */
    public function get($id)
    {
        $sql = "SELECT * FROM lesson WHERE id = $id";
        $row = $this->find($sql);
        return $row[0];
    }

    /**
     * レッスンを作成者で絞り込み抽出するメソッド
     *
     * @param  integer $id ユーザID
     * @return array       レッスン情報
     */
    public function getByUser($id)
    {
        $sql = "SELECT * FROM lesson, user WHERE user_id = $id AND user_id = facebook_id";
        return $this->find($sql);
    }

    /**
     * レッスンをジャンルで絞り込み抽出するメソッド
     *
     * @param  integer $id     ジャンルID
     * @param  integer $limit  取得件数
     * @param  integer $offset 開始位置
     * @return array           レッスン情報
     */
    public function getByGenre($id, $limit = 20, $offset = 0)
    {
        $sql = "SELECT * FROM lesson WHERE content_id DIV 1000 = $id DIV 1000 LIMIT $limit OFFSET $offset";
        return $this->find($sql);
    }

    /**
     * レッスンをコンテンツで絞り込み抽出するメソッド
     *
     * @param  integer $id コンテンツID
     * @return array       レッスン情報
     */
    public function getByContent($id)
    {
        $sql = "SELECT * FROM lesson WHERE content_id = $id";
        return $this->find($sql);
    }

    /**
     * レッスンを新着順に抽出するメソッド
     *
     * @param  integer $limit 上限値
     * @return array          レッスン情報
     */
    public function getNewLesson($limit = 1)
    {
        $sql = "SELECT * FROM lesson ORDER BY created_at DESC LIMIT $limit";
        return $this->find($sql);
    }

    /**
     * レッスンを人気順に抽出するメソッド
     *
     * @param  integer $limit 上限値
     * @return array          レッスン情報
     */
    public function getPopularLesson($limit = 1)
    {
        $sql = "SELECT * FROM lesson ORDER BY count DESC LIMIT $limit";
        return $this->find($sql);
    }

    /**
     * 画像がすでに使用されているかを判定するメソッド
     *
     * @param  string   $fileName ファイル名
     * @return boolean
     */
    public function isUsedImage($fileName)
    {
        $sql = "SELECT id FROM lesson WHERE image = '/uploads/{$_SESSION['user_id']}/$fileName'";
        $rows = $this->find($sql);
        return count($rows) > 0;
    }
}
