<?php

$user = "minemotokazuma";
$pass = "Km57292277";

try {
  $pdo = new PDO("mysql:dbname=walking-app;host=localhost;", $user, $pass);
  $pdo->query('SET NAMES utf8');
  echo "MySQLと接続完了しました";
} catch (PDOException $error) {
  $error->getMessage();
}
