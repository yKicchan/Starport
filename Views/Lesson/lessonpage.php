<?php
//
// $lesson[] = レッスンと講師の情報が保存されている連想配列
// $other_lesson[][] = 同じジャンルのレッスンが人気順に３つ保存されている2次元連想配列
// $contacted = すでにコンタクトが取られているかがわかる変数、setされていたらコンタクト済である
//
$lesson = $this->get('lesson');
$user = $this->get('user');
$other = $this->get('other');
$isContacted = $this->get('isContacted');
?>
<div class="container-fluid individual-page">
    <div class="row">
        <div class="col-xs-12 col-sm-8 lecture-wrapper">
            <div class="lecture-box"><!--コンテンツのトップ-->
                <h2 class="lecture-title"><?= $lesson['name'] ?></h2>
                <div class="solid"></div><!--線-->
                <div class="lecture-image">
                    <img alt="img" src="<?= $lesson['image'] ?>"/><!--カバー画像取得-->
                </div>
                <div class="solid"></div>
                <div>
                    <?php if(false){ ?>
                    <a class="resister-teacher register-margin lecture-listen" href="/edit-lesson/?id=<?= $lesson['id'] ?>">内容を編集する</a>
                    <?php } else if($isContacted) { ?>
                    <div class="resister-teacher register-margin lecture-listen">申請中</div>
                    <?php } else { ?>
                    <a class="resister-teacher register-margin lecture-listen" href="/lesson/contact/<?= $lesson['id'] ?>" onclick="return confirm('\n<?= $lesson['name'] ?>の話を聞きますか？\nOKを押すと、<?=$user['last_name']?>さん宛にメールが送信されます。')">聞きたい！</a>
                    <?php } ?>
                    <h2 class="lecture-linehight lecture-title">講義について</h2>
                    <p><?= $lesson['about'] ?></p>
                </div>
            </div><!--lecture-box終わり-->
            <!--
            <div class="lecture-box">
                <h2>レビュー</h2>
                <div class="solid"></div>
                <div class="row">
                    <div class="col-xs-3">
                        <div class="review-images" >
                            <img alt="img" src="/images/asao.jpg"/>
                        </div>
                    </div>
                    <div class="col-xs-9">
                        <h3>ヨット別に面白くねーわ！</h3>
                        <p>と思ったけどやっぱりDopeやったわ！</p>
                    </div>
                </div>
            </div>-->
        </div>
        <div class="col-xs-12 col-sm-4 lecture-profile-wrapper">
            <div class="lecture-box">
                <div class="lecture-profile-image">
                    <a href="/user/profile/<?= $user['facebook_id'] ?>/"><img alt="img" src="<?= $user['facebook_photo_url'] ?>"/></a><!--プロフィール画像取得-->
                </div>
                <h2><a href="/user/profile/<?= $user['facebook_id'] ?>"><?= $user['last_name'] . ' ' . $user['first_name'] ?></a></h2><!--名前を取得-->
                <p><?= $user['university'] . $user['faculty'] . $user['course'] ?></p>
                <div class="solid"></div>
                <div id="social-icon-profile">
                    <div class="social-color-icon"><a href="https://www.facebook.com/<?= $user['facebook_id'] ?>/"><img alt="img" src="/images/facebook.png"/></a></div>
                    <?php if ($user['twitter'] != "") { ?>
                        <div class="social-color-icon"><a href="https://www.twitter.com/<?= $user['twitter'] ?>/"><img alt="img" src="/images/twitter.png"/></a></div>
                    <?php } if ($user['instagram'] != "") { ?>
                        <div class="social-color-icon"><a href="https://www.instagram.com/<?= $user['instagram'] ?>/"><img  alt="img" src="/images/instagram.png"/></a></div>
                    <?php } ?>
                </div>
            </div><?php if (isset($other)) { ?>
                <div class="row">
                    <?php foreach ($other as $o) { ?>
                        <div id="profiles" class="mypage-other-lesson">
                            <div class="col-md-4 col-xs-6 col-xxs-12 profile-wrapper">
                                <div class="profile-content"><a href="/lesson/detail/<?= $o['id'] ?>/">
                                        <div class="background-images"><!--背景画像-->
                                            <img alt="img" src="<?= $o['image'] ?>"/>
                                            <div class="profile-images" >
                                                <!--プロフィール画像-->
                                                <img alt="img" src="<?= $o['facebook_photo_url'] ?>"/>
                                            </div>
                                            <div class="profile-name"><?= $o['last_name'] . $o['first_name'] ?></div>
                                        </div><!--背景画像終わり-->
                                        <div class="profile-text">
                                            <h2><?= $o['name'] ?></h2>
                                            <p class="lesson-about"><?= mb_strimwidth(str_replace("<br>", "", $o['about']), 0, 48, '...') ?></p>
                                            <div class="separator"></div>
                                            <p class="lesson-university"><?= mb_strimwidth($les['university'] . '/' . $o['faculty'], 0, 48, '...') ?></p>
                                        </div></a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
