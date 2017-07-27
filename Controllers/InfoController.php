<?php
/**
 * 主なサイト情報を表示するクラス
 *
 * @package     starport
 * @subpackage  Controllers
 * @author      yKicchan
 */
class InfoController extends AppController
{
    /**
     * 概要ページ
     *
     * @return void
     */
    public function aboutAction() { $this->disp('/Info/about.php'); }

    /**
     * 心構えのページ
     *
     * @return void
     */
    public function attitudeAction() { $this->disp('/Info/attitude.php'); }

    /**
     * 使い方のページ
     *
     * @return void
     */
    public function useAction() { $this->disp('/Info/use.php'); }

    /**
     * プライバシーのページ
     *
     * @return void
     */
    public function privacyAction() { $this->disp('/Info/privacy.php'); }

    /**
     * チームのページ
     *
     * @return void
     */
    public function teamsAction() { $this->disp('/Info/teams.php'); }

    /**
     * 利用規約のページ
     *
     * @return void
     */
    public function termsAction() { $this->disp('/Info/terms.php'); }

    /**
     * コンタクトのページ
     *
     * @return void
     */
    public function contactAction() { $this->disp('/Info/contact.php'); }
}
