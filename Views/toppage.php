<section>
    <!--トップページのヘダー画像-->
    <div id="viewer">
      <img src="/images/top-woman.jpg"  width="100%" max-height="540px" />
      <img src="/images/top-guitar.jpg"  width="100%" max-height="540px" />
      <img src="/images/top-bike.jpg"  width="100%" max-height="540px" />
      <img src="/images/top-running.jpg"  width="100%" max-height="540px" />
    </div>
    <script type="text/javascript">
    $(function(){
        var setImg = '#viewer';
        var fadeSpeed = 1000;
        var switchDelay = 5000;

        $(setImg).children('img').css({opacity:'0'});
        $(setImg + ' img:first').stop().animate({opacity:'1'},fadeSpeed);

        setInterval(function(){
            $(setImg + ' :first-child').animate({opacity:'0'},fadeSpeed).next('img').animate({opacity:'1'},fadeSpeed).end().appendTo(setImg);
        },switchDelay);
    });
    </script>
</section>
<div class="top-message">
<h1><b>交換で、共に楽しく。</b></h1>
<p class="catch-copy">湧き出る「話したい」を、ここで。</p>
</div>
<?php require_once $this->getSysRoot() . $this->getViewDir() . '/header-genres.php'; ?>
<section>
    <div class="container" id="about-top">
      <h2>Starportについて</h2>
      <div class="row">
        <div class="col-xs-6 col-xxs-12">
          <div class="top-content-image">
            <img class="img-responsive" src="/images/top-image1.jpg"/>
          </div>
      </div>
        <div class="col-xs-6 col-xxs-12">
          <div class="top-content-message">
            <p>　自分がハマっていることの魅力を周りの人に知ってほしい。その仲間を作りたい。その良さが周りに伝わっていないのは、もどかしくないですか？<br><br>　大学生どうしで、皆さんの持つ「話したい」経験やノウハウ、疑問などを話し合い（交換）します。今まで考えもしなかった面白いことを知れ、多くの友人を作るきっかけになります。<br><br>　安全と安心のため、場所は大学構内に限定します。「話したい」を「レッスン」として登録し、早速交換しましょう！</p>
          </div>
        </div>
      </div>
    </div>
    <div>
        <?php if(!isset($_SESSION['user_id'])){ ?>
      <a class="resister-teacher register-margin" href="/user/register/">facebookで登録！</a>
        <?php }else{ ?>
      <a class="resister-teacher register-margin" href="/lesson/register/">レッスンを作る！</a>
        <?php } ?>
    </div>
    <div class="container how-to-wrapper">
      <h2>使い方は簡単！</h2>
      <div class="row">
        <div class="col-xs-6 col-xxs-12 how-to-content">
          <h2>1．メンバー登録しよう！</h2>
          <img alt="img" class="img-responsive" src="/images/how-to-use1.jpg"/>
          <p class="top-p">安全と信頼性の向上のため、詳細なプロフィールに心がけ、メンバー登録しよう！</p>
        </div>
        <div class="col-xs-6 col-xxs-12 how-to-content">
          <h2>2．レッスンを作ろう！</h2>
          <img alt="img" class="img-responsive" src="/images/how-to-use2.jpg"/>
          <p class="top-p">「話したい」を、レッスンとして登録。交換のときに必要となります。</p>
        </div>
    </div>
      <div class="row">
        <div class="col-xs-6 col-xxs-12 how-to-content">
          <h2>3．レッスンを選び、連絡！</h2>
          <img alt="img" class="img-responsive" src="/images/how-to-use3.jpg"/>
          <p class="top-p">レッスンを探し、「聞きたい！」ボタンから相手と連絡を取り、日時と場所を決めます。</p>
        </div>
        <div class="col-xs-6 col-xxs-12 how-to-content">
          <h2>4．さあ交換しよう！</h2>
          <img alt="img" class="img-responsive"src="/images/how-to-use4.jpg"/>
          <p class="top-p">大学構内で、「話したい」を交換しよう！話したい側が希望しなければ、聞く側は「話したい」を話す必要はありません。</p>
        </div>
      </div>
    </div>

    <div class="row">
      <div id="top-strength">
        <div class="col-xs-4 col-xxs-6">
          <img class="img-responsive-img" alt="img" src="/images/thumbs-up.png" height="30px" width="30px">
          <h3>マッチング無料</h3>
          <p class="top-p">交換は無料でマッチングでき、もちろん登録料もなし！</p>
        </div>
        <div class="col-xs-4 col-xxs-6">
          <img class="img-responsive-img" alt="img" src="/images/people.png" height="30px" width="30px">
          <h3>新しい友人</h3>
          <p class="top-p">共通の興味を持つ大学生どうしだから、よい友人になるでしょう！</p>
        </div>
        <div class="col-xs-4 col-xxs-6">
          <img class="img-responsive-img" alt="img" src="/images/man-sprinting.png" height="30px" width="30px">
          <h3>「好き」を話す！</h3>
          <p class="top-p">自分の「好き」に心から興味を持って聞く人は意外と少ないものです。</p>
        </div>
        <div class="col-xs-4 col-xxs-6">
          <img class="img-responsive-img" alt="img" src="/images/search.png" height="30px" width="30px">
          <h3>新しい発見</h3>
          <p class="top-p">交換だから、検索では見つからない、おもしろいものを発見できます！</p>
        </div>
        <div class="col-xs-4 col-xxs-6">
          <img class="img-responsive-img" alt="img" src="/images/fire.png" height="30px" width="30px">
        　<h3>モチベーション↑</h3>
          <p class="top-p">WEB検索では深いことや本当に知りたいことはなかなか見つかりません。</p>
        </div>
        <div class="col-xs-4 col-xxs-6">
          <img class="img-responsive-img" alt="img" src="/images/time.png" height="30px" width="30px">
          <h3>いつでも</h3>
          <p class="top-p">明日の4限が暇だ！大学校内でのスキルシェアはいかがですか？</p>
        </div>
      </div>
    </div>
    <div>
        <?php if(!isset($_SESSION['user_id'])){ ?>
      <a class="resister-teacher register-margin" href="/user/register/">facebookで登録！</a>
        <?php }else{ ?>
      <a class="resister-teacher register-margin" href="/lesson/register/">レッスンを作る！</a>
        <?php } ?>
    </div>

  <style>
  #about-top h2{
    font-size: 30px;
    text-align: center;
  }
  .top-content-image{
    padding-bottom: 8px;
  }
   .top-content-message{
     display: table;
   }

   .top-content-message p{
     font-size: 13px;
   }
   @media all and (max-width: 700px){
     .top-content-message p{
       font-size: 13px;
     }
     #about-top h2{
       font-size: 20px;
     }
   }
   #top-strength{
     padding:10px;
     max-width: 900px;
     margin-left: auto;
     margin-right: auto;
   }
   .icon-img{
     display: block;
     margin-left: auto;
     margin-right: auto;
   }
   .top-p{
     text-align: left;
   }
  </style>
