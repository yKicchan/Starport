<?php
/**
 * モデルの基底クラス
 *
 * @package mvc
 * @author  yKicchan
 */
abstract class Model
{
    /**
     * Mysqliオブジェクト
     *
     * @var Mysqli
     */
    private $mysqli;

    /**
     * 表名
     *
     * @var string
     */
    private $tableName;

    /**
     * mysqliオブジェクトを生成するコンストラクタ
     *
     * @param array $info DB情報
     */
    public function __construct()
    {
        // 表名がないときクラス名から表名を設定する
        if ($this->tableName == null) {
            $this->setTableName();
        }
    }

    /**
     * mysql接続を解放するデストラクタ
     */
    public function __destruct()
    {
        if(isset($this->mysqli)){
            $this->mysqli->close();
        }
    }

    /**
     * DB接続するメソッド
     *
     * @param array $info DB接続情報
     * @return void
     */
    public function initDb($info)
    {
        // mysqliオブジェクトの生成
        $this->mysqli = new mysqli($info['host'],
                                   $info['username'],
                                   $info['passwd'],
                                   $info['dbname']);

        // 接続チェック
        if (mysqli_connect_errno()) {
            print("MySQL Connect Error\nNo : " . mysqli_connect_errno());
            die("<brphp -i | grep 'Debug Build'>Error Message : " . mysqli_connect_error());
        } else {
            // 文字コードをUTF-8に設定
            $this->mysqli->set_charset('utf8');
        }
    }

    /**
     * 表名をクラス名から生成するメソッド
     *
     * @return void
     */
    public function setTableName()
    {
        // クラス名とその文字数を取得
        $className = get_class($this);
        $len = strlen($className);

        // クラス名から表名を生成する
        $tableName = '';
        for ($i = 0; $i < $len; $i++) {

            // 一文字づつ取得して小文字に変換
            $char = substr($className, $i, 1);
            $lower = strtolower($char);

            // 単語のつなぎ(大文字)が来た時は'_'でつなぐ
            if ($i > 0 && $char != $lower) {
                $tableName .= '_';
            }
            $tableName .= $lower;
        }
        // 生成した表名をセット
        $this->tableName = $tableName;
    }

    /**
     * SELECT文を実行するメソッド
     * SELECT文でない時はfalseを返す
     *
     * @param  string $sql SELECT文
     * @return mixed       クエリ実行結果, false
     */
    public function find($sql)
    {
        $rows = array();
        if ($result = $this->mysqli->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
            $result->close();
        }
        return $rows;
    }

    /**
     * INSERT文を実行するメソッド
     *
     * @param  array $data 追加するレコードのデータ
     * @return boolean     クエリ実行結果
     */
    public function insert($data)
    {
        // 列名・値
        $fields = array();
        $values = array();

        // 追加するデータ
        foreach ($data as $key => $value) {
            $fields[] = "`$key`";
            if (is_int($value)) {
                $values[] = $value;
            } else {
                $values[] = "'" . $value . "'";
            }
        }

        // データをカンマで区切る
        $field = implode(', ', $fields);
        $value = implode(', ', $values);

        // データを追加するINSERT文
        $sql = "INSERT INTO `$this->tableName` ($field) VALUES ($value)";
        // 実行結果
        return $this->mysqli->query($sql);
    }

    /**
     * UPDATE文を実行するメソッド
     *
     * @param  integer $id   更新するレコードの一意なID
     * @param  array   $data 更新するレコードのデータ
     * @return boolean       クエリ実行結果
     */
    public function update($id, $data) {
        $substitution = array();
        foreach ($data as $key => $value) {
            if (is_int($value)) {
                $substitution[] = "`$key`=$value";
            } else {
                $substitution[] = "`$key`='$value'";
            }
        }
        $set = implode(',', $substitution);
        $sql = "UPDATE `$this->tableName` SET $set WHERE `id` = $id";
        return $this->mysqli->query($sql);
    }

    /**
     * エスケープ処理
     *
     * @param  string $value エスケープする文字列
     * @return string        エスケープ後の文字列
     */
    public function escape($value)
    {
        return $this->mysqli->real_escape_string($value);
    }

    /**
     * クエリ実行
     *
     * @param  string $sql SQL文
     * @return mixed      クエリ実行結果
     */
    public function query($sql)
    {
        return $this->mysqli->query($sql);
    }
}
