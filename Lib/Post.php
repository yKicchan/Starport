<?php
/**
 * POST変数を扱うクラス
 *
 * @package mvc
 * @author  yKicchan
 */
class Post extends Request
{
    /**
     * パラメータ値を設定するメソッド
     */
    protected function setValues()
    {
        foreach ($_POST as $key => $value) {
            $this->values[$key] = $value;
        }
    }
}
