<?php

include("../connect/connect.php");

$error_message = array();
$escape = array();
// 1.入力チェック
if (!empty($_POST)) {
  if (isset($_POST['signUpButton'])) {
    if (empty($_POST['account'])) {
      $error_message[] = 'ユーザー名が入力されていません';
    } else if (strlen($_POST['account']) > 50) {
      $error_message[] = 'ユーザー名は50文字以内にしてください';
    } else {
      $escape['account'] = htmlspecialchars($_POST['account'], ENT_QUOTES, 'UTF-8');
    }

    if (empty($_POST['mailAddress'])) {
      $error_message[] = 'メールアドレスが入力されていません';
    } else if (strlen($_POST['mailAddress']) > 100) {
      $error_message[] = 'メールアドレスは100文字以内にしてください';
    } else if (!filter_var($_POST['mailAddress'], FILTER_VALIDATE_EMAIL)) {
      $error_message[] = 'メールアドレスが不正です';
    } else {
      $escape['mailAddress'] = htmlspecialchars($_POST['mailAddress'], ENT_QUOTES, 'UTF-8');
    }

    if (empty($_POST['password'])) {
      $error_message[] = 'パスワードが入力されていません';
    } else if (strlen($_POST['password']) > 100) {
      $error_message[] = 'パスワードは100文字以内にしてください';
    } else {
      $escape['password'] = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');
      $escape['password'] = password_hash($escape['password'], PASSWORD_DEFAULT);
    }
  }

  // 2.新規ユーザー登録
  if (!$error_message) {
    // 新規ユーザーのアカウントが重複していないかをチェックする
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bindValue(1, $_POST['account']);
    $stmt->execute();
    $data = count($stmt->fetchAll(PDO::FETCH_COLUMN));
    if (!empty($data)) {
      echo 'そのアカウント名はすでに登録されています';
    } else {
      $stmt = $pdo->prepare("INSERT INTO users(username, email, hash_password) VALUE(:username, :email, :hash_password)");
      $stmt->bindParam(':username', $escape['account']);
      $stmt->bindParam(':email', $escape['mailAddress']);
      $stmt->bindParam(':hash_password', $escape['password']);
      $stmt->execute();

      $host = $_SERVER['HTTP_HOST'];
      $dir = dirname($_SERVER['PHP_SELF'], 2);
      header("Location: //$host$dir/login/login.php");
      exit;
    }
  }
} else {
  // ゲットで来た時
  // セッションデータがあった場合はログイン画面に遷移する
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録画面</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="signUp.css">
</head>

<body>

  <div class="errorDisplay">
    <?php
    foreach ($error_message as $error) {
      echo "<p>" . $error . '<br/>' . "</p>";
    }
    ?>
  </div>

  <form method="POST">

    <div class="userInput">

      <div class="main">
        <p id="mainTitle">新規アカウント登録</p>
      </div>

      <div class="userDisplay" id="username">
        <label for="accountId" id="text">アカウント名</label>
        <input type="text" class="form-control" id="text" name="account" placeholder="yamada tarou">
      </div>

      <div class="userDisplay">
        <label for="mailId" id="text">メールアドレス</label>
        <input type="email" class="form-control userDisplay" id="mailId" name="mailAddress" placeholder="name@example.com">
      </div>

      <div class="userDisplay">
        <label for="passwordId" id="text">パスワード</label>
        <input type="password" class="form-control userDisplay" id="passwordId" name="password" placeholder="Password">
      </div>

      <div class="submit">
        <input type="submit" name="signUpButton" class="btn btn-primary" value="新規登録">
      </div>

    </div>
  </form>

</body>

</html>