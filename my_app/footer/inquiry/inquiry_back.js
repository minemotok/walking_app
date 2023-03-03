$(function () {
  if (json_back_data.username !== 'なし') {
    $('#userName').val(json_back_data.username);
  }
  if (json_back_data.gender !== 'なし') {
    if (json_back_data.gender === '男') {
      $("input[name='gender']").val(['男']);
    } else if (json_back_data.gender === '女') {
      $("input[name='gender']").val(['女']);
    }
  }
  if (json_back_data.birth_day !== 'なし') {
    $('#birth').val(json_back_data.birth_day);
  }
  if (json_back_data.post !== 'なし') {
    $('#post').val(json_back_data.post);
  }
  if (json_back_data.address !== 'なし') {
    $('#residence').val(json_back_data.address);
  }
  if (json_back_data.contents !== 'なし') {
    $('#contentArea').val(json_back_data.contents);
  }

  if (json_back_data.prefecture !== 'なし') {
    $("[name='prefecture']").val(json_back_data.prefecture);
  }
});