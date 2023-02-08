<?php
session_start();
include('../../loginFunction/connect/connect.php');

// ユーザー管理画面からのセッションデータが存在したときの処理
if (isset($_SESSION['user_delete_account']) && !empty($_SESSION['user_delete_account'])) {
  $stmt = $pdo->prepare("DELETE FROM users WHERE username=:username");
  $stmt->bindValue(':username', $_SESSION['user_delete_account'], PDO::PARAM_STR);
  $stmt->execute();

  $count = $stmt->rowCount();
  $message_delete = "ユーザーID" . $_SESSION['user_id'] . "のユーザー情報を削除しました";
  $message_delete_error = "ユーザーID" . $_SESSION['user_id'] . "のユーザー情報を正常に削除できませんでした" . '<br>' . "もう一度お確かめください";
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー削除画面</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="delete_admin.css">
  <script src="../../jquery/jquery-3.6.3.min.js"></script>
  <script src="https://kit.fontawesome.com/aabf80ac97.js" crossorigin="anonymous"></script>
</head>

<body>
  <div id="overlay">
    <div class="cv-spinner">
      <span class="spinner"></span>
      <div class="roading"></div>
    </div>
  </div>
  <?php if ($count > 0) { ?>
    <div class="delete-check">
      <div class="delete-complete">
        <i class="fa-regular fa-circle-check"></i>
      </div>
      <?php echo '<div class="message">' . $message_delete . '</div>'; ?>
      <div class="back-home">
        <a href="../userAdmin.php" class="link_abbsolute">
          <span>ユーザー管理画面へ戻る</span>
        </a>
      </div>
    </div>
  <?php } else { ?>
    <div class="delete-check-error">
      <div class="delete-complete-error">
        <i class="fa-regular fa-circle-xmark"></i>
      </div>
      <?php echo '<div class="message-error">' . $message_delete_error . '</div>'; ?>
      <div class="back-home">
        <a href="../userAdmin.php" class="link_abbsolute">
          <span>ユーザー管理画面へ戻る</span>
        </a>
      </div>
    </div>
  <?php } ?>
  <script src="delete_admin.js"></script>
</body>

</html>