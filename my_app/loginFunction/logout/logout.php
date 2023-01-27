<?php
session_start();
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="./login.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans+JP" rel="stylesheet">
</head>

<body>
  <div class="logout">
    <p>ログアウトしますか？</p>

    <button type="button" class="btn btn-primary">YES</button>
    <button type="button" class="btn btn-danger">NO</button>
  </div>
</body>