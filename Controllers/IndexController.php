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
        $userObj = new User();
        $lessonObj = new Lesson();

        // 人気レッスンを6つ取得
        $popularLesson = $lessonObj->getPopularLesson(6);
        Lesson::delBreak($popularLesson, 'about');
        $popularUser = array();
        foreach ($popularLesson as $l) {
            $popularUser[] = $userObj->getByLesson($l['id']);
        }

        // 新着レッスンを6つ取得
        $newLesson = $lessonObj->getNewLesson(6);
        Lesson::delBreak($newLesson, 'about');
        $newUser = array();
        foreach ($newLesson as $l) {
            $newUser[] = $userObj->getByLesson($l['id']);
        }

        // Viewと共有するデータをセット
        $this->set('popularLesson', $popularLesson);
        $this->set('popularUser', $popularUser);
        $this->set('newLesson', $newLesson);
        $this->set('newUser', $newUser);

        $this->disp('/toppage.php');
    }
}
