<?php
session_start();
include_once('../loginFunction/connect/connect.php');

$stmt = $pdo->prepare("SELECT id, username, email FROM users");
$stmt->execute();
$user_data_init_count = count($stmt->fetchAll(PDO::FETCH_ASSOC));

if (isset($_GET['keyword'])) {
  $keyword = htmlspecialchars($_GET['keyword'], ENT_QUOTES, 'UTF-8');
} else {
  $keyword = "";
}

// ページネーションを作成
// ページの情報がGET送信されてきたかどうか
if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 1;
}
// 10件ずつ表示するための計算
$pages = $page * 10 - 10;

// 検索した時のデータを取得する
if (!empty($_POST['account_btn'])) {
  $stmt_match = $pdo->prepare("SELECT * FROM users WHERE username LIKE :keyword LIMIT :pages,10");
  // 部分一致のキーワード
  $stmt_match->bindValue(":keyword", $match, PDO::PARAM_STR);
  $stmt_match->bindValue(":pages", $pages, PDO::PARAM_INT);
  $stmt_match->execute();
  $user_data = $stmt_match->fetchAll(PDO::FETCH_ASSOC);
  $user_data_count = count($stmt_match->fetchAll(PDO::FETCH_ASSOC));
} else {
  $stmt_match = $pdo->prepare("SELECT * FROM users WHERE username LIKE :keyword LIMIT :pages,10");
  // 部分一致のキーワード
  $match = "%$keyword%";
  $stmt_match->bindValue(":keyword", $match, PDO::PARAM_STR);
  $stmt_match->bindValue(':pages', $pages, PDO::PARAM_INT);
  $stmt_match->execute();
  $user_data = $stmt_match->fetchAll(PDO::FETCH_ASSOC);
  $user_data_count = count($stmt_match->fetchAll(PDO::FETCH_ASSOC));
}
// 表示画面のレコードの数からページ位置を取得 例・(データが15件の場合、現在のレコードは2ページ目の位置)
$page_position = $user_data_init_count / 10;
$user_data_position = $user_data_count / 10;
// 値の切り上げ 例・(データが15件の場合、15件 / 10 より1.5となり1.5の数値を整数に切り上げるための処理)
$pagenation_init = ceil($page_position);
$pagenation = ceil($user_data_position);

$err_message = array();
// ページを1つ戻る・ページを1つ進める処理
if (isset($_GET['back']) !== false) {
  // ページを一つ戻る
  if ($page < 2) {
    // ページを遷移させない
  } else {
    // ページを一つ前に戻す
    $back_page = ($_GET['page'] - 1) * 10 - 10;
    $stmt_match = $pdo->prepare("SELECT * FROM users WHERE username LIKE :keyword LIMIT :pages,10");
    // 部分一致のキーワード
    $stmt_match->bindValue(":keyword", $match, PDO::PARAM_STR);
    $stmt_match->bindValue(':pages', $back_page, PDO::PARAM_INT);
    $stmt_match->execute();
    $user_data = $stmt_match->fetchAll(PDO::FETCH_ASSOC);
    $user_data_count = count($stmt_match->fetchAll(PDO::FETCH_ASSOC));
  }
} elseif (isset($_GET['next']) !== false) {
  $next_page = ($_GET['page'] + 1) * 10 - 10;
  $stmt_match = $pdo->prepare("SELECT * FROM users WHERE username LIKE :keyword LIMIT :pages,10");
  // 部分一致のキーワード
  $stmt_match->bindValue(":keyword", $match, PDO::PARAM_STR);
  $stmt_match->bindValue(":pages", $next_page, PDO::PARAM_INT);
  $stmt_match->execute();
  $user_data = $stmt_match->fetchAll(PDO::FETCH_ASSOC);
  $user_data_count = count($stmt_match->fetchAll(PDO::FETCH_ASSOC));
}

