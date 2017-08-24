<section><!--プロフィール編集-->
    <div class="width412px">
        <h2>プロフィール編集</h2>
        <form method="post" action="/user/profile/<?= $_SESSION['user_id'] ?>">
            <div class="form-group">
                <div class="form-label">氏名<div class="form-required">必須</div></div>
                <div class="inline">
                    <input type="text" class="form-control form148" name="data[last_name]" value="<?= $data['user']['last_name'] ?>"　required>
                </div>
                <div class="inline">
                    <input type="text" class="form-control form148" name="data[first_name]" value="<?= $data['user']['first_name'] ?>"　required>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">メールアドレス<div class="form-required">必須</div></div>
                <div class="inline">
                    <input type="email" class="form-control form300" name="data[email]" placeholder="例) info@starport.com" value="<?= $data['user']['email'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">学校名<div class="form-required">必須</div></div>
                <div class="inline">
                    <input type="text" class="form-control form300" name="data[university]" placeholder="例) 京都大学" value="<?= $data['user']['university'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">学部・学科名<div class="form-optional">任意</div></div>
                <div class="inline">
                    <input type="text" class="form-control form300" name="data[faculty]" placeholder="例) 工学部" value="<?= $data['user']['faculty'] ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">自己紹介文<div class="form-optional">任意</div></div>
                <div class="inline">
                    <textarea class="form-control form300" name="data[introduction]" placeholder="例) テニスサークル所属、趣味は筋トレと映画鑑賞です。&#13;&#10;よろしくお願いします!!" ><?= $data['user']['introduction'] ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <button name="submit" type="submit" class="btn btn-success">確定</button>
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
