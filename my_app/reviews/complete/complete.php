<?php
include_once('../../loginFunction/connect/connect.php');
session_start();
// 送信ボタンを押されたときの処理
$error_message = array();
if (!empty($_POST['reviews_submit'])) {
  // レビュー記入欄の入力内容チェック
  if (empty($_POST['review_text'])) {
    $error_message[] = 'レビュー記入欄に記入し、送信してください';
  } else if (strlen($_POST['review_text']) > 250) {
    $error_message[] = 'レビューは250文字以内で送信してください';
  } else {
    $_SESSION['review_content'] = htmlspecialchars($_POST['review_text'], ENT_QUOTES, 'UTF-8');
  }
  // 送信ボタンがクリックされたときにエラーが出なかったらデータベースに保存する
  if (empty($error_message)) {
    date_default_timezone_set('Asia/Tokyo');
    $date_time = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO reviews(star_number, review_content, date_time, user_id, review_id)
                          VALUE(:star_number, :review_content, :date_time, 
                          (SELECT id FROM users WHERE username=:username),
                          (SELECT id FROM review_items WHERE title=:title))");
    $stmt->bindValue(":star_number", $_SESSION['star_number'], PDO::PARAM_STR);
    $stmt->bindValue(":review_content", $_SESSION['review_content'], PDO::PARAM_STR);
    $stmt->bindValue(":date_time", $date_time, PDO::PARAM_STR);
    $stmt->bindValue(":username", $_SESSION['account'], PDO::PARAM_STR);
    $stmt->bindValue(":title", $_POST['title'], PDO::PARAM_STR);
    $stmt->execute();
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>レビュー登録完了画面</title>
  <link rel="stylesheet" href="complete.css">
  <script src="https://kit.fontawesome.com/4e00f87af3.js" crossorigin="anonymous"></script>
</head>

<body>
  <?php
  if (!empty($error_message)) {
    foreach ($error_message as $error) {
      echo "<div class='error-message'>
            <i id='note' class='fa-solid fa-triangle-exclamation'></i>
            <p class='error'>{$error}</p>
            </div>";
    }
  }
  ?>
  <div class="container">
    <div class="row complete_title">
      <div class="col title_text">
        <h1>登録完了</h1>
      </div>
    </div>

    <div class="row complete_icon">
      <div class="col">
        <i class="fa-regular fa-circle-check"></i>
      </div>
    </div>

    <div class="row complete_text">
      <div class="col">
        <p id="text_head">レビュー登録完了しました</p>
        <p id="text_body">
          レビュー投稿ありがとうございます<br>
          今後とも、情報共有の際に利用していただけると幸いです
        </p>
      </div>
    </div>

    <div class="row back_home">
      <div class="col">
        <a href="../../reviews.php" class="link_abbsolute">
          <span>レビュー記入欄へ戻る</span>
        </a>
      </div>
    </div>

  </div>
</body>

</html>