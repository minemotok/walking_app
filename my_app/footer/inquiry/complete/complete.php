<?php
include_once('../../../loginFunction/connect/connect.php');
if (isset($_POST) && !empty($_POST)) {
  // データベースに格納する
  print_r($_POST);
  date_default_timezone_set('Asia/Tokyo');
  $date_time = date('Y-m-d H:i:s');
  $_POST['birth_day'] = strval($_POST['birth_day']);
  $_POST['post'] = strval($_POST['post']);
  $stmt = $pdo->prepare("INSERT INTO inquirys(username, gender, birth_day, post, prefecture, address_name, inquiry, date_time)
                        VALUE(:username, :gender, :birth_day, :post, :prefecture, :address_name, :inquiry, :date_time)");
  $stmt->bindValue(":username", $_POST['username'], PDO::PARAM_STR);
  $stmt->bindValue(":gender", $_POST['gender'], PDO::PARAM_STR);
  $stmt->bindValue(":birth_day", $_POST['birth_day'], PDO::PARAM_STR);
  $stmt->bindValue(":post", $_POST['post'], PDO::PARAM_STR);
  $stmt->bindValue(":prefecture", $_POST['prefecture'], PDO::PARAM_STR);
  $stmt->bindValue(":address_name", $_POST['address'], PDO::PARAM_STR);
  $stmt->bindValue(":inquiry", $_POST['contents'], PDO::PARAM_STR);
  $stmt->bindValue(":date_time", $date_time, PDO::PARAM_STR);
  $stmt->execute();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせフォーム完了画面</title>
  <link rel="stylesheet" href="complete.css">
  <script src="https://kit.fontawesome.com/4e00f87af3.js" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="row complete_title">
      <div class="col title_text">
        <h1>送信完了</h1>
      </div>
    </div>

    <div class="row">
      <div class="col arrow">
        <span>入力</span>
        <span>確認</span>
        <span id="complete">完了</span>
      </div>
    </div>

    <div class="row complete_icon">
      <div class="col">
        <i class="fa-regular fa-circle-check"></i>
      </div>
    </div>

    <div class="row complete_text">
      <div class="col">
        <p id="text_head">お問い合わせ完了しました</p>
        <p id="text_body">
          お問い合わせいただきありがとうございます</br>
          内容を確認次第、ご対応させていただきますのでもうしばらくお待ちください
        </p>
      </div>
    </div>

    <div class="row back_home">
      <div class="col">
        <a href="../../../main.php" class="link_abbsolute">
          <span>ホームへ戻る</span>
        </a>
      </div>
    </div>

  </div>
</body>

</html>