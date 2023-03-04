<?php
include_once('../connect/connect.php');
require_once('../error_check/error_check.php');

session_start();

if (!empty($_POST)) {
  // 1.入力チェック
  $error_check = new Errorcheck();
  // ユーザー名のチェック
  $account_check = $error_check->input_error_check($_POST['account'], 'account', 'ユーザー名', 50);

  // パスワードのチェック
  $password_check = $error_check->input_error_check($_POST['password'], 'password', 'パスワード', 100);
  $error = $error_check->error_message;

  // 2.アカウント情報がデータベースに保存されているか照合する
  // エラーメッセージがなかったら（配列）ではなかったら処理する
  $error_message = array();
  if (array_keys($error) !== range(0, count($error) - 1)) {
    $stmt = $pdo->prepare("SELECT username FROM users WHERE username=?");
    $stmt->bindValue(1, $_POST['account']);
    $stmt->execute();
    $data = count($stmt->fetchAll(PDO::FETCH_COLUMN));
    if ($data >= 1) {
      $_SESSION['account'] = $_POST['account'];
      // パスワード認証を行う
      $stmt = $pdo->prepare("SELECT username, hash_password FROM users");
      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
      if (password_verify($_POST['password'], $data[$_POST['account']])) {
        $host = $_SERVER['HTTP_HOST'];
        $dir = dirname($_SERVER['PHP_SELF'], 3);
        header("Location: //$host$dir/main.php");
        exit;
      } else {
        $error_message[] = 'パスワードが正しくありません';
      }
    } else {
      $error_message[] = 'アカウントが登録されていません';
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
    <title>ログイン画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./login.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
    <script src="https://kit.fontawesome.com/aabf80ac97.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <?php if (!empty($error) || !empty($error_message)) : ?>
    <div class="error_message">
      <div id="yellow">
        <i id="mark" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
        <span>もう一度入力してください</span>
      </div>
      <?php foreach ($error as $err) {
        echo "<span>" . $err . "</span>" . "<br>";
      }
      foreach ($error_message as $error) {
        echo "<span>" . $error . "</span>" . "<br>";
      }
      ?>
    </div>
    <?php endif; ?>
    </div>

    <form method="POST">

      <div class="userInput">

        <div class="main">
          <p id="mainTitle">ログイン画面</p>
        </div>

        <div class="userDisplay" id="username">
          <label for="accountId" id="text">アカウント名</label>
          <input type="text" class="form-control" id="text" name="account" placeholder="yamada tarou">
        </div>

        <div class="userDisplay">
          <label for="passwordId" id="text">パスワード</label>
          <input type="password" class="form-control userDisplay" id="passwordId" name="password"
            placeholder="Password">
        </div>

        <div class="submit">
          <input type="submit" name="sign_up_Button" class="btn btn-primary" value="ログイン">
        </div>

        <a href="../signUp/signUp.php" class="link_abbsolute">
          <span>新規登録画面</span>
        </a>
      </div>
    </form>

  </body>