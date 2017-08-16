<script src="/js/lessonPreview.js" charset="utf-8"></script>
<div id="status">
    <section><!--レッスン登録-->
        <div class="width412px" >
            <h2>レッスン編集</h2>
            <form method="POST" action="/lesson/detail/<?= $data['lesson']['id'] ?>/">
                <!-- エラーメッセージ -->
                <caption><?= $msg ?></caption>
                <div class="form-group inline form-padding">
                    <div class="left">※レッスン名（15文字以内）</div>
                    <input type="text" class="form-control form300" name="lesson_name" placeholder="例：Starportについて！"　maxlength="15" value="<?= $data['lesson']['name'] ?>" required>
                </div>
                <div class="form-group inline form-padding">
                    <div class="left">※レッスンの内容、魅力、あなたの実績など</div>
                    <textarea class="form-control form300" name="lesson_about" required><?= $data['lesson']['about'] ?></textarea>
                </div>
                <div class="form-group inline form-padding">
                    <select class="form-control form300" name="lesson_genre">
                        <?php foreach ($data['category'] as $category) { ?>
                            <option name="lessonGenre" value="<?= $category['id'] ?>" <?= ($category['id'] == $data['lesson']['content_id']) ? 'selected="ture"' : '' ?>><?= $category['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!--    <div class="form-group inline form300 form-padding">
                        <span id="helpBlock" class="help-block left">※レッスンカバー画像（JPEGのみ、最大2MB）</span>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> 最大2MB
                        <input type="file" id="InputFile" name="upfile">
                    </div>-->
                    <div class="preview">
                        <h3>プレビュー</h3>
                        <div class="profile-wrapper">
                            <div class="profile-content">
                                <div class="background-images"><!--背景画像-->
                                    <img id="preview" alt="img" src="<?= $data['lesson']['image'] ?>"/>
                                    <div class="profile-images" ><!--プロフィール画像-->
                                        <img alt="img" src="<?= $_SESSION['user_img'] ?>"/>
                                    </div>
                                </div>
                                <div class="profile-text">
                                    <h2 class="lesson-name"><?= $data['lesson']['name'] ?></h2>
                                    <p class="lesson-about"><?= $data['lesson']['about'] ?></p>
                                    <div class="separator"></div>
                                    <p class="lesson-university">学校名</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <button name="edit" type="submit" class="btn btn-default">変更確定</button>
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
            </style>
        </div>
    </section>
</div>
