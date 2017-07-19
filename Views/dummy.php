<section id="default_cover">
    <link rel="stylesheet" href="/css/img_list.css">
    <script src="/js/img_list.js"></script>
    <h2>カバー画像の選択</h2>
    <ul id="img_list">
        <?php for ($i = 1; $i <= 24; $i++) { ?>
            <li class="img">
                <img src="/images/cover/cover<?= $i ?>.jpg" alt="cover<?= $i ?>" />
            </li>
        <?php } ?>
    </ul>
    <h3>選択された画像</h3>
    <input type="hidden" name="img" value="" />
    <img id="selected_img" />
</section>