?>
<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー管理画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="userAdmin.css">
    <script src='../jquery/jquery-3.6.3.min.js'></script>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.13.0/themes/sunny/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://kit.fontawesome.com/aabf80ac97.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <!-- 見出し部分 -->
    <div class="container">
      <div class="row headtag">
        <div class="col user-admin">
          <?php if (!empty($err_message)) {
          foreach ($err_message as $error) {
            echo '<div class="error-message"><i class="fa-solid fa-triangle-exclamation"></i><p class="account-error">' . $error . '</p></div>' . '<br>';
          }
        }
        ?>
          <h1>ユーザー管理画面</h1>
        </div>
      </div>

      <!-- 検査窓 -->
      <div class="row search">
        <div class="col-7 search-table">
          <form action="userAdmin.php" method="GET" class="search-get">
            <input type="text" name="keyword" id="to" placeholder="アカウント名から検索できます" value="<?= $keyword ?>">
            <button id="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
          </form>
        </div>
        <div class="col">
          <span class="sign">新規登録</span>
          <a href='./signUpAdmin/sign_up_admin.php'><i class='sign-app fa-solid fa-user'></i></a>
        </div>
      </div>

      <!-- ユーザー情報のテーブル -->
      <div class="row table-data">
        <form method="GET">
          <div class="col">
            <table class="table table-striped userinfo-table">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">アカウント名</th>
                  <th scope="col">メールアドレス</th>
                  <th scope="col">一日に歩いた距離</th>
                  <th class="icon" scope="col">更新</th>
                  <th class="icon" scope="col">削除</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($user_data as $user_info) : ?>
                <tr>
                  <th scope="row"><?php echo $user_info['id']; ?></th>
                  <td><?php echo $user_info['username']; ?></td>
                  <td><?php echo $user_info['email']; ?></td>
                  <td></td>
                  <td class="icon">
                    <?php
                    if (!isset($_GET['page']) || $_GET['page'] === '1') {
                      echo "<a href='./update_admin/update_admin.php?user_id={$user_info['id']}'>
                    <i class='fa-solid fa-wrench'></i>
                    </a>";
                    } else if (isset($_GET['page'])) {
                      echo "<a href='./update_admin/update_admin.php?page={$_GET['page']}&user_id={$user_info['id']}'>
                      <i class='fa-solid fa-wrench'></i>
                      </a>";
                    }
                    ?>
                  </td>
                  <td class="icon">
                    <?php
                    if (!isset($_GET['page']) || $_GET['page'] === '1') {
                      echo "<a href='./delete_admin/delete.php?user_id={$user_info['id']}'>
                    <i class='fas fa-trash'></i>
                    </a>";
                    } else if (isset($_GET['page'])) {
                      echo "<a href='./delete_admin/delete.php?page={$_GET['page']}&user_id={$user_info['id']}'>
                    <i class='fas fa-trash'></i>
                    </a>";
                    }
                    ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="page-state">
              <nav aria-label="Page navigation example">
                <ul class="pagination pages">
                  <!-- 検索ボタンを押して処理されものかどうか判定 -->
                  <!-- ページネーション処理 -->
                  <?php if (empty($keyword)) : ?>
                  <?php for ($i = 1; $i <= $pagenation_init; $i++) : ?>
                  <li class="page-item">
                    <a class="page-link" href="./userAdmin.php?page=<?= $i ?>"><?= $i ?></a>
                  </li>
                  <?php endfor; ?>

                  <?php else : ?>
                  <?php for ($i = 1; $i <= $pagenation; $i++) : ?>
                  <li class="page-item">
                    <a class="page-link" href="./userAdmin.php?page=<?= $i ?>"><?= $i ?></a>
                  </li>
                  <?php endfor; ?>
                  <?php endif; ?>
                </ul>
              </nav>
            </div>
        </form>
      </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
      integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
      integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src='./delete_admin/delete_dialog.js'></script>
  </body>

</html>