<?php
include_once("../../loginFunction/connect/connect.php");
session_start();
$error_message = array();
// 1.入力チェック
if (isset($_POST)) {
  if (isset($_POST['signUpButton'])) {
    if (empty($_POST['account'])) {
      $error_message[] = 'ユーザー名が入力されていません';
    } else if (strlen($_POST['account']) > 50) {
      $error_message[] = 'ユーザー名は50文字以内にしてください';
    } else {
      $_POST['account'] = htmlspecialchars($_POST['account'], ENT_QUOTES, 'UTF-8');
    }
  }

  // 2.新規ユーザー登録
  $duplication_error = array();
  if (empty($error_message)) {
    // 新規ユーザーのアカウントが重複していないかをチェックする
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bindParam(1, $_POST['account']);
    $stmt->execute();
    $data = count($stmt->fetchAll(PDO::FETCH_COLUMN));
    if ($data !== 0) {
      $duplication_error['duplication'] = 'そのアカウント名はすでに登録されています';
    } else {
      $stmt = $pdo->prepare("INSERT INTO users(username) VALUE(:username)");
      $stmt->bindParam(':username', $_POST['account']);
      $stmt->execute();
    }
  }
}


$message_sign_app = "ユーザー名・" . $_POST['account'] . "を追加しました";
$message_sign_app_error = "ユーザー名・" . $_POST['account'] . "を正常に追加できませんでした" . '<br>' . "もう一度お確かめください";

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
    <?php if (!empty($_POST['signUpButton'])) { ?>
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