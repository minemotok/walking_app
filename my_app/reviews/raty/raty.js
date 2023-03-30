$(function () {
  $('.star').on('click', function(event) {
  let data = event.target.dataset.name;
  let num = $(this).data('id');
      switch(num) {
      case 'star-5-' + data:
        $('#star-function-1-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-2-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-3-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-4-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-5-' + data).attr('src', "./reviews/raty/star-on.png");
      break;
      case 'star-4-' + data:
        $('#star-function-1-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-2-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-3-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-4-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-5-' + data).attr('src', "./reviews/raty/star-off.png");
      break;
      case 'star-3-' + data:
        $('#star-function-1-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-2-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-3-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-4-' + data).attr('src', "./reviews/raty/star-off.png");
        $('#star-function-5-' + data).attr('src', "./reviews/raty/star-off.png");
      break;
      case 'star-2-' + data:
        $('#star-function-1-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-2-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-3-' + data).attr('src', "./reviews/raty/star-off.png");
        $('#star-function-4-' + data).attr('src', "./reviews/raty/star-off.png");
        $('#star-function-5-' + data).attr('src', "./reviews/raty/star-off.png");
      break;
      case 'star-1-' + data:
        $('#star-function-1-' + data).attr('src', "./reviews/raty/star-on.png");
        $('#star-function-2-' + data).attr('src', "./reviews/raty/star-off.png");
        $('#star-function-3-' + data).attr('src', "./reviews/raty/star-off.png");
        $('#star-function-4-' + data).attr('src', "./reviews/raty/star-off.png");
        $('#star-function-5-' + data).attr('src', "./reviews/raty/star-off.png");
      break;
    }
    $('#star-of-number').val(num);
  });
  $('.reset').on('click', function (event) {
    let data = event.target.dataset.name;
    $('#star-function-1-' + data).attr('src', "./reviews/raty/star-off.png");
    $('#star-function-2-' + data).attr('src', "./reviews/raty/star-off.png");
    $('#star-function-3-' + data).attr('src', "./reviews/raty/star-off.png");
    $('#star-function-4-' + data).attr('src', "./reviews/raty/star-off.png");
    $('#star-function-5-' + data).attr('src', "./reviews/raty/star-off.png");
  });
});