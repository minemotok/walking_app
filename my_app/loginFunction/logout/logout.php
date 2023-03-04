<?php
if (isset($_POST['execute']) && !empty($_POST['execute'])) {
  session_start();
  $_SESSION = array();
  session_destroy();
  $host = $_SERVER['HTTP_HOST'];
  $dir = dirname($_SERVER['PHP_SELF'], 1);
  header("Location: //$host$dir/logout_check.php");
  exit;
}
if (isset($_POST['back']) && !empty($_POST['back'])) {
  $host = $_SERVER['HTTP_HOST'];
  $dir = dirname($_SERVER['PHP_SELF'], 3);
  header("Location: //$host$dir/main.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログアウト確認画面</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
  <link rel="stylesheet" href="./logout.css">
</head>

<body>
  <div class="container main">
    <form method="POST">
      <div class="row">
        <div class="col title">
          <h1>ログアウト確認画面</h1>
        </div>
      </div>
      <div class="row">
        <div class="col word">
          <h2>ログアウトしますか？</h2>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <input type="submit" name="execute" class="btn btn-outline-primary" value="YES"></button>
          <input type="submit" name="back" class="btn btn-outline-danger" value="NO"></button>
        </div>
      </div>
      <div class="row back">
        <div class="col">
          <a id="back" class="link_abbsolute" href="../../main.php">
            <span>ホームへ戻る</span>
          </a>
        </div>
      </div>
    </form>
  </div>
</body>