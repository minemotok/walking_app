<?php
include_once("../../loginFunction/connect/connect.php");
session_start();

if (isset($_POST['delete']) !== false) {
  $delete_stmt = $pdo->prepare("DELETE FROM users WHERE id=:id");
  $delete_stmt->bindValue(":id", $_GET['user_id'], PDO::PARAM_INT);
  $delete_stmt->execute();
  $_SESSION['user_id'] = $_POST['account'];
  $_SESSION['delete_button'] = $_POST['delete'];
}

?>
<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー削除画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../delete_admin/delete.css">
  </head>

  <body>
    <form action="./delete_check.php" method="POST">
      <div class="userInput">

        <div class="main">
          <p id="mainTitle">このユーザーを削除しますか？</p>
        </div>

        <div class="userDisplay" id="username">
          <label for="accountId" id="text">アカウント名</label>
          <input type="text" class="form-control" id="text" name="account" value="<?= $_GET['user_id']; ?>" readonly>
        </div>

        <div class="submit">
          <input type="submit" name="delete" class="btn btn-primary" value="削除">
        </div>

        <div class="backLink">
          <a href="../userAdmin.php">HOMEへ戻る</a>
        </div>
      </div>
    </form>

  </body>