<?php

declare(strict_types=1);

require_once('./vendor/composer/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

session_start();

if (!empty($_POST)) {
} else {
  // GETの時
  // セッション情報がない（ログインしていない）場合ログイン画面にリダイレクトする
  if (empty($_SESSION['account'])) {
    $host = $_SERVER['HTTP_HOST'];
    $dir = dirname($_SERVER['PHP_SELF'], 1);
    header("Location: //$host$dir/loginFunction/login/login.php");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="./mapDisplay/style.css" rel="stylesheet">
    <link href="./jquery/nav.css" rel="stylesheet">
    <script src="https://cdn.geolonia.com/community-geocoder.js"></script>
    <script src="./jquery/jquery-3.6.3.min.js"></script>
    <script src="https://kit.fontawesome.com/aabf80ac97.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <div class="displayTitle">
      <p>アプリの名前（仮）</p>
    </div>

    <div class="container app_contant">
      <div class="row overview">
        <div class="col">
          <p id="inputCheck">経由したい地点のマップをクリックすると詳細が表示されます</p>
        </div>
      </div>

      <div class="row">
        <div class="col-1 navigation">
          <span class="nav_toggle">
            <i></i>
            <i></i>
            <i></i>
          </span>
          <nav class="nav">
            <ul class="nav_menu_ul">
              <li class="nav_menu_li"><a href="#" id="touristText">周辺の観光地を検索</a></li>
              <li class="nav_menu_li"><a href="#">路面電車利用検索</a></li>
              <li class="nav_menu_li"><a href="#">長崎の最新情報</a></li>
              <li class="nav_menu_li"><a href="./loginFunction/logout/logout.php">ログアウト</a></li>
            </ul>
          </nav>
        </div>

        <div class="col-6 waypoint">
          <select class="form-select" id="waypoints" aria-label="Default select example">
            <option selected>経由したい地点を選択してください</option>
            <option value="huisTenBosch">ハウステンボス</option>
            <option value="mountInasa">稲佐山</option>
            <option value="gunkanjima">軍艦島</option>
          </select>
        </div>

        <div class="col destinationInput">
          <input type="text" name="destination" id="to" placeholder="目的地を入力してください">
          <button id="btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
      </div>

      <div class="row">
        <div class="col" id="map"></div>
      </div>

      <div class="row subFunction">
        <div class="col" id="sightseeing">
        </div>

        <div class="col" id="touristButton">
        </div>
      </div>

      <!-- place_idから取得した位置情報を表示するためのdivタグ -->
      <div class="row" id="placeSearchWrap">
        <div class="col" id="placeSearch">

        </div>
      </div>

      <div class="row final">
        <div class="col">
          <a href="#">一日に歩いた距離</a>
        </div>

        <div class="col final">
          <a href="#">レビュー記入欄</a>
        </div>

        <div class="col final">
          <a href="./footer/inquiry/inquiry.php">お問い合わせ</a>
        </div>
      </div>
    </div>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo $_ENV['API_KEY'] ?>&callback=initMap&libraries=places">
    </script>
    <script src="./mainMap/googleMap.js"></script>
    <script src="./jquery/navmenu.js"></script>
  </body>

</html>