<?php
session_start();
require_once 'input_check.php';
if (isset($_POST['submit'])) {
  $error_check_form = new Errorcheckform();
  // 氏名の空文字チェック
  $error_check_form->word_error_check('username', '氏名');

  $birth_date_check = new Birthdatecheck();
  // 生年月日の正規化チェック
  $birth_date_check->number_error_check('birth_day', '生年月日');

  $check_expansion = new Checkexpansion();
  // 郵便番号の正規化チェック
  $check_expansion->number_error_check('post', '郵便番号');
  // お問い合わせ本文チェック
  $error_check_form->word_error_check('contents', 'お問い合わせ文');

  // 郵便番号・都道府県・住所の部分入力不可チェック
  $error_check_form->all_input_check('post', 'prefecture', 'address');

  if (empty($error_check_form->error_message) && empty($birth_date_check->error_message) && empty($check_expansion->error_message)) {
    $_SESSION['username'] = $error_check_form->escape['username'];
    $_SESSION['birth_day'] = $birth_date_check->escape['birth_day'];
    $_SESSION['post'] = $check_expansion->escape['post'];
    $_SESSION['prefecture'] = htmlspecialchars($_POST['prefecture'], ENT_QUOTES, 'UTF-8');
    $_SESSION['address'] = htmlspecialchars($_POST['address'], ENT_QUOTES, 'UTF-8');
    $_SESSION['contents'] = $error_check_form->escape['contents'];
  }
  if (!empty($_POST['gender'])) {
    $_SESSION['gender'] = $_POST['gender'];
  }
}

?>

<!-- エラーが出たときに入力していた箇所はそのまま残しておく -->
<?php
if (isset($_POST['submit']) && !empty($error_check_form->error_message) || !empty($company_input_error) || !empty($birth_date_check->error_message) || !empty($check_expansion->error_message)) : ?>
  <?php
  if (empty($_POST['username'])) {
    $_POST['username'] = 'なし';
  }
  if (empty($_POST['gender'])) {
    $_POST['gender'] = 'なし';
  }
  if (empty($_POST['birth_day'])) {
    $_POST['birth_day'] = 'なし';
  }
  if (empty($_POST['post'])) {
    $_POST['post'] = 'なし';
  }
  if (empty($_POST['prefecture'])) {
    $_POST['prefecture'] = 'なし';
  }
  if (empty($_POST['address'])) {
    $_POST['address'] = 'なし';
  }
  if (empty($_POST['contents'])) {
    $_POST['contents'] = 'なし';
  }

  $post_array = array(
    'username' => $_POST['username'],
    'gender' => $_POST['gender'],
    'birth_day' => $_POST['birth_day'],
    'post' => $_POST['post'],
    'prefecture' => $_POST['prefecture'],
    'address' => $_POST['address'],
    'contents' => $_POST['contents']
  );
  $json_data = json_encode($post_array);

  ?>
  <script>
    const js_post_data = JSON.parse('<?= $json_data; ?>');
  </script>
  <script src='../../jquery/jquery-3.6.3.min.js'></script>
  <script src="./inquiry.js"></script>
<?php endif; ?>

<?php
if (isset($_GET['link']) && !empty($_GET['link'])) : ?>
  <?php
  $back_data = array(
    'username' => $_SESSION['username'],
    'gender' => $_SESSION['gender'],
    'birth_day' => $_SESSION['birth_day'],
    'post' => $_SESSION['post'],
    'prefecture' => $_SESSION['prefecture'],
    'address' => $_SESSION['address'],
    'contents' => $_SESSION['contents']
  );
  $json_back_data = json_encode($back_data);

  ?>
  <script>
    const json_back_data = JSON.parse('<?= $json_back_data; ?>');
  </script>
  <script src='../../jquery/jquery-3.6.3.min.js'></script>
  <script src="./inquiry_back.js"></script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせフォーム</title>
  <link href="inquiry.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <script src="https://kit.fontawesome.com/aabf80ac97.js" crossorigin="anonymous"></script>
</head>

