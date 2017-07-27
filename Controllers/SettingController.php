<?php
/**
 * ユーザの設定に関するページを扱うクラス
 *
 * @package     starport
 * @subpackage  Controller
 * @author      yKicchan
 */
class SettingController extends AppController
{
    /**
     * ユーザのプロフィールを編集するページ
     *
     * @return void
     */
    public function profileAction()
    {
        // ログインチェック
        if (!$this->checkLoginStatus()) {
            return;
        }

        $model = new User();
        $user = $model->get($_SESSION['user_id']);
        $this->set('user', $user);
        $this->disp('/Setting/profile.php');
    }

    /**
     * 作成したレッスンが一覧表示されるページ
     * レッスンを選択して編集ページにジャンプできる
     *
     * @return void
     */
    public function lessonAction()
    {
        // ログインチェック
        if (!$this->checkLoginStatus()) {
            return;
        }

        // 作成されたレッスンの一覧を表示
        $model = new Lesson();
        $lesson = $model->getByUser($_SESSION['user_id']);
        foreach ($lesson as &$val) {
            $val['name']  = h($val['name']);
            $val['about'] = h($val['about']);
        }
        $this->set('lesson', $lesson);
        $this->disp("/Setting/lesson.php");
    }

    /**
     * ユーザのアカウントの設定ができるページ
     * メールアドレスなどの個人情報はここで設定できる
     *
     * @return void
     */
    public function accountAction()
    {
        // ログインチェック
        if (!$this->checkLoginStatus()) {
            return;
        }
        $this->disp('/Setting/account.php');
    }

    /**
     * 外部アプリケーションの設定ができるページ
     * TwitterやInstagramの連携・解除はここでできる予定
     *
     * @return void
     */
    public function applicationAction()
    {
        // ログインチェック
        if (!$this->checkLoginStatus()) {
            return;
        }
        $this->disp('/Setting/application.php');
    }
}
