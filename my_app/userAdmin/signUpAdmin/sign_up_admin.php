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
  </head>

  <body>
    <form action="../signUpAdmin/sign_up_check.php" method="POST">
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