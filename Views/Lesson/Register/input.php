<script src="/js/imgList.js" charset="utf-8"></script>
<script src="/js/imgClick.js" charset="utf-8"></script>
<script src="/js/upload.js" charset="utf-8"></script>
<script src="/js/lessonPreview.js" charset="utf-8"></script>
<div id="status">
    <section><!--レッスン登録-->
        <div class="width412px" >
            <h2>レッスン登録</h2>
            <!-- エラーメッセージ -->
            <?= $data['msg'] ?>
            <form enctype="multipart/form-data" method="POST" action="/lesson/register/complete/">
                <div class="form-group">
                    <div class="form-label">レッスン名<div class="form-required">必須</div></div>
                    <div class="inline">
                        <input class="form-control form300" type="text" name="data[name]" placeholder="例) Starportについて！"　maxlength="15" value="<?= $_SESSION['lesson_name'] ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">レッスン内容<div class="form-required">必須</div></div>
                    <textarea class="form-control form300" name="data[about]" required><?= $_SESSION['lesson_about'] ?></textarea>
                </div>
                <div class="form-group">
                    <div class="form-label">カテゴリー<div class="form-required">必須</div></div>
                    <select class="form-control form300" name="data[genre]">
                        <option name="lessonGenre" value="-1">カテゴリーを選ぶ</option>
                        <?php foreach ($data['category'] as $category) { ?>
                            <option name="lessonGenre" value="<?= $category['id'] ?>" <?= ($category['id'] == $_SESSION['lesson_genre']) ? 'selected="ture"' : '' ?>><?= $category['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="form-label">カバー画像（JPEGのみ、最大2MB)<div class="form-required">必須</div></div>
                    <div class="radio-group">
                        <input type="radio" name="cover" value="default" checked="true" id="default" />
                        <label for="default">選択</label>
                        <input type="radio" name="cover" value="custom" id="custom" />
                        <label for="custom">アップ</label>
                    </div>
                    <div class="cover_group">
                        <section id="default_cover" class="cover">
                            <ul id="img_list">
                                <?php for ($i = 1; $i <= 24; $i++) { ?>
                                    <li class="img">
                                        <img src="/images/cover/cover<?= $i ?>.jpg" alt="cover<?= $i ?>" />
                                    </li>
                                <?php } ?>
                            </ul>
                        </section>
                        <section id="custom_cover" class="cover" hidden="hidden">
                            <div class="drop_area" id="drop_area">
                                <img src="/images/upload_icon.svg" />
                                <p>クリックして画像を選択</p>
                                <div id="progress"></div>
                            </div>
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000"><!-- 最大2MB -->
                            <input type="file" id="file" accept="image/*" >
                            <input type="text" name="data[image]" style="display:none" >
                        </section>
                    </div>
                    <div class="preview">
                        <h3>プレビュー</h3>
                        <div class="profile-wrapper">
                            <div class="profile-content">
                                <div class="background-images"><!--背景画像-->
                                    <img id="preview" alt="img" src="/images/cover/noimage.svg"/>
                                    <div class="profile-images" ><!--プロフィール画像-->
                                        <img alt="img" src="<?= $_SESSION['user_img'] ?>"/>
                                    </div>
                                </div>
                                <div class="profile-text">
                                    <h2 class="lesson-name">レッスン名</h2>
                                    <p class="lesson-about">レッスンの内容、魅力、あなたの実績など</p>
                                    <div class="separator"></div>
                                    <p class="lesson-university"><?= $data['user']['university'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button name="submit" type="submit" class="resister-teacher">準備完了！</button>
            </form>
            <style>
                @media all and (min-width: 412px){
                    .form148{width: 198px;}
                    .form300{width: 400px;}
                }
                @media all and (max-width: 412px){
                    .form148{width: 148px;}
                    .form300{width: 300px;}
                }

                .form_profile{
                    display: inline-block;
                    text-align: left;}
                form{
                    text-align: center;
                    padding-left: 4px;
                    padding-right: 4px;
                }
                .inline{
                    display: inline-block;
                    margin:2px 0;
                }
                .cover_group{
                    position: relative;
                    height: 140px;
                }
                .cover{
                    position: absolute;
                    height: 100%;
                }
                .img{
                    padding-top: 10px;
                    padding-bottom: 10px;
                }
                #file{
                    display: none;
                }
                .drop_area{
                    margin-top: 11px;
                    margin-left: auto;
                    margin-right: auto;
                    height: 100px;
                    width: 100%;
                    border: 2px dotted #8e8e8e;
                    border-radius: 6px;
                }
                .drop_area img{
                    margin-top: 13px;
                    margin-left: auto;
                    margin-right: auto;
                    width: 43px;
                }
                .drop_area p{
                    margin-top: 3px;
                    color: #8e8e8e;
                    font-family: "游ゴシック", YuGothic;
                    letter-spacing: 0.3em;
                }
                #progress{
                    width: 0px;
                    position: absolute;
                    top: 14px;
                    bottom: 32px;
                    border-radius: 12px;
                    background-color: #efefef;
                    z-index: -1;
                }
            </style>
        </div>
    </section>
</div>
