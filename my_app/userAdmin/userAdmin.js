$(function () {
  $('#update').on('click', function () {
    let popInput = $('<div id="dialog" />');
    popInput.append('<span class="close"><i class="fa-solid fa-xmark" id="close"></i></span>');
    popInput.append('<h2 id="pop_title">登録更新</h2>');
    popInput.append('<p id="pop_input">更新したいアカウント名を入力してください</p>');
    popInput.append('<form method="POST" class="update_form"><input type="text" name="user_update_account" placeholder="アカウント名"><button id="button" name="account_btn"><i class="fa-solid fa-magnifying-glass"></i></button></form>');
    popInput.addClass('popup');
    $('.admin-main').append(popInput);

    // 黒く覆うためのクラスを追加
    $('#cover').addClass('container-element');

    // 閉じるボタンをクリックした時の処理
    $('#close').on('click', function () {
      $('#dialog').hide();
      $('#cover').hide();
    });
  });

  // ユーザー情報を削除する
  $('#delete-link').on('click', function () {
    let popDelete = $('<div id="deleteLog" />');
    popDelete.append('<span class="close"><i class="fa-solid fa-xmark" id="close"></i></span>');
    popDelete.append('<h2 id="delete">登録削除</h2>');
    popDelete.append('<p id="pop_input">削除したいユーザー情報のアカウント名を入力してください</p>');
    popDelete.append('<form method="POST" class="update_form"><input type="text" name="user_delete_account" placeholder="アカウント名"><button id="button" name="delete_btn"><i class="fa-solid fa-magnifying-glass"></i></button></form>');
    popDelete.addClass('popup');
    $('.admin-main').append(popDelete);
    // 黒く覆うためのクラスを追加
    $('#cover').addClass('container-element');
    // 閉じるボタンをクリックした時の処理
    $('#close').on('click', function () {
      $('#deleteLog').hide();
      $('#cover').hide();
    });
  });
});
