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
        if (isset($post['edit'])) {
            $this->editCommit($id);
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
     * プロフィールの編集内容を確定する
     *
     * @param  string $id ユーザーID
     * @return void
     */
    private function editCommit($id)
    {
        // 編集されたユーザIDが自分自身か判定
        if ($id != $_SESSION['user_id']) {
            header("HTTP/1.0 403 Forbidden");
            return;
        }

        // データをエスケープ処理をしてユーザ情報を更新
        $post = $this->getPost();
        $model = new User();
        $post['last_name']    = $model->escape($post['last_name']);
        $post['first_name']   = $model->escape($post['first_name']);
        $post['university']   = $model->escape($post['university']);
        $post['faculty']      = $model->escape($post['faculty']);
        $post['course']       = $model->escape($post['course']);
        $post['introduction'] = $model->escape($post['introduction']);
        $post['phrase']       = $model->escape($post['phrase']);

        $data = array('last_name'    => $post['last_name'],
                      'first_name'   => $post['first_name'],
                      'university'   => $post['university'],
                      'faculty'      => $post['faculty'],
                      'course'       => $post['course'],
                      'introduction' => $post['introduction'],
                      'phrase'       => $post['phrase']);

        $model->update($id, $data);
    }
}
