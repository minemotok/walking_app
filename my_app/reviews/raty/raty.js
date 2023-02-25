$(function() {
  $('.star').on('click', function() {
    let num = $(this).data('id');
      switch(num) {
      case 'star-5':
        $('.star').attr('src', "./reviews/raty/star-on.png");
      break;
      case 'star-4':
        $('#star-function-1').attr('src', "./reviews/raty/star-on.png");
        $('#star-function-2').attr('src', "./reviews/raty/star-on.png");
        $('#star-function-3').attr('src', "./reviews/raty/star-on.png");
        $('#star-function-4').attr('src', "./reviews/raty/star-on.png");
        $('.star-function-5').attr('src', "./reviews/raty/star-off.png");
      break;
      case 'star-3':
        $('#star-function-1').attr('src', "./reviews/raty/star-on.png");
        $('#star-function-2').attr('src', "./reviews/raty/star-on.png");
        $('#star-function-3').attr('src', "./reviews/raty/star-on.png");
        $('#star-function-4').attr('src', "./reviews/raty/star-off.png");
        $('#star-function-5').attr('src', "./reviews/raty/star-off.png");
      break;
      case 'star-2':
        $('#star-function-1').attr('src', "./reviews/raty/star-on.png");
        $('#star-function-2').attr('src', "./reviews/raty/star-on.png");
        $('#star-function-3').attr('src', "./reviews/raty/star-off.png");
        $('#star-function-4').attr('src', "./reviews/raty/star-off.png");
        $('#star-function-5').attr('src', "./reviews/raty/star-off.png");
      break;
      case 'star-1':
        $('#star-function-1').attr('src', "./reviews/raty/star-on.png");
        $('#star-function-2').attr('src', "./reviews/raty/star-off.png");
        $('#star-function-3').attr('src', "./reviews/raty/star-off.png");
        $('#star-function-4').attr('src', "./reviews/raty/star-off.png");
        $('#star-function-5').attr('src', "./reviews/raty/star-off.png");
      break;
    }
    $('#star-of-number').val(num);
  });
  $('#reset').on('click', function() {
    $('.star').attr('src', "./reviews/raty/star-off.png");
  });
});