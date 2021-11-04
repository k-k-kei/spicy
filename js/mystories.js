// inputフォームに入力した値の表示
$(document).ready(function () {
    $(".title-input").keyup(function () {
        $(".view-title").html($(".title-input").val());
    });
});

$(document).ready(function () {
    $(".text-input").keyup(function () {
        $(".view-text").html($(".text-input").val());
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