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
      $_SESSION['account'] = $_POST['account'];
      echo "<script src='./location.js'></script>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./signUpAdmin.css">
    <script src="../../jquery/jquery-3.6.3.min.js"></script>
  </head>

  <body>
    <form method="POST">
      <div class="errorDisplay">
        <?php
      if (!empty($error_message)) {
        foreach ($error_message as $error) {
          echo "<p>" . $error . '<br/>' . "</p>";
        }
      } else if (!empty($duplication_error)) {
        echo "<p>" . $duplication_error['duplication'] . '<br/>' . "</p>";
      }
      ?>
      </div>
      <div class="userInput">

        <div class="main">
          <p id="mainTitle">新規アカウント登録</p>
        </div>

        <div class="userDisplay" id="username">
          <label for="accountId" id="text">アカウント名</label>
          <input type="text" class="form-control" id="text" name="account" placeholder="yamada tarou">
        </div>

        <div class="submit">
          <input type="submit" name="signUpButton" class="btn btn-primary" value="新規登録">
        </div>

        <div class="backLink">
          <a href="../userAdmin.php">HOMEへ戻る</a>
        </div>
      </div>
    </form>
  </body>

</html>