</section>
<script src="/js/TextOverFlow.js" charset="utf-8"></script>
<section>
    <h2>人気講座</h2>
    <div class="self-container">
        <?php for ($i = 0; $i < count($data['pLesson']); $i++) { ?>
            <div class="profile-wrapper">
                <div class="profile-content">
                    <a href="/lesson/detail/<?= $data['pLesson'][$i]['id'] ?>/">
                        <div class="background-images"><!--背景画像-->
                            <img alt="img" src="<?= $data['pLesson'][$i]['image'] ?>"/>
                            <div class="profile-images" ><!--プロフィール画像-->
                                <img alt="img" src="<?= $data['pUser'][$i]['facebook_photo_url'] ?>"/>
                            </div>
                        </div>
                        <div class="profile-text">
                            <h2><?= $data['pLesson'][$i]['name'] ?></h2>
                            <p class="lesson-about"><?= $data['pLesson'][$i]['about'] ?></p>
                            <div class="separator"></div>
                            <p class="lesson-university"><?= $data['pUser'][$i]['university'] ?></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    <h2>新着講座</h2>
        <?php for ($i = 0; $i < count($data['nLesson']); $i++) { ?>
            <div class="profile-wrapper">
                <div class="profile-content">
                    <a href="/lesson/detail/<?= $data['nLesson'][$i]['id'] ?>/">
                        <div class="background-images"><!--背景画像-->
                            <img alt="img" src="<?= $data['nLesson'][$i]['image'] ?>"/>
                            <div class="profile-images" ><!--プロフィール画像-->
                                <img alt="img" src="<?= $data['nUser'][$i]['facebook_photo_url'] ?>"/>
                            </div>
                        </div>
                        <div class="profile-text">
                            <h2><?= $data['nLesson'][$i]['name'] ?></h2>
                            <p class="lesson-about"><?= $data['nLesson'][$i]['about'] ?></p>
                            <div class="separator"></div>
                            <p class="lesson-university"><?= $data['nUser'][$i]['university'] ?></p>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</section>
