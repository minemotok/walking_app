$(function () {
  // 正常に処理された場合
  $("#overlay").fadeIn(500);
  $('.delete-check').hide();
  $('.roading').append('<p id="text-item">roading...</P>');
  setTimeout(function () {
    $("#overlay").fadeOut(500);
    $('.delete-check').show();
  }, 4000);
  // 不正に処理された場合
  $('.delete-check-error').hide();
  setTimeout(function () {
    $('#overlay').fadeOut(500);
    $('.delete-check-error').show();
  }, 4000);
});
