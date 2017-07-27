<section><!--プロフィール編集-->
    <div class="width412px">
        <h2>プロフィール編集</h2>
        <div class="row">
            <img src="<?= $data['user']['facebook_photo_url'] ?>">
        </div>
        <form method="post" action="/user/profile/<?= $_SESSION['user_id'] ?>">
            <!-- エラーメッセージ -->
            <caption><?=$msg?></caption>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="last_name" placeholder="姓(必須)" value="<?= $data['user']['last_name'] ?>"　required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="first_name" placeholder="名(必須)" value="<?= $data['user']['first_name'] ?>"　required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form300" name="university" placeholder="大学(必須)" value="<?= $data['user']['university'] ?>" required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="faculty" placeholder="学部(必須)" value="<?= $data['user']['faculty'] ?>"　required>
            </div>
            <div class="form-group inline">
                <input type="text" class="form-control form148" name="course" placeholder="学科(任意)" value="<?= $data['user']['course'] ?>">
            </div>
            <div class="form-group inline">
                自己紹介文（必須）
                <textarea class="form-control form300" name="introduction" placeholder="例：テニスサークル○○所属、特技は筋トレ、趣味は映画鑑賞など" required><?= $data['user']['introduction'] ?></textarea>
            </div>
            <div class="form-group inline">
                キャッチフレーズ(30字以内任意)
                <input type="text" class="form-control form300" name="phrase" placeholder="例：stay foolish, stay hungry." maxlength="30" value="<?= $data['user']['phrase'] ?>">
            </div>
            <div class="form-group inline">
                <button name="edit" type="submit" class="btn btn-default">変更確定</button>
            </div>
        </form>

        <style>
            @media all and (min-width: 412px){
                .form148{width: 196px;
                }
                .form300{width: 400px;
                }
            }
            @media all and (max-width: 412px){
                .form148{width: 144px;
                }
                .form300{width: 300px;
                }
            }

            .form_profile{
                display: inline-block;
                text-align: left;
            }
            form{
                text-align: center;
                padding-left: 4px;
                padding-right: 4px;
            }
            .inline{
                display: inline-block;
                margin:4px 2px;
            }
        </style>
    </div>
</section>
