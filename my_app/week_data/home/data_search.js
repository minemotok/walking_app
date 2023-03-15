$(function () {
  $('.tooltip').hide();
  $('.popup').hover(
    function () {
      $(this).children('.tooltip').fadeIn('fast');
    },
    function () {
      $(this).children('.tooltip').fadeOut('fast');
    }
  )
});