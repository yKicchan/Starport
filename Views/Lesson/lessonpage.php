<script type="text/javascript">
    var lessonId = <?= json_encode($data['lesson']['id']) ?>;
    var lessonName = <?= json_encode($data['lesson']['name']) ?>;
    var userName = <?= json_encode($data['user']['last_name']) ?>;
</script>
<script src="/js/ajaxContact.js" charset="utf-8"></script>
<div class="container-fluid individual-page">
    <div class="row">
        <div class="col-xs-12 col-sm-8 lecture-wrapper">
            <div class="lecture-box"><!--コンテンツのトップ-->
                <h2 class="lecture-title"><?= $data['lesson']['name'] ?></h2>
                <div class="solid"></div><!--線-->
                <div class="lecture-image">
                    <img alt="img" src="<?= $data['lesson']['image'] ?>"/><!--カバー画像取得-->
                </div>
                <div class="solid"></div>
                <div>
                    <?php if($data['user']['facebook_id'] == $_SESSION['user_id']){ ?>
                    <a class="resister-teacher register-margin lecture-listen" href="/lesson/edit/<?= $data['lesson']['id'] ?>/">内容を編集する</a>
                    <?php } else if($data['isContacted']) { ?>
                    <div class="resister-teacher register-margin lecture-listen">申請中</div>
                    <?php } else { ?>
                    <div id="contact" class="resister-teacher register-margin lecture-listen" href="/ajax/contact/<?= $data['lesson']['id'] ?>/">聞きたい！</div>
                    <?php } ?>
                    <h2 class="lecture-linehight lecture-title">講義について</h2>
                    <p><?= $data['lesson']['about'] ?></p>
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
                    <a href="/user/profile/<?= $data['user']['facebook_id'] ?>/"><img alt="img" src="<?= $data['user']['facebook_photo_url'] ?>"/></a><!--プロフィール画像取得-->
                </div>
                <h2><a href="/user/profile/<?= $data['user']['facebook_id'] ?>"><?= $data['user']['last_name'] . ' ' . $data['user']['first_name'] ?></a></h2><!--名前を取得-->
                <p><?= $data['user']['university'] . $data['user']['faculty'] . $data['user']['course'] ?></p>
                <div class="solid"></div>
                <div id="social-icon-profile">
                    <div class="social-color-icon"><a href="https://www.facebook.com/<?= $data['user']['facebook_id'] ?>/"><img alt="img" src="/images/facebook.png"/></a></div>
                    <?php if ($data['user']['twitter'] != "") { ?>
                        <div class="social-color-icon"><a href="https://www.twitter.com/<?= $data['user']['twitter'] ?>/"><img alt="img" src="/images/twitter.png"/></a></div>
                    <?php } if ($data['user']['instagram'] != "") { ?>
                        <div class="social-color-icon"><a href="https://www.instagram.com/<?= $data['user']['instagram'] ?>/"><img  alt="img" src="/images/instagram.png"/></a></div>
                    <?php } ?>
                </div>
            </div><?php if (isset($data['other'])) { ?>
                <div class="row">
                    <?php foreach ($data['other'] as $o) { ?>
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
