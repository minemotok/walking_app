<?php
include_once('../../loginFunction/connect/connect.php');
session_start();
$err_message = array();

if (isset($_POST['update_submit'])) {
  $_POST['account'] = htmlspecialchars($_POST['account'], ENT_QUOTES, 'UTF-8');
  $_POST['mailaddress'] = htmlspecialchars($_POST['mailaddress'], ENT_QUOTES, 'UTF-8');

  // 1. ユーザーデータの更新機能
  if (!empty($_POST['account']) && !empty($_POST['mailaddress'])) {
    $stmt = $pdo->prepare("UPDATE users SET username=:username, email=:email WHERE id=:id");
    $stmt->bindValue(':username', $_POST['account'], PDO::PARAM_STR);
    $stmt->bindValue(':email', $_POST['mailaddress'], PDO::PARAM_STR);
    $stmt->bindValue(':id', $_POST['user_id'], PDO::PARAM_INT);
    $stmt->execute();

    $_SESSION['update_submit'] = $_POST['update_submit'];

    // 2. 更新した後、更新されたかされていないかチェック画面に遷移する
    $host = $_SERVER['HTTP_HOST'];
    $dir = dirname($_SERVER['PHP_SELF'], 2);
    header("Location: //$host$dir/update_admin/update_check.php");
    exit;
  }
}

if (isset($_SESSION['user_update_account'])) {
  // 1. データベースのusersテーブルからレコードを取得してくる
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username=:username");
  $stmt->bindValue(':username', $_SESSION['user_update_account'], PDO::PARAM_STR);
  $stmt->execute();
  $update_recode = $stmt->fetch(PDO::FETCH_ASSOC);

  //2. sqlを実行した時に不正な値が入力された場合
  if ($update_recode === false) {
    $err_message[] = "ユーザー情報を検索できませんでした" . '<br>' . "もう一度アカウント名を入力してください";
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー更新画面</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="update_admin.css">
  <script src="https://kit.fontawesome.com/aabf80ac97.js" crossorigin="anonymous"></script>
</head>

<body>
  <form method="POST">
    <?php if (!empty($err_message)) {
      foreach ($err_message as $error) {
        echo '<div class="error-message"><i class="fa-solid fa-triangle-exclamation"></i><p class="account-error">' . $error . '</p></div>' . '<br>';
      }
    }
    ?>
    <div class="userInput">

      <div class="main">
        <p id="mainTitle">ユーザー情報更新</p>
      </div>

      <div class="userDisplay" id="username">
        <label for="accountId" id="text">ID</label>
        <input type="text" class="form-control" name="user_id" value="<?php if ($update_recode !== false) {
                                                                        echo $update_recode['id'];
                                                                        $_SESSION['user_id'] = $update_recode['id'];
                                                                      } else {
                                                                        echo null;
                                                                      }
                                                                      ?>" readonly>
      </div>

      <div class="userDisplay" id="username">
        <label for="accountId" id="text">アカウント名</label>
        <input type="text" class="form-control" name="account" value="<?php if ($update_recode !== false) {
                                                                        echo $update_recode['username'];
                                                                      } else {
                                                                        echo null;
                                                                      } ?>">
      </div>

      <div class="userDisplay">
        <label for="mailaddress" id="text">メールアドレス</label>
        <input type="text" class="form-control userDisplay" name="mailaddress" value="<?php if ($update_recode !== false) {
                                                                                        echo $update_recode['email'];
                                                                                      } else {
                                                                                        echo null;
                                                                                      }
                                                                                      ?>">
      </div>

      <div class="submit">
        <input type="submit" name="update_submit" class="btn btn-primary" value="更新">
      </div>

      <div class="backLink">
        <a href="../userAdmin.php">HOMEへ戻る</a>
      </div>
    </div>
  </form>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
  </script>
</body>

</html>