<body>
  <?php if (isset($_POST['submit']) && !empty($error_check_form->error_message) || !empty($birth_date_check->error_message) || !empty($check_expansion->error_message)) : ?>
    <div class="error_message">
      <div id="yellow">
        <i id="mark" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
        <span>もう一度入力してください</span>
      </div>
      <?php
      foreach ($error_check_form->error_message as $key) {
        echo '<span>' . $key . '</span>' . '<br>';
      }
      ?>
      <?php
      foreach ($birth_date_check->error_message as $key) {
        echo '<span>' . $key . '</span>' . '<br>';
      }
      ?>
      <?php
      foreach ($check_expansion->error_message as $key) {
        echo '<span>' . $key . '</span>' . '<br>';
      }
      ?>
    </div>
  <?php endif; ?>
  <?php
  if (isset($_POST['submit']) !== false && empty($error_check_form->error_message) && empty($company_input_error) && empty($birth_date_check->error_message) && empty($check_expansion->error_message)) {
    $host = $_SERVER['HTTP_HOST'];
    $dir = dirname($_SERVER['PHP_SELF'], 1);
    header("Location: //$host$dir/confirm/confirmation.php");
  }
  ?>

  <div class="premise">
    <!-- header部分 -->
    <div id="contact_form">
      <h1>お問い合わせフォーム</h1>
      <p>※必要事項をご記入の上、送信してください</p>
    </div>
    <!-- main部分 -->
    <form method="POST">

      <div class="main">
        <table>
          <tr>
            <th>氏名<span class="red">【必須】</span></th>
            <td class="userWrite">
              <input class="form-control" placeholder="(例)山田・太郎" id="userName" name="username" type="text">
            </td>
          </tr>

          <tr>
            <th>性別<span class="gray">【任意】</span></th>
            <td class="userWrite">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="man" value="男">
                <label class="form-check-label" for="man">男性</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" id="woman" value="女">
                <label class="form-check-label" for="woman">女性</label>
              </div>
            </td>
          </tr>

          <tr>
            <th>生年月日<span class="red">【必須】</span></th>
            <td class="userWrite">
              <input class="form-control" placeholder="(例)19990101" id="birth" name="birth_day" type="text" maxlength="8">
            </td>
          </tr>

          <tr>
            <th>郵便番号<span class="red">【必須】</span></th>
            <td class="userWrite">
              <input class="form-control" placeholder="(例)0100000" id="post" name="post" type="text" maxlength="7" onKeyUp="AjaxZip3.zip2addr(this,'','prefecture','address');">
            </td>
          </tr>

          <tr>
            <th>都道府県<span class="red">【必須】</span></th>
            <td class="user_write">
              <select name="prefecture" class="form-select" id="domestic" aria-label="Default select example">
                <option value="" selected>選択してください</option>
                <option id="hokkaido" value="北海道">北海道</option>
                <option id="aomori" value="青森県">青森県</option>
                <option id="akita" value="秋田県">秋田県</option>
                <option id="iwate" value="岩手県">岩手県</option>
                <option id="yamagata" value="山形県">山形県</option>
                <option id="miyagi" value="宮城県">宮城県</option>
                <option id="fukusima" value="福島県">福島県</option>
                <option id="ibaragi" value="茨城県">茨城県</option>
                <option id="tochigi" value="栃木県">栃木県</option>
                <option id="gunma" value="群馬県">群馬県</option>
                <option id="saitama" value="埼玉県">埼玉県</option>
                <option id="kanagawa" value="神奈川県">神奈川県</option>
                <option id="chiba" value="千葉県">千葉県</option>
                <option id="tokyo" value="東京都">東京都</option>
                <option id="yamanashi" value="山梨県">山梨県</option>
                <option id="nagano" value="長野県">長野県</option>
                <option id="niigata" value="新潟県">新潟県</option>
                <option id="toyama" value="富山県">富山県</option>
                <option id="ishikawa" value="石川県">石川県</option>
                <option id="fukui" value="福井県">福井県</option>
                <option id="gifu" value="岐阜県">岐阜県</option>
                <option id="shizuoka" value="静岡県">静岡県</option>
                <option id="aichi" value="愛知県">愛知県</option>
                <option id="mie" value="三重県">三重県</option>
                <option id="shiga" value="滋賀県">滋賀県</option>
                <option id="kyoto" value="京都府">京都府</option>
                <option id="osaka" value="大阪府">大阪府</option>
                <option id="hyogo" value="兵庫県">兵庫県</option>
                <option id="nara" value="奈良県">奈良県</option>
                <option id="wakayama" value="和歌山県">和歌山県</option>
                <option id="tottori" value="鳥取県">鳥取県</option>
                <option id="shimane" value="島根県">島根県</option>
                <option id="okayama" value="岡山県">岡山県</option>
                <option id="hiroshima" value="広島県">広島県</option>
                <option id="yamaguchi" value="山口県">山口県</option>
                <option id="tokushima" value="徳島県">徳島県</option>
                <option id="kagawa" value="香川県">香川県</option>
                <option id="ehime" value="愛媛県">愛媛県</option>
                <option id="kochi" value="高知県">高知県</option>
                <option id="fukuoka" value="福岡県">福岡県</option>
                <option id="saga" value="佐賀県">佐賀県</option>
                <option id="nagasaki" value="長崎県">長崎県</option>
                <option id="kumamoto" value="熊本県">熊本県</option>
                <option id="oita" value="大分県">大分県</option>
                <option id="miyazaki" value="宮崎県">宮崎県</option>
                <option id="kagoshima" value="鹿児島県">鹿児島県</option>
                <option id="okinawa" value="沖縄県">沖縄県</option>
              </select>
            </td>
          </tr>

          <tr>
            <th>住所<span class="red">【必須】</span></th>
            <td class="user_write">
              <input class="form-control" placeholder="(例)札幌市中央区北3条西6丁目" id="residence" name="address" type="text">
            </td>
          </tr>

          <tr>
            <th>お問い合わせ<span class="red">【必須】</span></th>
            <td class="userWrite">
              <div class="form-floating">
                <textarea class="form-control" name="contents" placeholder="お問い合わせ" id="contentArea"></textarea>
                <label for="contentArea">お問い合わせ</label>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="submit-wrap">
                <input id="submit" class="btn btn-primary" type="submit" name="submit" value="OK">
              </div>
            </td>
          </tr>

        </table>
      </div>

    </form>
  </div>
</body>

</html>