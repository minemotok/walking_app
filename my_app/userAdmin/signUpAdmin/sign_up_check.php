<?php
session_start();

$message_sign_app = "ユーザー名・" . $_SESSION['account'] . "を追加しました";
$message_sign_app_error = "ユーザー名・" . $_SESSION['account'] . "を正常に追加できませんでした" . '<br>' . "もう一度お確かめください";

?>

<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録チェック画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../update_admin/update_check.css">
    <script src="https://kit.fontawesome.com/aabf80ac97.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <?php if (!empty($_SESSION['account'])) { ?>
    <div class="delete-check">
      <div class="delete-complete">
        <i class="fa-regular fa-circle-check"></i>
      </div>
      <?php echo '<div class="message">' . $message_sign_app . '</div>'; ?>
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
      <?php echo '<div class="message-error">' . $message_sign_app_error . '</div>'; ?>
      <div class="back-home">
        <a href="sign_up_admin.php" class="link_abbsolute">
          <span>ユーザー登録画面へ戻る</span>
        </a>
      </div>
    </div>
    <?php } ?>
  </body>

</html>