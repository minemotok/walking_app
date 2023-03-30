<?php
include_once('../connect/connect.php');

session_start();

if (isset($_POST) && !empty($_POST)) {
  include_once('../error_check/error_check.php');
  // 1.入力チェック
  $error_check = new Errorcheck();
  // ユーザー名のチェック

  // パスワードのチェック
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
    <?php if (isset($error_message)) : ?>
    <div class="error_message">
      <div id="yellow">
        <i id="mark" class="fa fa-exclamation-triangle" aria-hidden="true"></i>
        <span>もう一度入力してください</span>
      </div>
      <?php if (isset($error) && !empty($error)) : ?>
      <?php foreach ($error as $err) {
          echo "<span>" . $err . "</span>" . "<br>";
        } ?>
      <?php endif; ?>
      <?php if (isset($error_message) && !empty($error_message)) : ?>
      <?php foreach ($error_message as $message) {
          echo "<span>" . $message . "</span>" . "<br>";
        }
        ?>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="container mt-4">
      <form method="POST">
        <div class="userInput">
          <div class="col loginTitle">
            <p id="mainTitle">ログイン画面</p>
          </div>

          <div class="userDisplay row" id="username">
            <div class="col center-block">
              <label for="accountId" id="text">アカウント名</label>
              <input type="text" class="form-control" id="text" name="account" placeholder="yamada tarou">
            </div>
          </div>

          <div class="userDisplay row">
            <div class="col center-block">
              <label for="passwordId" id="text">パスワード</label>
              <input type="password" class="form-control userDisplay" id="passwordId" name="password"
                placeholder="Password">
            </div>
          </div>

          <div class="submit row">
            <div class="col text-center">
              <input type="submit" name="sign_up_Button" class="btn btn-primary" value="ログイン">
            </div>
          </div>

          <div class="row">
            <div class="col text-center">
              <a href="../signUp/signUp.php" class="link_abbsolute">
                <span>新規登録画面</span>
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>

  </body>