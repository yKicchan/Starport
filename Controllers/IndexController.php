<?php
/**
 * トップページを扱うクラス
 *
 * @package     starport
 * @subpackage  Controllers
 * @author      yKicchan
 */
class IndexController extends AppController
{
    /**
     * トップページ
     * 
     * @return void
     */
    public function indexAction()
    {
        // 人気レッスン、新着レッスンを取得する
        $model = new Lesson();
        $limit = 5;
        $pLesson = $model->getPopularLesson($limit);
        $nLesson = $model->getNewLesson($limit);

        // エスケープ処理
        foreach ($pLesson as &$lesson) {
            $lesson['name']  = h($lesson['name']);
            $lesson['about'] = h($lesson['about']);
        }
        foreach ($nLesson as &$lesson) {
            $lesson['name']  = h($lesson['name']);
            $lesson['about'] = h($lesson['about']);
        }
        unset($lesson);

        // 作成者情報取得
        $model = new User();
        $pUser = array();
        $nUser = array();
        foreach ($pLesson as $lesson) {
            $pUser[] = $model->getByLesson($lesson['id']);
        }
        foreach ($nLesson as $lesson) {
            $nUser[] = $model->getByLesson($lesson['id']);
        }

        // Viewと共有するデータをセット
        $this->set('pLesson', $pLesson);
        $this->set('pUser', $pUser);
        $this->set('nLesson', $nLesson);
        $this->set('nUser', $nUser);

        // トップページ表示
        $this->disp('/toppage.php');
    }
}
