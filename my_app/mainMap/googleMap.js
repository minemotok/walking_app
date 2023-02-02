// マップを表示させる,設定するための変数宣言
let map;

let marker;

let service;
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
rootBtn.addEventListener('click', () => {
  // 入力された値（経由地点）
    const waypoint = document.getElementById('waypoints').value;  
    if (waypoint !== "経由したい地点を選択してください") {
      async function waypointRenderer() {
        let currentPos = await initMap();
        let currentPosition = currentPos.getCenter();
        currentPos = new google.maps.LatLng(currentPosition);
        const to = document.getElementById('to').value;
        
        const directionsService = new google.maps.DirectionsService();
        const directionsDisplay = new google.maps.DirectionsRenderer();
        
        // 経由地点の情報を格納
        let waypointsValue = {
          'huisTenBosch': new google.maps.LatLng(33.08565665456302, 129.78856205462736),
          'mountInasa': new google.maps.LatLng(32.753145385125215, 129.84965047869096),
          'gunkanjima' : new google.maps.LatLng(32.62784026536563, 129.7384964455473)
        }
        
        let request = {
          origin: currentPos,
          destination: to,
          waypoints: [
            {location: waypointsValue[waypoint]}
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
          }
        });
      }
      waypointRenderer();
    } else {
      async function rootRenderer() {
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
          optimizeWaypoints: true,
          avoidHighways: true,
          avoidTolls: true,
          unitSystem: google.maps.UnitSystem.METRIC
          }
        directionsService.route(request, function (results, status) {
          if (status == 'OK') {
            directionsDisplay.setMap(map);
            directionsDisplay.setDirections(results); 
          }
        });
      }
      rootRenderer();
    }
  });

  // 現在地周辺の観光スポットや飲食店を見つける
  let count = 0;
function touristLinkClick() {
  count++;
  if(count === 1) {
    const touristInput = document.createElement('select');
    touristInput.classList.add('form-select');
    touristInput.setAttribute('aria-label', 'Default select example');
    touristInput.setAttribute('id', 'touristAround');
    const sightseeing = document.getElementById('sightseeing');
    sightseeing.insertBefore(touristInput, sightseeing.firstChild);
    // セレクトボックスのオプション要素を追加
    const option = document.createElement('option');
    option.setAttribute('value', '周辺距離を選択してください');
    option.textContent = '周辺距離を選択してください';
    touristInput.appendChild(option);

    const option1 = document.createElement('option');
    option1.setAttribute('value', '250');
    option1.textContent = '250m';
    touristInput.appendChild(option1);

    const option2 = document.createElement('option');
    option2.setAttribute('value', '500');
    option2.textContent = '500m';
    touristInput.appendChild(option2);

    const option3 = document.createElement('option');
    option3.setAttribute('value', '800');
    option3.textContent = '800m';
    touristInput.appendChild(option3);

    const option4 = document.createElement('option');
    option4.setAttribute('value', '1000');
    option4.textContent = '1.0km';
    touristInput.appendChild(option4);

    const option5 = document.createElement('option');
    option5.setAttribute('value', '1500');
    option5.textContent = '1.5km';
    touristInput.appendChild(option5);

    const option6 = document.createElement('option');
    option6.setAttribute('value', '2000');
    option6.textContent = '2.0km';
    touristInput.appendChild(option6);

    // ボタン生成
    const selectButton = document.createElement('button');
    selectButton.setAttribute('type', 'button');
    selectButton.setAttribute('class', 'btn btn-primary');
    selectButton.setAttribute('id', 'searchAround');
    const touristButton = document.getElementById('touristButton');
    selectButton.textContent = '検索';
    touristButton.appendChild(selectButton);

      // 検索ボタンを押したら現在地周辺の観光地等を検索
  document.getElementById('searchAround').addEventListener('click', () => {
  async function search() {
    let currentPos = await initMap();
    let currentPosition = currentPos.getCenter();
    currentPos = new google.maps.LatLng(currentPosition);
    
    let request = {
      location: currentPos,
      radius: touristInput.value,
      rankBy: google.maps.places.RankBy.PROMINENCE,
      type: ['tourist_attraction']
    }

    service = new google.maps.places.PlacesService(map);
    service.nearbySearch(request, function (results, status) {
      if (status == 'OK') {
        for (let i = 0; i < results.length; i++) {
          createMarker(results[i].geometry.location);
          console.log(results[i]);
        }
      } 
    });
    function createMarker(markerTourist) {
      let marker = new google.maps.Marker({
        position: markerTourist,
        map: map,
        animation: google.maps.Animation.DROP
      });
    }
    }
  search();
  });
  }
}

