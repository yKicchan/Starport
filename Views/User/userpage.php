<!--マイページに書きたいことの見た目ページ-->
<script src="/js/zipText.js"></script>
<script type="text/javascript">
    $(function () {
        $(".lesson-about").each(function(){
            $(this).zipText();
        });
    });
</script>
<div class="container-fluid individual-page">
    <div class="row">
        <div class="col-xs-12 col-sm-4 lecture-profile-wrapper">
            <div class="lecture-box">
                <div class="lecture-profile-image">
                    <img alt="img" src="<?= $data['user']['facebook_photo_url'] ?>"/><!--プロフィール画像取得-->
                </div>
                <h2><?= $data['user']['last_name'] . ' ' . $data['user']['first_name'] ?></h2><!--名前を取得-->
                <p><?= $data['user']['university'] . $data['user']['faculty'] . $data['user']['course'] ?></p>
                <div class="solid"></div>
                <div id="social-icon-profile">
                    <div class="social-color-icon"><a href="https://www.facebook.com/<?= $data['user']['facebook_id']; ?>/"><img alt="img" src="/images/facebook.png"/></a></div>
                    <?php if (isset($data['user']['twitter']) && $data['user']['twitter'] != "") { ?>
                        <div class="social-color-icon"><a href="https://www.twitter.com/<?= $data['user']['twitter'] ?>/"><img alt="img" src="/images/twitter.png"/></a></div>
                    <?php } if (isset($data['user']['instagram']) && $data['user']['instagram'] != "") { ?>
                        <div class="social-color-icon"><a href="https://www.instagram.com/<?= $data['user']['instagram'] ?>/"><img alt="img" src="/images/instagram.png"/></a></div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-8 lecture-wrapper">
            <div class="lecture-box"><!--コンテンツのトップ-->
                <h2><?= $data['user']['phrase']; ?></h2>
                <div class="solid"></div><!--線-->
                <p><?= $data['user']['introduction']; ?></p>
                <div class="solid"></div>
            </div>
            <?php if(count($data['lesson']) > 0) { ?>
                <h3><?= $data['user']['last_name'] ?>さんのレッスン</h3>
                <div class="row">
                    <?php foreach ($data['lesson'] as $lesson){ ?>
                        <div id="profiles" class="mypage-other-lesson">
                            <div class="col-md-4 col-xs-6 col-xxs-12 profile-wrapper">
                                <div class="profile-content">
                                    <a href="/lesson/detail/<?= $lesson['id'] ?>/">
                                        <div class="background-images"><!--背景画像-->
                                            <img alt="img" src="<?= $lesson['image'] ?>"/>
                                            <div class="profile-name" hidden="hidden"><?= $data['user']['last_name'] . $data['user']['first_name'] ?></div>
                                        </div><!--背景画像終わり-->
                                        <div class="profile-text">
                                            <h2 class="lesson-name"><?= $lesson['name'] ?></h2>
                                            <p class="lesson-about"><?= $lesson['about'] ?></p>
                                            <div class="separator"></div>
                                            <p class="lesson-university"><?= $data['user']['university'] ?></p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <h3><?= $data['user']['last_name'] ?>さんのレッスンはまだありません</h3>
            <?php } ?>
        </div>
    </div>
</div>
