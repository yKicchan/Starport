<?php
/**
 * リクエスト変数抽象クラス
 *
 * @package mvc
 * @author  yKicchan
 */
abstract class Request
{
    /**
     * リクエストのパラメータ値が格納されている
     *
     * @var array
     */
    protected $values;

    /**
     * フィールドの初期化をするコンストラクタ
     */
    public function __construct()
    {
        $this->setValues();
    }

    /**
     * パラメータ値を設定するメソッド
     *
     * @return void
     */
    abstract protected function setValues();

    /**
     * 指定のパラメータ値を返すメソッド
     * キーが指定されなかったらすべてを返す
     * 指定されたキーがなかったらnullを返す
     *
     * @param  string $key キー
     * @return mixed       パラメータ値orNULL
     */
    public function get($key = null)
    {
        if ($key == null) {
            return $this->values;
        }
        if ($this->has($key)) {
            return $this->values[$key];
        }
        return null;
    }

    /**
     * 指定されたキーが存在するかを調べるメソッド
     * 
     * @param  string  $key キー
     * @return boolean      存在するときはtrue、そうでないときはfalse
     */
    public function has($key) { return array_key_exists($key, $this->values); }
}
