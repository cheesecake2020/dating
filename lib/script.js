'use strict';
$(document).ready(function () {

    $('#likeform').on('submit', function (event) {
        // フォームデータを送る(フォームの要素の各値をURLクエリー用文字列に連結)
        var form_data = $(this).serialize();
        $.ajax({
                url: '../public/like_check.php',
                type: 'POST',
                data: form_data,
            })
            .done(function (data) {
                console.log('成功');
            })
            .fail(function () {
                console.log('失敗');
            });
    });

// WebSocet
    var conn = new WebSocket('ws://localhost:8282');
    conn.onopen = function (e) {
        console.log("Connection established!");
    };

    conn.onmessage = function (e) {
        console.log(e.data);
    };
});