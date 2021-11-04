// inputフォームに入力した値の表示
$(document).ready(function () {
    $(".item_name").keyup(function () {
        $(".view-title").html($(".item_name").val());
    });
});

$(document).ready(function () {
    $(".item_text").keyup(function () {
        $(".view-text").html($(".item_text").val());
    });
});

// 画像アップロードをプレビューする機能
$(".image-input").on('change', function (e) {
    var reader = new FileReader();
    reader.onload = function (e) {
        $(".view-img").attr('src', e.target.result);
    }
    reader.readAsDataURL(e.target.files[0]);
});