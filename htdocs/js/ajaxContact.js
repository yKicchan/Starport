$(function () {

    var isContacted = false;

    $("#contact").on('click', function () {
        if (isContacted) {
            return;
        }
        var ans = confirm(lessonName + "の話を聞きますか？\nOKを押すと、" + userName + "さん宛にメールが送信されます。");
        if (ans) {
            ajax();
        }
    });

    var ajax = function () {
        $.ajax({
            url: "/ajax/contact/" + lessonId,
            type: "get",
            timeout: 2000,
            success: function(result) {
                alert(result.responseJSON);
                $("#contact").text("申請中");
                isContacted = true;
            },
            error: function(result) {
                alert(result.responseJSON);
            }
        });
    }
});
