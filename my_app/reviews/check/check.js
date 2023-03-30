$(function () {
  if (typeof starNumber != "undefined" && starNumber != "") {
    console.log(starNumber);
    switch (starNumber) {
      case 'star-5':
        $('#star-function-1').attr('src', "../raty/star-on.png");
        $('#star-function-2').attr('src', "../raty/star-on.png");
        $('#star-function-3').attr('src', "../raty/star-on.png");
        $('#star-function-4').attr('src', "../raty/star-on.png");
        $('#star-function-5').attr('src', "../raty/star-on.png");
      break;
      case 'star-4':
        $('#star-function-1').attr('src', "../raty/star-on.png");
        $('#star-function-2').attr('src', "../raty/star-on.png");
        $('#star-function-3').attr('src', "../raty/star-on.png");
        $('#star-function-4').attr('src', "../raty/star-on.png");
        $('#star-function-5').attr('src', "../raty/star-off.png");
      break;
      case 'star-3':
        $('#star-function-1').attr('src', "../raty/star-on.png");
        $('#star-function-2').attr('src', "../raty/star-on.png");
        $('#star-function-3').attr('src', "../raty/star-on.png");
        $('#star-function-4').attr('src', "../raty/star-off.png");
        $('#star-function-5').attr('src', "../raty/star-off.png");
      break;
      case 'star-2':
        $('#star-function-1').attr('src', "../raty/star-on.png");
        $('#star-function-2').attr('src', "../raty/star-on.png");
        $('#star-function-3').attr('src', "../raty/star-off.png");
        $('#star-function-4').attr('src', "../raty/star-off.png");
        $('#star-function-5').attr('src', "../raty/star-off.png");
      break;
      case 'star-1':
        $('#star-function-1').attr('src', "../raty/star-on.png");
        $('#star-function-2').attr('src', "../raty/star-off.png");
        $('#star-function-3').attr('src', "../raty/star-off.png");
        $('#star-function-4').attr('src', "../raty/star-off.png");
        $('#star-function-5').attr('src', "../raty/star-off.png");
        break;
      case 'star-0':
        $('#star-function-1').attr('src', "../raty/star-off.png");
        $('#star-function-2').attr('src', "../raty/star-off.png");
        $('#star-function-3').attr('src', "../raty/star-off.png");
        $('#star-function-4').attr('src', "../raty/star-off.png");
        $('#star-function-5').attr('src', "../raty/star-off.png");
        break;
    }
  }
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