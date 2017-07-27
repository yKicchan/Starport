$(function(){

    var limit  = 15;
    var offset = 0;

    $("#more").on('click', function(){
        getLesson(limit, offset);
    });

    /**
     * 非同期でレッスン情報を取得する
     * @return {void}
     */
    var getLesson = function(){
        $.ajax({
            url: "/ajax/getlesson?genre=" + genre + "&limit=" + limit + "&offset=" + offset,
            type: "get",
            timeout: 2000,
            success: function(result) {
                // 取得したレッスン情報をHTMLに表示
                for (var i = 0; i < result.lesson.length; i++) {
                    result.lesson[i].name  = htmlspecialchars(result.lesson[i].name);
                    result.lesson[i].about = htmlspecialchars(result.lesson[i].about);
                    addLesson(result.lesson[i], result.user[i]);
                }
                if (i > 0) {
                    offset += i;
                } else {
                    // 取得できるレッスンがなくなったらもっとボタンを消す
                    $("#more").fadeOut(300);
                }
            },
            error: function(result) {
                console.log(result);
            }
        });

        /**
         * レッスンをHTMLに追加
         * @param {array} lesson レッスン情報
         * @param {array} user   レッスンの作成者情報
         */
        var addLesson = function(lesson, user){
            var row = "<div class=\"profile-wrapper\">\n";
            row += "\t<div class=\"profile-content\">\n";
            row += "\t\t<a href=\"/lesson/detail/" + lesson.id + "/\">\n";
            row += "\t\t\t<div class=\"background-images\">\n";
            row += "\t\t\t\t<img alt=\"img\" src=\"" + lesson.image + "\"/>\n";
            row += "\t\t\t\t<div class=\"profile-images\">\n";
            row += "\t\t\t\t\t<img alt=\"img\" src=\"" + user.facebook_photo_url + "\"/>\n";
            row += "\t\t\t\t</div>\n";
            row += "\t\t\t\t<div class=\"profile-name\" hidden=\"hidden\">" + user.last_name + user.first_name + "</div>\n";
            row += "\t\t\t</div>\n";
            row += "\t\t\t<div class=\"profile-text\">\n";
            row += "\t\t\t\t<h2>" + lesson.name + "</h2>\n";
            row += "\t\t\t\t<p class=\"lesson-about\">" + lesson.about + "</p>\n";
            row += "\t\t\t\t<div class=\"separator\"></div>\n";
            row += "\t\t\t\t<p class=\"lesson-university\">" + user.university + "</p>\n";
            row += "\t\t\t</div>\n";
            row += "\t\t</a>\n";
            row += "\t</div>\n";
            row += "</div>";
            $("#lesson-container").append(row);
        };

        var htmlspecialchars = function (str) {
            str = str.replace(/&/g,"&amp;") ;
            str = str.replace(/"/g,"&quot;") ;
            str = str.replace(/'/g,"&#039;") ;
            str = str.replace(/</g,"&lt;") ;
            str = str.replace(/>/g,"&gt;") ;
            return str ;
        };
    };
    getLesson(limit, offset);
});
