<?php
include_once('../../loginFunction/connect/connect.php');
session_start();
$host = $_SERVER['HTTP_HOST'];
if (!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $host) !== false) {
  $refere = $_SERVER['HTTP_REFERER'];
} else {
  $dir = dirname($_SERVER['PHP_SELF'], 3);
  header("Location: //$host$dir/reviews.php");
}

if ($_POST['star_number'] == '') {
  $_POST['star_number'] = 'star-0';
}
// ポストで送られてきた値をjsonで格納する
// 背景・レビューの星機能の値を取得してjqueryで表示するため
$star_number_data = [
  'star_number' => $_POST['star_number']
];
$json_star = json_encode($star_number_data);

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
                          VALUE(:star_number, :review_content, :date_time, (SELECT id FROM users WHERE username=:username), 
                          (SELECT id FROM review_items WHERE title=:title))");
    $stmt->bindValue(":star_number", $_POST['star_number'], PDO::PARAM_STR);
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
  <title>レビュー記入確認画面</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../check/check.css">
  <script>
    const json_star = JSON.parse('<?= $json_star; ?>');
  </script>
  <script src="../../jquery/jquery-3.6.3.min.js"></script>
  <script src="https://kit.fontawesome.com/4e00f87af3.js" crossorigin="anonymous"></script>
</head>

<body>

  <!-- header部分 -->
  <div class="container">
    <form action="../complete/complete.php" method="POST">
      <div class="row">
        <div class="col">
          <h1>レビュー記入確認</h1>
        </div>
      </div>

      <div class="row confirm_text">
        <div class="col-1">
          <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <div class="col-11 element_item">
          <p>まだ、レビュー投稿は完了していません</p>
          <p>入力内容をご確認ください</p>
          <p>この内容でレビュー投稿する場合は、送信ボタンを押してください</p>
        </div>
      </div>

      <div class="row frame">
        <div class="col framework">
          <table>
            <tr class="separate_blue">
              <td class="title"><span>投稿タイトル</span></td>
              <td class="contents">
                <span>
                  <input name="title" type="hidden" value="<?= $_POST['title']; ?>">
                  <?= $_POST['title']; ?>
                </span>
              </td>
            </tr>
            <tr class="separate_sky">
              <td class="title"><span>レビュー星数</span></td>
              <td class="contents">
                <span>
                  <input name="star_number" type="hidden" value="<?= $_POST['star_number'] ?>">
                  <img class="star" id="star-function-1">
                  <img class="star" id="star-function-2">
                  <img class="star" id="star-function-3">
                  <img class="star" id="star-function-4">
                  <img class="star" id="star-function-5">
                </span>
              </td>
            </tr>
            <tr class="separate_blue">
              <td id="content_area">
                <span>レビュー投稿内容</span><br>
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
              </td>
              <td class="contents">
                <input name="review_text" type="hidden" id="#floatingTextarea" value="<?= $_POST['review_text']; ?>">
                <span>
                  <?= $_POST['review_text']; ?>
                </span>
              </td>
            </tr>
          </table>
        </div>

        <div class="row submit_button">
          <div class="col-3">
            <button type="button" id="back_button">
              <?php
              echo '<a id="back" href="' . $refere . '">戻る</a>';
              ?>
            </button>
          </div>
          <div class="col">
            <input type="submit" value="送信" name="reviews_submit" id="submitButton">
          </div>
        </div>
    </form>
  </div>
  <script src="./check.js"></script>
</body>