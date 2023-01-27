<?php
include_once('../connect/connect.php');
require_once('../error_check/error_check.php');

session_start();

if (!empty($_POST)) {
// 1.入力チェック
$error_check = new Errorcheck();
  // ユーザー名のチェック
  $account_check = $error_check->input_error_check('account', 'ユーザー名', 50);
  // パスワードのチェック
  $password_check = $error_check->input_error_check('password', 'パスワード', 100);
  
// 2.アカウント情報がデータベースに保存されているか照合する
  // エラーメッセージがなかったら（配列）ではなかったら処理する
  if(array_keys($account_check) !== range(0, count($account_check)-1) && array_keys($password_check) !== range(0, count($password_check)-1)) {
    $stmt = $pdo->prepare("SELECT username FROM users WHERE username=?");
    $stmt->bindValue(1, $_POST['account']);
    $stmt->execute();
    $data = count($stmt->fetchAll(PDO::FETCH_COLUMN));
    if ($data) {
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
        echo 'パスワードが認証できませんでした';
      }
    } else {
      echo 'アカウントが登録されていません';
    }
  }
} else {
  // 1.セッション情報がある（ログインしている）状態であればメイン画面にリダイレクト
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
  </head>

  <body>

    <div class="errorDisplay">
      <?php
    // foreach ($error_check as $error) {
    //   echo "<p>" . $error . '<br/>' . "</p>";
    // }
    ?>
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