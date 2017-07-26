<?php
/**
 * メール送信クラス
 *
 * @package     starport
 * @subpackage  Model
 * @author      yKicchan
 */
class Mail {

    /**
     * 宛先
     *
     * @var string
     */
    private $to;

    /**
     * 件名
     *
     * @var string
     */
    private $subject;

    /**
     * 本文
     *
     * @var string
     */
    private $body;

    /**
     * ヘッダ情報
     *
     * @var string
     */
    private $header;

    /**
     * メールのヘッダ情報を設定する
     *
     * @param string $to      宛先
     * @param string $subject 件名
     * @param string $body    本文
     * @param string $from    送信元
     * @param string $cc      カーボンコピー
     * @param string $bcc     ブラインドカーボンコピー
     */
    public function __construct($to, $subject, $body, $from = null, $cc = null, $bcc = null) {

        // 宛先アドレス、件名、本文の設定
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;

        // デフォルトメールヘッダの設定、基本は運営からの送信
        if (!isset($from)) {
            $this->header = "Message-Id: <" . md5(uniqid(microtime())) . "@starportz.com>\n"
                    . "From:" . mb_encode_mimeheader("Starport運営チーム") . "<info@starportz.com>";
        } else {
            // 送信者アドレスの設定
            $this->header = "From:" . $from;
            // Ccが設定されていればヘッダ情報に追加
            if (isset($cc)) {
                $this->header .= "\nCc:" . $cc;
            }
            // Bccが設定されていればヘッダ情報に追加
            if (isset($bcc)) {
                $this->header .= "\nBcc:" . $bcc;
            }
        }
        // 文字コード設定
        mb_language("Ja");
        mb_internal_encoding("UTF-8");
    }

    /**
     * メール送信
     *
     * @param  string $path メールログの書き込み先ファイルパス
     * @return boolean メール送信の結果
     */
    public function sendMail($path) {

        // メール送信
        $result = mb_send_mail($this->to, $this->subject, $this->body, $this->header);
        if ($path) {
            return false;
        }
        // ログ保存
        $data  = "<Send " . (boolval($result) ? "successful" : "failed") . " at>: " . date('Y/m/d H:i:s') . "\n";
        $data .= "<To>: $this->to\n";
        $data .= "<Subject>: $this->subject\n";
        $data .= "<body>:\n\n$this->body\n\n";
        file_put_contents("../Log/Mail" . $path, $data, FILE_APPEND);
        return $result;
    }
}
