$(function() {
  $('#submitButton').on('click', function () {
    const reviewsText = $('#floatingTextarea').val().length;
    // エラーチェック
    if (reviewsText !== '' && reviewsText < 250) {
      $(window).load(function () {
          window.location.href = "../complete/complete.php";
      });
    } else {
      alert('レビュー記入欄の値が不正です！\r\n もう一度入力してください');
    }
  });
});