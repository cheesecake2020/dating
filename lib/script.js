'use strict';
$(document).ready(function () {
    
    $('#likeform').on('submit', function (event) {
        // フォームデータを送る
        var form_data = $(this).serialize();
        $.ajax({
            url: '../public/like_check.php',
            type: 'POST',
            data: form_data,
        })
            .done(function(data){
                console.log('成功');
            })
            .fail(function () {
                console.log('失敗');
            });
          });
});
