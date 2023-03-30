<?php

declare(strict_types=1);
mb_language('Japanese');
mb_internal_encoding('UTF-8');
include_once('./loginFunction/connect/connect.php');
session_start();

require_once('./vendor/composer/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// セッションにユーザーが格納されているかどうか確認
if (empty($_SESSION['account'])) {
  $host = $_SERVER['HTTP_HOST'];
  $dir = dirname($_SERVER['PHP_SELF'], 1);
  header("Location://$host$dir/loginFunction/login/login.php");
} else {
  // レビューを画面に表示するためのsql
  // reviewsテーブルにあるuser_idとusersテーブルのid、review_idとrevie_itemsテーブルにあるidが等しいときの値を取得
  $stmt = $pdo->prepare("SELECT star_number, review_content, date_time, title, username FROM reviews 
                      INNER JOIN review_items ON review_id = review_items.id
                      INNER JOIN users ON user_id = users.id");
  $stmt->execute();
  $review_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $review_count = count($review_data);

  // ページネーション
  define('MAX', 8);
  $max_page = ceil($review_count / MAX);
  if (!isset($_GET['page_id'])) {
    $now = 1;
  } else {
    $now = $_GET['page_id'];
  }
  $start = ($now - 1) * MAX;
  $display = array_slice($review_data, $start, MAX, true);

  // 経由地点の配列
  $waypoints_array = array(
    "ハウステンボス",
    "稲佐山山頂展望台",
    "百花台公園",
    "グラバー園",
    "長崎新中華街",
    "平和公園",
    "長崎バイオパーク",
    "九十九島水族館海きらら",
    "九十九島動植物園森きらら",
    "山茶花高原ピクニックパーク",
    "結の浜マリンパーク",
    "大村公園",
    "長崎美術館",
    "佐世保五番街",
    "長崎水辺の森公園",
    "大浦天主堂",
    "アルカス佐世保",
    "ミライon図書館",
    "雲仙地獄",
    "長崎オランダ村"
  );
}

?>

<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>レビュー画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./reviews/reviews.css">
    <script src="./jquery/jquery-3.6.3.min.js"></script>
  </head>

  <body>
    <div class="container">
      <div class="row">
        <div class="col headline">
          <h1>おすすめの地点口コミ欄</h1>
        </div>
      </div>
      <?php foreach ($waypoints_array as $waypoint) : ?>
      <?php
      $url_textsearch = "https://maps.googleapis.com/maps/api/place/textsearch/json?query={$waypoint}&language=ja&key={$_ENV['API_KEY']}";
      $data = file_get_contents($url_textsearch);
      $data_decode = json_decode($data, true);
      $data_place_id = $data_decode['results'][0]['place_id'];
      $url_place_details = "https://maps.googleapis.com/maps/api/place/details/json?fields=website%2Cformatted_phone_number&place_id={$data_place_id}&key={$_ENV['API_KEY']}";
      $data_place_details = file_get_contents($url_place_details);
      $place_details_decode = json_decode($data_place_details, true);
      ?>
      <form action="./reviews/check/check.php" method="POST">
        <div class="row">
          <div class="col">
            <input name="title" type="hidden" value="<?= $data_decode['results'][0]['name']; ?>">
            <h2 id="headline-title"><?= $data_decode['results'][0]['name']; ?></h2>
          </div>
        </div>
        <div class="row contents">
          <div id="place_image" class="col-5">
            <img
              src="<?php echo "https://maps.googleapis.com/maps/api/place/photo?maxwidth=300&maxheight=300&photo_reference={$data_decode['results'][0]['photos'][0]['photo_reference']}&key={$_ENV['API_KEY']}" ?>">
          </div>
          <div class="col-7">
            <table class="table table-striped">
              <tr>
                <th>住所</th>
                <td class="write"><?= $data_decode['results'][0]['formatted_address']; ?></td>
              </tr>
              <tr>
                <th>電話番号</th>
                <td class="write"><?= $place_details_decode['result']['formatted_phone_number']; ?></td>
              </tr>
              <tr>
                <th>詳細</th>
                <td class="write" id="details">
                  <?= "<a href={$place_details_decode['result']['website']}>{$data_decode['results'][0]['name']}</a>"; ?>
                </td>
              </tr>
              <tr>
                <th>星数</th>
                <td class="write">
                  <div>
                    <span class="number_rating">
                      <input name="star_number" id="star-of-number" type="hidden">
                      <img src="./reviews/raty/star-off.png" data-name="<?= $data_decode['results'][0]['name']; ?>"
                        data-id="star-1-<?= $data_decode['results'][0]['name']; ?>" class="star"
                        id="star-function-1-<?= $data_decode['results'][0]['name']; ?>">
                      <img src="./reviews/raty/star-off.png" data-name="<?= $data_decode['results'][0]['name']; ?>"
                        data-id="star-2-<?= $data_decode['results'][0]['name']; ?>" class="star"
                        id="star-function-2-<?= $data_decode['results'][0]['name']; ?>">
                      <img src="./reviews/raty/star-off.png" data-name="<?= $data_decode['results'][0]['name']; ?>"
                        data-id="star-3-<?= $data_decode['results'][0]['name']; ?>" class="star"
                        id="star-function-3-<?= $data_decode['results'][0]['name']; ?>">
                      <img src="./reviews/raty/star-off.png" data-name="<?= $data_decode['results'][0]['name']; ?>"
                        data-id="star-4-<?= $data_decode['results'][0]['name']; ?>" class="star"
                        id="star-function-4-<?= $data_decode['results'][0]['name']; ?>">
                      <img src="./reviews/raty/star-off.png" data-name="<?= $data_decode['results'][0]['name']; ?>"
                        data-id="star-5-<?= $data_decode['results'][0]['name']; ?>" class="star"
                        id="star-function-5-<?= $data_decode['results'][0]['name']; ?>">
                    </span>
                    <button type="button" data-name="<?= $data_decode['results'][0]['name']; ?>"
                      class="btn btn-primary btn-sm reset">リセット</button>
                  </div>
                </td>
              </tr>
              <tr>
                <th>レビュー記入欄</th>
                <td class="write">
                  <div class="form-floating">
                    <textarea name="review_text" class="form-control reviews" id="floatingTextarea"></textarea>
                    <label for="floatingTextarea">ご感想等お書きください</label>
                  </div>
                </td>
              </tr>
              <tr>
                <th>書き込み</th>
                <td class="write"><input name="send" type="submit" class="btn btn-primary btn-sm" id="send-button"
                    value="送信">
                </td>
              </tr>
            </table>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col">
          <table class="table table-striped">
            <th>
              <?php if ($review_count >= 1) {
                echo "レビュー欄";
              } ?>
            </th>
            <tr>
              <td class="review">
                <!-- レビューの星数をデータベースから取り出しセットする -->
                <!-- 配列が回った回数をカウントする -->
                <?php $count = 0; ?>
                <?php foreach ($display as $data) : ?>
                <?php if ($data['title'] === $data_decode['results'][0]['name']) : ?>
                <?php $count++; ?>
                <div class="comments">
                  <span>
                    レビュー星数・
                    <?php
                        switch ($data['star_number']) {
                          case 'star-5':
                            for ($i = 0; $i < 5; $i++) {
                              echo "<img src='./reviews/raty/star-on.png'>";
                            }
                            break;
                          case 'star-4':
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            break;
                          case 'star-3':
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            break;
                          case 'star-2':
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            break;
                          case 'star-1':
                            echo "<img src='./reviews/raty/star-on.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            echo "<img src='./reviews/raty/star-off.png'>";
                            break;
                          case 'star-0':
                            for ($i = 0; $i < 5; $i++) {
                              echo "<img src='./reviews/raty/star-off.png'>";
                            }
                            break;
                        }
                        ?>
                  </span>
                  <div>
                    ユーザー名・<?= $data['username']; ?>
                  </div>
                  <div>
                    投稿日時・<?php
                              echo date('Y年m月d日', strtotime($data['date_time']));
                              ?>
                  </div>
                  <p>
                    <!-- レビュー（口コミ）をデータベースから取り出しセットする -->
                    <?= $data['review_content']; ?>
                  </p>
                </div>
                <?php endif; ?>
                <?php if ($count === MAX) : ?>
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <?php
                        // 前のページに1つ戻る
                        if ($now > 1) {
                          $page_back = $now - 1;
                          echo "<li class='page-item'>
                            <a class='page-link' href='./reviews.php?page_id={$page_back}' aria-label='Previous'>
                            <span aria-hidden='true'>&laquo;</span>
                            </a>
                          </li>";
                        } else {
                          echo "";
                        }
                        // 現在のページを表示する
                        for ($i = 1; $i <= $max_page; $i++) {
                          if ($i === $now) {
                            echo "<li class='page-item'>
                              <a class='page-link' href='./reviews.php?page_id={$now}'>{$now}</a>
                            </li>";
                          } else {
                            echo "";
                          }
                        }
                        // 次のページに進める
                        if ($now < $max_page) {
                          $page_next = $now + 1;
                          echo "<li class='page-item'>
                          <a class='page-link' href='./reviews.php?page_id={$page_next}' aria-label='Next'>
                          <span aria-hidden='true'>&raquo;</span>
                          </a>
                          </li>";
                        } else {
                          echo "";
                        }
                        ?>
                  </ul>
                </nav>
                <?php endif; ?>
                <?php endforeach; ?>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <script src="./reviews/raty/raty.js"></script>
    <script src="./reviews/check/check.js"></script>
  </body>