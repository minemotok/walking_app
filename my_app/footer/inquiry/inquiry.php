<?php
require_once('input_check.php');

if (!empty($_POST)) {
  if ($_POST['job_category'] === '法人') {
    $error_check_form = new Errorcheckform();
    // 法人を入力していたら会社名の空文字チェック
    $company_name_data = $error_check_form->word_error_check('company_name', '会社名');
  }

  $error_check_form = new Errorcheckform();
  // 氏名の空文字チェック
  $username_data = $error_check_form->word_error_check('username', '氏名');

  $birth_date_check = new Birthdatecheck();
  // 生年月日の正規化チェック
  $birth_day_data = $birth_date_check->number_error_check('birth_day', '生年月日');

  $check_expansion = new Checkexpansion();
  // メールアドレスの正規化チェック
  $mailaddress_data = $check_expansion->word_error_check('mailaddress', 'メールアドレス');
  // 郵便番号の正規化チェック
  $post_data = $check_expansion->number_error_check('post', '郵便番号');

  // 郵便番号・都道府県・住所の部分入力不可チェック
  $set_input_data = $error_check_form->all_input_check('post', 'prefecture', 'address');
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせフォーム</title>
</head>

<body>
  <!-- header部分 -->
  <div id="contact_form">
    <h1>お問い合わせフォーム</h1>
    <p>必要事項をご記入の上、送信してください</p>
  </div>

  <!-- main部分 -->
  <form action="./confirm/confirmation.php" method="POST">
    <div class="main">
      <table border="0">
        <div id="working">
          <tr>
            <td>
              <label>事業形態</label>
            </td>
            <td class="userWrite">
              <label for="regalEntity">
                <input id="regalEntity" type="radio" name="job_category" value="法人">法人
              </label>
              <label for="individual">
                <input id="individual" type="radio" name="job_category" value="個人">個人
              </label>
            </td>
          </tr>
        </div>

        <div id="companyName">
          <tr>
            <td>
              <label for="company">会社名</label>
            </td>
            <td class="userWrite">
              <input id="company" name="company_name" type="text">
            </td>
          </tr>
        </div>


        <div id="fullName">
          <tr>
            <td>
              <label for="userName" class="item">氏名</label>
            </td>
            <td class="userWrite">
              <input id="userName" name="username" type="text">
            </td>
          </tr>
        </div>

        <!-- 区別する（distinguish） -->
        <div id="genderDistinguish">
          <tr>
            <td>
              <label id="genderName" class="item">性別</label>
            </td>
            <td class="userWrite">
              <label for="man">
                <input id="man" type="radio" name="gender" value="男">男性
              </label>
              <label for="woman">
                <input id="woman" type="radio" name="gender" value="女">女性
              </label>
            </td>
          </tr>
        </div>

        <div id="dateBirth">
          <tr>
            <td>
              <label for="birth" class="item">生年月日</label>
            </td>
            <td class="userWrite">
              <input id="birth" name="birth_day" type="text" maxlength="8">
            </td>
          </tr>
        </div>

        <div id="mailaddress">
          <tr>
            <td>
              <label for="mail" class="item">メールアドレス</label>
            </td>
            <td class="user_write">
              <input id="mail" name="mailaddress" type="text">
            </td>
          </tr>
        </div>

        <div id="postCode">
          <tr>
            <td>
              <label for="post" class="item">郵便番号</label>
            </td>
            <td class="userWrite">
              〒<input id="post" name="post" type="text" maxlength="7">
            </td>
          </tr>
        </div>

        <div>
          <tr>
            <td><button type="button" name="search" id="serch">検索</button></td>
          </tr>
        </div>

        <div id="prefecture">
          <tr>
            <td>
              <label for="domestic">都道府県</label>
            </td>
            <td class="user_write">
              <select name="prefecture" id="domestic">
                <option value="" selected>選択してください</option>
                <option value="北海道">北海道</option>
                <option value="青森県">青森県</option>
                <option value="秋田県">秋田県</option>
                <option value="岩手県">岩手県</option>
                <option value="山形県">山形県</option>
                <option value="宮城県">宮城県</option>
                <option value="福島県">福島県</option>
                <option value="茨城県">茨城県</option>
                <option value="栃木県">栃木県</option>
                <option value="群馬県">群馬県</option>
                <option value="埼玉県">埼玉県</option>
                <option value="神奈川県">神奈川県</option>
                <option value="千葉県">千葉県</option>
                <option value="東京都">東京都</option>
                <option value="山梨県">山梨県</option>
                <option value="長野県">長野県</option>
                <option value="新潟県">新潟県</option>
                <option value="富山県">富山県</option>
                <option value="石川県">石川県</option>
                <option value="福井県">福井県</option>
                <option value="岐阜県">岐阜県</option>
                <option value="静岡県">静岡県</option>
                <option value="愛知県">愛知県</option>
                <option value="三重県">三重県</option>
                <option value="滋賀県">滋賀県</option>
                <option value="京都府">京都府</option>
                <option value="大阪府">大阪府</option>
                <option value="兵庫県">兵庫県</option>
                <option value="奈良県">奈良県</option>
                <option value="和歌山県">和歌山県</option>
                <option value="鳥取県">鳥取県</option>
                <option value="島根県">島根県</option>
                <option value="岡山県">岡山県</option>
                <option value="広島県">広島県</option>
                <option value="山口県">山口県</option>
                <option value="徳島県">徳島県</option>
                <option value="香川県">香川県</option>
                <option value="愛媛県">愛媛県</option>
                <option value="高知県">高知県</option>
                <option value="福岡県">福岡県</option>
                <option value="佐賀県">佐賀県</option>
                <option value="長崎県">長崎県</option>
                <option value="熊本県">熊本県</option>
                <option value="大分県">大分県</option>
                <option value="宮崎県">宮崎県</option>
                <option value="鹿児島県">鹿児島県</option>
                <option value="沖縄県">沖縄県</option>
              </select>
            </td>
          </tr>
        </div>

        <div id="address">
          <tr>
            <td>
              <label for="residence">住所</label>
            </td>
            <td class="user_write">
              <input id="residence" name="address" type="text">
            </td>
          </tr>
        </div>

        <div id="content">
          <tr>
            <td>
              <label for="contentArea">お問い合わせ内容</label><br>
            </td>
            <td class="userWrite">
              <textarea id="contentArea" name="contents" cols="30" rows="10"></textarea>
            </td>
          </tr>
          <tr>
            <td>
              <input id="submit" type="submit" name="submit" value="送信">
            </td>
          </tr>
        </div>
      </table>
    </div>
  </form>
  </div>
</body>

</html>