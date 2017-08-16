<?php
/**
 * ユーザー情報に関するページの処理を行うクラス
 *
 * @package     starport
 * @subpackage  Controllers
 * @author      yKicchan
 */
class UserController extends AppController
{
    /**
     * ユーザプロフィールページ
     *
     * @return void
     */
    public function profileAction()
    {
        // IDのユーザが存在しないならトップページへ
        $model = new User();
        $id = $this->getId();
        if (!$model->isExist($id)) {
            header("Location:" . '/');
            return;
        }

        // プロフィール編集されてきたとき
        $post = $this->getPost();
        if (isset($post['submit'])) {
            // 編集されたユーザIDが自分自身か判定
            if ($id != $_SESSION['user_id']) {
                header("HTTP/1.0 403 Forbidden");
                return;
            }

            // データをエスケープ処理をしてユーザ情報を更新
            foreach ($post['data'] as $key => $val) {
                $post['data'][$key] = $model->escape($val);
            }
            $model->update($id, $post['data']);
        }

        // ユーザ情報を取得
        $user = $model->get($id);
        $model = new Lesson();
        $lesson = $model->getByUser($id);

        // エスケープ
        foreach ($lesson as &$val) {
            $val['name']  = h($val['name']);
            $val['about'] = h($val['about']);
        }

        // Viewと共有するデータをセット
        $this->set('user', $user);
        $this->set('lesson', $lesson);

        // ページを表示
        $this->disp('/User/userpage.php');
    }

    /**
     * 退会
     * @return void
     */
    public function removeAction()
    {
        $model = new User();
        if ($model->delete($_SESSION['user_id'])) {
            header("Location:/system/signout");
        }
    }

    /**
     * プロフィールの編集内容を確定する
     *
     * @param  string $id ユーザーID
     * @return void
     */
    private function editCommit($id)
    {

    }
}
