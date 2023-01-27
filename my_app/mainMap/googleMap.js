// マップを表示させる,設定するための変数宣言
let map;

let marker;
// google mapを埋め込むdiv要素を取得
const divMap = document.getElementById('map');

// 初期の画面（現在位置）を表示するための関数
function initMap() {
  return new Promise((resolve, reject) => {
    navigator.geolocation.getCurrentPosition(
      (pos) => {
        const crd = pos.coords;
        let lat = crd.latitude;
        let lng = crd.longitude;
        let latlng = new google.maps.LatLng(lat, lng);
        map = new google.maps.Map(divMap, {
          center: latlng,
          zoom: 13,
          restriction: {
            latLngBounds: {
              north: 34.8,
              south: 32.0,
              west: 129.0,
              east: 130.5
            },
            strictBounds: false
	        }
        });
        marker = new google.maps.Marker({
          position: latlng,
          map: map,
          animation: google.maps.Animation.DROP
        });
        resolve(map);
      },
      (error) => {
        const errorArray = [
          "原因不明のエラーが発生しました",
          "位置情報の取得が許可されません",
          "電波状況などで位置情報が取得できません",
          "位置情報の取得に時間を要してしまい、タイムアウトしました"
        ];
        const errorNum = error.code;
        const errorMessage = "エラー番号: " + errorNum + "\n" + errorArray[errorNum];
        alert(errorMessage);
        reject(errorNum);
      });
  });
}

// ルート検索ボタン取得
const rootBtn = document.getElementById('btn');

// ルート検索をクリックしたときの処理
let sumDistance = 0;
  rootBtn.addEventListener('click', () => {
    const waypointsValue = document.getElementById('available');
    if(waypointsValue.checked == true) {
      async function waypointRenderer() {
        let currentPos = await initMap();
        let currentPosition = currentPos.getCenter();
        currentPos = new google.maps.LatLng(currentPosition);
        const to = document.getElementById('to').value;
        
        const directionsService = new google.maps.DirectionsService();
        const directionsDisplay = new google.maps.DirectionsRenderer();

        let request = {
          origin: currentPos,
          destination: to,
          waypoints: [
          ],
          travelMode: google.maps.DirectionsTravelMode.WALKING,
          optimizeWaypoints: true,
          avoidHighways: true,
          avoidTolls: true,
          unitSystem: google.maps.UnitSystem.METRIC
          }
        directionsService.route(request, function (results, status) {
          if (status == 'OK') {
            directionsDisplay.setMap(map);
            directionsDisplay.setDirections(results);
            
            // ルートレスポンスから表示した距離を格納する
            let waypointDirections = directionsDisplay.getDirections();
            let route = waypointDirections.routes[0];

              for (let i = 0; i < route.legs.length; i++) {
                sumDistance += route.legs[i].distance.value;
            }
            walkedDistance.value = '今日は' + sumDistance/1000 + 'km歩きました';
          } else {
            alert('ルートが見つかりませんでした');
          }
        });
      }
      waypointRenderer();
    } else {
      async function currentPosition() {
        let currentPos = await initMap();
        let currentPosition = currentPos.getCenter();
        currentPos = new google.maps.LatLng(currentPosition);
        const to = document.getElementById('to').value;

        const directionsService = new google.maps.DirectionsService();
        const directionsDisplay = new google.maps.DirectionsRenderer();
          let request = {
            origin: currentPos,
            destination: to,
            travelMode: google.maps.DirectionsTravelMode.WALKING,
            unitSystem: google.maps.DirectionsUnitSystem.METRIC,
            optimizeWaypoints: true,
            avoidHighways: true,
            avoidTolls: true
            }
        directionsService.route(request, function (results, status) {
          if (status == 'OK') {
            directionsDisplay.setMap(map);
            directionsDisplay.setDirections(results);

            // ルートレスポンスから表示した距離を格納する
            let directions = directionsDisplay.getDirections();
            let route = directions.routes[0];
            for (let i = 0; i < route.legs.length; i++) {
              sumDistance += route.legs[i].distance.value;
            }
            walkedDistance.value = '今日は' + sumDistance/1000 + 'km歩きました';
          } else {
            alert('ルートが見つかりませんでした');
          }
        });
      }
      currentPosition();
    }
  });