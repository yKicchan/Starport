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
    public function indexAction()
    {
        // 人気レッスン、新着レッスンを取得する
        $model = new Lesson();
        $limit = 6;

        $pLesson = $model->getPopularLesson($limit);
        $nLesson = $model->getNewLesson($limit);
        Lesson::delBreak($pLesson, 'about');
        Lesson::delBreak($nLesson, 'about');

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
