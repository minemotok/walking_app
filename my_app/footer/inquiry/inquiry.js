$(function () {
  if (js_post_data.username !== 'なし') {
    $('#userName').val(js_post_data.username);
  } 
  if(js_post_data.gender !== 'なし') {
    if(js_post_data.gender === '男') {
    $("input[name='gender']").val(['男']);
    } else if(js_post_data.gender === '女') {
    $("input[name='gender']").val(['女']);
    }
  } 
  if(js_post_data.birth_day !== 'なし') {
    $('#birth').val(js_post_data.birth_day);
  } 
  if(js_post_data.post !== 'なし') {
    $('#post').val(js_post_data.post);
  } 
  if(js_post_data.address !== 'なし') {
    $('#residence').val(js_post_data.address);
  } 
  if(js_post_data.contents !== 'なし') {
    $('#contentArea').val(js_post_data.contents);
  }

  if (js_post_data.prefecture !== 'なし') {
  $("[name='prefecture']").val(js_post_data.prefecture);
  }
});