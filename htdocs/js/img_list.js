$(function(){
    // 画像リスト
    let list = $("#img_list");
    // 画像リストの座標を取得
    var listLeft  = list.position().left;
    var listRight = list.width() + listLeft;
    // 傾き(°)
    let r = 30;
    // ループカウンタ
    var i = 0;

    // 初期化
    list.find('.img img').each(function(){
        setRotate(listLeft, listRight, $(this), r, i++);
    });

    // リサイズされた時の処理
    $(window).resize(function() {
        listLeft  = list.position().left;
        listRight = list.width() + listLeft;
        // ループカウンタ初期化
        i = 0;
        list.find('.img img').each(function(){
            setRotate(listLeft, listRight, $(this), r, i++);
        });
    });

    // 画像リストスクロール
    list.scroll(function(){
        // ループカウンタ初期化
        i = 0;
        $(this).find('.img img').each(function(){
            setRotate(listLeft, listRight, $(this), r, i++);
        });
    });
});

/**
 * 画像の傾きをセットする
 * @param {integer} listLeft  画像リストの左座標
 * @param {integer} listRight 画像リストの右座標
 * @param {object}  item      画像オブジェクト
 * @param {integer} r         最大の傾き
 * @param {integer} index     itemのindex
 */
function setRotate(listLeft, listRight, item, r, index)
{
    let width = item.parent().width();
    // 画像の左端座標
    var left  = item.parent().position().left;
    // 画像の右端座標
    var right = left + width;

    // 完全にはみ出てる時と完全にリスト内にある時は処理しない
    if((right < listLeft || left > listRight) ||
       (right < listRight && left > listLeft)){
        // 傾きをリセット
        item.css('transform', '');
        return;
    }

    // 左側にはみ出てる時
    if (left < listLeft) {
        // 左側の超過領域計算(0% ~ 100%)
        let lo = (listLeft - left) / width;
        // 右上を基準にして、超過分r°まで傾ける
        item.css('transform-origin', 'right top');
        item.css('transform', 'rotateY(' + (lo * -r) + 'deg)');
    }

    // 右側にはみ出てる時
    if (right > listRight){
        // 右側の超過領域計算(0% ~ 100%)
        let ro = (left - (listRight - width)) / width;
        // 左上を基準にして、超過分r°まで傾ける
        item.css('transform-origin', 'left top');
        item.css('transform', 'rotateY(' + (ro * r) + 'deg)');
    }
}
