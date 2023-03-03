<?php
include_once('../../loginFunction/connect/connect.php');
session_start();
if (isset($_POST['delete']) && !empty($_POST['delete'])) {
  $delete_stmt = $pdo->prepare("DELETE FROM users WHERE id=:id");
  $delete_stmt->bindValue(":id", $_POST['account'], PDO::PARAM_INT);
  $delete_stmt->execute();
  $_SESSION['account'] = $_POST['account'];
}

$message_update = "ユーザーID・" . $_POST['account'] . "のユーザー情報を削除しました";
$message_update_error = "ユーザーID・" . $_POST['account'] . "のユーザー情報を正常に削除できませんでした" . '<br>' . "もう一度お確かめください";

?>

<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー削除チェック画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../delete_admin/delete_check.css">
    <script src="https://kit.fontawesome.com/aabf80ac97.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <?php if (!empty($_SESSION['account'])) { ?>
    <div class="delete-check">
      <div class="delete-complete">
        <i class="fa-regular fa-circle-check"></i>
      </div>
      <?php echo '<div class="message">' . $message_update . '</div>'; ?>
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
      <?php echo '<div class="message-error">' . $message_update_error . '</div>'; ?>
      <div class="back-home">
        <a href="../userAdmin.php" class="link_abbsolute">
          <span>ユーザー管理画面へ戻る</span>
        </a>
      </div>
    </div>
    <?php } ?>
  </body>

</html>