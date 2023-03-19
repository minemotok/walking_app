<?php
session_start();
// ルートテーブルから情報を取り出す
include_once('../../loginFunction/connect/connect.php');
$stmt = $pdo->prepare("SELECT distance, walking_time, walking_date, walking_week, username FROM routes
                      INNER JOIN users ON user_id = users.id");
$stmt->execute();
$table_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// カレンダー機能
date_default_timezone_set('Asia/Tokyo');
// 前・次のリンクがクリックされたときの処理
if (isset($_GET['month'])) {
  $month = $_GET['month'];
} else {
  $month = date('Y-m');
}
// 月始めをunix系タイムスタンプで取得
$month_timestamp = strtotime($month . '-01');
// $monthの値がタイムスタンプの値かどうかチェック
if ($month_timestamp === false) {
  $month = date('Y-m');
  $month_timestamp = strtotime($month . '-01');
}
$today = date('Y-m-j');
// カレンダーの表示月
$calendar = date('Y年m月', $month_timestamp);
// １ヶ月前・１ヶ月後の日時を表示
$prev = date('Y-m', strtotime('-1 month', $month_timestamp));
$next = date('Y-m', strtotime('+1 month', $month_timestamp));
// 月の日にちを取得(28～31)まで
$date_count = date('t', $month_timestamp);
// 月初めの曜日を(0～6)で取得
$one_day_week = date('w', $month_timestamp);

$weeks = [];
$week = '';
$week .= str_repeat('<td></td>', $one_day_week);
for ($i = 1; $i <= $date_count; $i++, $one_day_week++) {
  // 今日の日付と合致したらクラスを付与する
  $calendar_day = $month . '-' . $i;
  if ($today == $calendar_day) {
    $week .= "<td class='today'>" . $i . "</td>";
  } else {
    $week .= "<td>" . $i . "</td>";
  }
  // 週が土曜日(6)のときにtrに入れる
  if ($one_day_week % 7 == 6 || $i == $date_count) {
    // 月末でtdの空設定
    if ($i == $date_count) {
      $week .= str_repeat('<td></td>', 6 - $one_day_week % 7);
    }
    $weeks[] = '<tr>' . $week . '</tr>';
    $week = '';
  }
}

?>

<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1週間で歩いた距離データ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,700;1,100&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../calendar/calender.css">
    <link rel="stylesheet" href="./graph.css">
    <script src="../../jquery/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="../alert/jquery.confirm.css">
    <script src="../alert/jquery.confirm.js"></script>
    <script src="https://kit.fontawesome.com/aabf80ac97.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <div id="all-contents" class="main container-fluid">
      <div class="row">
        <header class="navbar navbar-dark bg-dark flex-md-nowrap mt-2 p-3 shadow">
          <div class="navbar-brand col-lg-2 me-0 px-3">週間データ</div>
          <input id="week-data" class="form-control form-control-dark w-50" type="text" placeholder="(例)2020/1/1"
            aria-label="Search">
          <?php if (!empty($_GET['graph'])) : ?>
          <input type="submit" id="send_bar" class="d-flex justify-content-start btn btn-primary" value="送信">
          <?php endif; ?>
          <?php if (!empty($_GET['total_time'])) : ?>
          <input type="submit" id="send_pie" class="d-flex justify-content-start btn btn-primary" value="送信">
          <?php endif; ?>
          <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
              <a class="nav-link" href="../main.php">メイン画面へ戻る</a>
            </li>
          </ul>
        </header>
      </div>
      <div class='tooltip'>日付を例の用に記入すると、調べたい週間データの情報を検索できます</div>

      <div class="side-content row">
        <div class="col-3 side">
          <nav class="sidebar">
            <ul>
              <li><i class="fas fa-house-user"></i><a href="./home.php" id="home">ホーム</a></li>
              <li><i class="far fa-calendar-alt"></i><a href="./home.php?graph=graph" id="graph">週間データ</a></li>
              <li><i class="fas fa-walking"></i><a href="./home.php?total_time=total-time" id="total_time">総時間データ</a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-9 px-md-3 ml-4 pt-md-1" id="main-contents">
          <?php if (isset($_GET['graph'])) { ?>
          <?php include_once('../graph/graph.php'); ?>
          <?php } else if (isset($_GET['total_time'])) { ?>
          <?php include_once('../graph/pie_graph.php'); ?>
          <?php } else { ?>
          <div id="calendar" class="container">
            <h3 class="mb-4">
              <a href="./home.php?month=<?= $prev; ?>" id="prev" class="month">
                <i class="fas fa-angle-double-left"></i>
              </a>
              <?= $calendar; ?>
              <a href="./home.php?month=<?= $next; ?>" id="next" class="month">
                <i class="fas fa-angle-double-right">
                </i>
              </a>
            </h3>
            <table class="table table-bordered">
              <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
              </tr>
              <?php
              foreach ($weeks as $week) {
                echo $week;
              }
              ?>
            </table>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.2.1/dist/chart.umd.min.js"></script>
    <script src="./graph.js"></script>
    <script src="../graph/pie_graph.js"></script>
    <script src="./data_search.js"></script>
  </body>

</html>