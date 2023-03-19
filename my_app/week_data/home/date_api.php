<?php
session_start();

// ajaxで渡ってきたデータをもとにデータベースから取得する
$date = json_decode(file_get_contents("php://input"), true);
// 一週間ごとのデータを取得する関数
function sql_date_distance($date_data)
{
  include("../../loginFunction/connect/connect.php");
  $stmt_dis = $pdo->prepare("SELECT distance FROM routes
                      INNER JOIN users ON user_id = users.id
                      WHERE username=:username AND walking_date=:walking_date");
  $stmt_dis->bindValue(":username", $_SESSION['account'], PDO::PARAM_STR);
  $stmt_dis->bindValue(":walking_date", $date_data, PDO::PARAM_STR);
  $stmt_dis->execute();
  $data = $stmt_dis->fetchAll(PDO::FETCH_COLUMN);

  $distance = 0;
  foreach ($data as $date) {
    $distance += $date;
  }
  return $distance;
}

function sql_date_time($walking_date)
{
  include("../../loginFunction/connect/connect.php");
  $stmt_time = $pdo->prepare("SELECT walking_time FROM routes
                              INNER JOIN users ON user_id=users.id
                              WHERE username=:username AND walking_date=:walking_date");
  $stmt_time->bindValue(":username", $_SESSION['account'], PDO::PARAM_STR);
  $stmt_time->bindValue(":walking_date", $walking_date, PDO::PARAM_STR);
  $stmt_time->execute();
  $time_data = $stmt_time->fetchAll(PDO::FETCH_COLUMN);

  $time = 0;
  foreach ($time_data as $data) {
    $time += $data;
  }
  return $time;
}

$array = array();
for ($i = 0; $i < 7; $i++) {
  $array["distance{$i}"] = sql_date_distance($date["search{$i}"]);
  $array["time{$i}"] = sql_date_time($date["search{$i}"]);
  $array["date{$i}"] = $date["search{$i}"];
}
header("Content-type: application/json; charset=UTF-8");
echo json_encode($array);
exit;
