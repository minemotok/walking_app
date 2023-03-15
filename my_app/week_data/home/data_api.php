<?php
session_start();
include_once('../../loginFunction/connect/connect.php');
$distance = $_POST['distance_waypoint'] + $_POST['distance_destination'];
$duration = $_POST['duration_waypoint'] + $_POST['duration_destination'];
$time = round($duration / 3600, 1);
$walking_date = $_POST['walking_date'];
$walking_week = $_POST['walking_week'];

$stmt = $pdo->prepare("INSERT INTO routes(distance, walking_time, walking_date, walking_week, user_id) 
                      VALUE(:distance, :walking_time, :walking_date, :walking_week, (SELECT id FROM users WHERE username=:username))");
$stmt->bindValue(":distance", $distance, PDO::PARAM_STR);
$stmt->bindValue(":walking_time", $time, PDO::PARAM_STR);
$stmt->bindValue(":walking_date", $walking_date, PDO::PARAM_STR);
$stmt->bindValue(":walking_week", $walking_week, PDO::PARAM_STR);
$stmt->bindValue(":username", $_SESSION['account'], PDO::PARAM_STR);
$stmt->execute();
echo '成功しました';
exit;
