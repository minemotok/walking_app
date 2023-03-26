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
          styles: [
            {
                featureType: "water",
                stylers: [
                    {
                        saturation: 43
                    },
                    {
                        lightness: -11
                    },
                    {
                        hue: "#0088ff"
                    }
                ]
            },
            {
                featureType: "road",
                elementType: "geometry.fill",
                stylers: [
                    {
                        hue: "#ff0000"
                    },
                    {
                        saturation: -100
                    },
                    {
                        lightness: 99
                    }
                ]
            },
            {
                featureType: "road",
                elementType: "geometry.stroke",
                stylers: [
                    {
                        color: "#808080"
                    },
                    {
                        lightness: 54
                    }
                ]
            },
            {
                featureType: "landscape.man_made",
                elementType: "geometry.fill",
                stylers: [
                    {
                        color: "#ece2d9"
                    }
                ]
            },
            {
                featureType: "poi.park",
                elementType: "geometry.fill",
                stylers: [
                    {
                        color: "#ccdca1"
                    }
                ]
            },
            {
                featureType: "road",
                elementType: "labels.text.fill",
                stylers: [
                    {
                        color: "#767676"
                    }
                ]
            },
            {
                featureType: "road",
                elementType: "labels.text.stroke",
                stylers: [
                    {
                        color: "#ffffff"
                    }
                ]
            },
            {
                featureType: "poi",
                stylers: [
                    {
                        visibility: "off"
                    }
                ]
            },
            {
                featureType: "landscape.natural",
                elementType: "geometry.fill",
                stylers: [
                    {
                        visibility: "on"
                    },
                    {
                        color: "#b8cb93"
                    }
                ]
            },
            {
                featureType: "poi.park",
                stylers: [
                    {
                        visibility: "on"
                    }
                ]
            },
            {
                featureType: "poi.sports_complex",
                stylers: [
                    {
                        visibility: "on"
                    }
                ]
            },
            {
                featureType: "poi.medical",
                stylers: [
                    {
                        visibility: "on"
                    }
                ]
            },
            {
                featureType: "poi.business",
                stylers: [
                    {
                        visibility: "simplified"
                    }
                ]
            }
        ],
          clickableIcons: false,
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
          icon: {
            url: '/walking_app/my_app/mainMap/23431411.jpg',
            scaledSize: new google.maps.Size(35, 45)
          },
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

// 散歩距離を設定するための変数
let distance = new Array();
let duration = new Array();
let distance_obj = new Object();
let duration_obj = new Object();
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
        
        // 経由地点の情報を格納
        let waypointsValue = {
          'huisTenBosch': new google.maps.LatLng(33.08565665456302, 129.78856205462736),
          'mountInasa': new google.maps.LatLng(32.753145385125215, 129.84965047869096),
          'bakkadai park' : new google.maps.LatLng(32.815850364879104, 130.29616212578327),
          'glover garden': new google.maps.LatLng(32.73435790743401, 129.86918520844137),
          'nagasaki new chinatown': new google.maps.LatLng(32.74190091338694, 129.8755511816009),
          'peace park': new google.maps.LatLng(32.77649390406241, 129.86364262708256),
          'nagasaki bio park': new google.maps.LatLng(32.98829886413879, 129.78328556811636),
          'umi kirara': new google.maps.LatLng(33.16194022699622, 129.67898913361202),
          'mori kirara': new google.maps.LatLng(33.15160304689066, 129.68947144365436),
          'yuinohama marine park': new google.maps.LatLng(32.757119642660726, 129.99414934007896),
          'sazanka kogen picnic park': new google.maps.LatLng(32.96898342887811, 130.1427969269689),
          'omura park': new google.maps.LatLng(32.89928780428673, 129.95902453927758),
          'nagasaki prefectual museum of art': new google.maps.LatLng(32.74212706125895, 129.8702533239288),
          'sasebo gobangai': new google.maps.LatLng(33.16548400193411, 129.7230311988099),
          'nagasaki mizubenomori park': new google.maps.LatLng(32.741409163004136, 129.8691189104368),
          'oura cathedral': new google.maps.LatLng(32.73426697746743, 129.87013884288362),
          'arcus sasebo': new google.maps.LatLng(33.166419281513456, 129.72413277790943),
          'mirai on library': new google.maps.LatLng(32.908878177648155, 129.96166520488555),
          'unzen jigoku': new google.maps.LatLng(32.74069192026073, 130.26202698464104),
          'nagasaki dutch village': new google.maps.LatLng(32.99477199295039, 129.75840503286364)
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
        let directionsService = new google.maps.DirectionsService();
        directionsService.route(request, function (results, status) {
          if (status == 'OK') {
            new google.maps.DirectionsRenderer({
              map: map,
              directions: results,
              suppressMarkers: true
            });
            const waypointImage = new google.maps.Marker({
              position: waypointsValue[waypoint],
              map: map,
              icon: {
                url: '/walking_app/my_app/mainMap/597123.jpg',
                scaledSize: new google.maps.Size(35, 40)
              }
            });
            let placeName = results.geocoded_waypoints[2].place_id;
            let geocoder = new google.maps.Geocoder();
            geocoder.geocode({
              'placeId': placeName,
              'region': 'ja'
            }, function (response, status) {
              if (status == 'OK') {
              const goalImage = new google.maps.Marker({
              position: response[0].geometry.location,
              map: map,
              icon: {
                url: '/walking_app/my_app/mainMap/597160.jpg',
                scaledSize: new google.maps.Size(35, 40)
              }
            });
              }
            });
            let legs = results.routes[0].legs;
            for (let i = 0; i < legs.length; i++) {
              distance[i] = Math.round(legs[i].distance.value / 100) / 10;
              duration[i] = legs[i].duration.value;
            }
            distance_obj = {
              'waypoint': distance[0],
              'destination': distance[1]
            }

            duration_obj = {
              'waypoint': duration[0],
              'destination': duration[1]
            }
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
        let request = {
          origin: currentPos,
          destination: to,
          travelMode: google.maps.DirectionsTravelMode.WALKING,
          optimizeWaypoints: true,
          avoidHighways: true,
          avoidTolls: true,
          unitSystem: google.maps.UnitSystem.METRIC
        }        
        // ルートサービスオブジェクト
        const directionsService = new google.maps.DirectionsService();
        directionsService.route(request, function (results, status) {
          if (status == 'OK') {
            new google.maps.DirectionsRenderer({
              map: map,
              directions: results,
              suppressMarkers: true
            });
            let placeName = results.geocoded_waypoints[1].place_id;
            let geocoder = new google.maps.Geocoder();
            geocoder.geocode({
              'placeId': placeName,
              'region': 'ja'
            }, function (response, status) {
              if (status == 'OK') {
                const goalImage = new google.maps.Marker({
                  position: response[0].geometry.location,
                  map: map,
                  icon: {
                    url: '/walking_app/my_app/mainMap/597160.jpg',
                    scaledSize: new google.maps.Size(35, 40)
                  }
                });
                let legs = results.routes[0].legs;
                console.log(legs);
            for (let i = 0; i < legs.length; i++) {
              distance[i] = Math.round(legs[i].distance.value / 100) / 10;
              duration[i] = legs[i].duration.value;
            }
              distance_obj = {
              'waypoint': 0,
              'destination': distance[0]
            }

                duration_obj = {
              'waypoint': 0,
              'destination': duration[0]
            }
              }
            });
          }
        });
      }
      rootRenderer();
    }
  });
// 散歩ルートの距離を設定するためのダイアログ
const xhr = new XMLHttpRequest();
const form = new FormData();
const date = new Date();
// サーバー側(php)にデータを送信
function post() {
  xhr.open('POST', 'http://localhost:8000/walking_app/my_app/week_data/home/data_api.php', true);
  // データベースに追加する日と曜日を追加
  let year = date.getFullYear(); // 現在の年
  let month = date.getMonth() + 1; // 現在の月
  let day = date.getDate(); // 現在の日
  let walking_date = `${year}` + '-' + `${month}` + '-' + `${day}`;
  let week = date.getDay(); // 現在の曜日の1~6までの数値を取得
  const weekItems = ['日', '月', '火', '水', '木', '金', '土'];
  let walking_week = weekItems[week] + '曜日';
  form.append('distance_waypoint', distance_obj['waypoint']);
  form.append('distance_destination', distance_obj['destination']);
  form.append('duration_waypoint', duration_obj['waypoint']);
  form.append('duration_destination', duration_obj['destination']);
  form.append('walking_date', walking_date);
  form.append('walking_week', walking_week);
  xhr.send(form);
}
function alertConfirm(text) {
  const alert = document.createElement('div');
      alert.setAttribute('class', 'alert alert-warning alert-dismissible fade show');
      alert.setAttribute('role', 'alert');
      alert.textContent = text;
      const button = document.createElement('button');
      button.setAttribute('type', 'button');
      button.setAttribute('class', 'btn-close');
      button.setAttribute('data-bs-dismiss', 'alert');
      button.setAttribute('aria-label', 'Close');
      alert.appendChild(button);
      const body = document.getElementById('main');
      body.prepend(alert);
}
// サーバーからデータが帰ってきたとき
xhr.onload = function (e) {
  if (xhr.readyState === 4) {
    if (xhr.status !== 200) {
      alertConfirm('正常に通信できませんでした');
    } else {
      alertConfirm('正常に通信を行い、登録完了しました');
    }
  }
}

document.getElementById('walkingRoute').addEventListener('click', function() {
      bootbox.confirm("このルートを散歩しますか？", function(result) {
        if (result) {
          post();
        } else {
        }
      })
    });

// 現在地周辺の観光スポットや飲食店を見つける
let count = 0;
document.getElementById('touristText').addEventListener('click', function (e) {
  e.preventDefault();
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

    // 生成した要素までスクロールする
    const subFunction = sightseeing.getBoundingClientRect();
    const subFunctionPos = subFunction.top + window.pageYOffset;
    document.documentElement.scrollTop = subFunctionPos;

  // 検索ボタンを押したら現在地周辺の観光地等を検索
  document.getElementById('searchAround').addEventListener('click', () => {
  async function search() {
    let currentPos = await initMap();
    let currentPosition = currentPos.getCenter();
    currentPos = new google.maps.LatLng(currentPosition);
    
    let request = {
      location: currentPos,
      radius: touristInput.value,
      type: ['tourist_attraction']
    }

    let infowindow;
    function createMarker(markerTourist, labelCount) {
          markerAround = new google.maps.Marker({
          position: markerTourist.geometry.location,
          map: map,
          label: `${labelCount}`,
          animation: google.maps.Animation.DROP
        });
    }

    // 見出し作成
      const wrap = document.createElement('div');
      wrap.setAttribute('class', 'header');
    
      const headline = document.createElement('h2');
      headline.setAttribute('class', 'headWrap');
      headline.textContent = "おすすめの場所";
    
      const span = document.createElement('span');
      span.setAttribute('class', 'in');
      headline.appendChild(span);
      wrap.appendChild(headline);
      const placeSearch = document.getElementById('placeSearch');
      placeSearch.appendChild(wrap);

    // レスポンスで返された値から情報を表示する
    function createInfo(touristInfo, touristAbstractInfo, markerCount, distanceInfo) {
      const createInfo = document.createElement('div');
      createInfo.setAttribute('class', 'searchBox');
      createInfo.setAttribute('id', `${markerCount}`);

      // 観光地情報見出し生成
      const divHead = document.createElement('div');
      divHead.setAttribute('class', 'row');
      const touristHeadlineWrap = document.createElement('div');
      touristHeadlineWrap.setAttribute('class', 'col touristHeadlineWrap');
      const createTouristHeadline = document.createElement('h3');
      createTouristHeadline.setAttribute('class', 'createTouristHeadline');
      createTouristHeadline.textContent = touristInfo.name;
      touristHeadlineWrap.appendChild(createTouristHeadline);
      divHead.appendChild(touristHeadlineWrap);

      const divContent = document.createElement('div');
      divContent.setAttribute('class', 'row content-wrap');
      // 観光地情報写真生成
      const divImage = document.createElement('div');
      divImage.setAttribute('class', 'col-4 place-img');
      const createImgTourist = document.createElement('img');
      createImgTourist.setAttribute('src', touristInfo.photos[0].getUrl({ "maxWidth": 200, "maxHeight": 200 }));
      divImage.appendChild(createImgTourist);

      // 場所の概要情報を作成するためのテーブル作成
      const divTable = document.createElement('div');
      divTable.setAttribute('class', 'col-8');
      const abstractTable = document.createElement('table');
      abstractTable.setAttribute('class', 'table table-striped abstract-table');
      // テーブルの見出しカラム部分
      const trAddress = document.createElement('tr');
      const thAddress = document.createElement('th');
      thAddress.textContent = '住所';
      const trDestination = document.createElement('tr');
      const thDestination = document.createElement('th');
      thDestination.textContent = '距離・時間';
      const trPhoneNumber = document.createElement('tr');
      const thPhoneNumber = document.createElement('th');
      thPhoneNumber.textContent = '電話番号';
      const trWebsite = document.createElement('tr');
      const thWebsite = document.createElement('th');
      thWebsite.textContent = 'Webページ';

      // テーブルのセル部分
      // 住所セル
      const tdAddress = document.createElement('td');
      tdAddress.textContent = touristInfo.vicinity;
      // 距離・時間
      const tdDestination = document.createElement('td');
      tdDestination.innerHTML = `${distanceInfo.routes[0].legs[0].distance.text} <br> 徒歩・ ${distanceInfo.routes[0].legs[0].duration.text}`;
      // 電話番号セル
      const tdPhoneNumber = document.createElement('td');
      tdPhoneNumber.textContent = touristAbstractInfo.formatted_phone_number;
      // Webページセル
      const tdWebsite = document.createElement('td');
      if ('website' in touristAbstractInfo) {
        tdWebsite.innerHTML = `<a class="website" href="${touristAbstractInfo.website}">${touristAbstractInfo.website}</a>`;
      } else {
        tdWebsite.innerHTML = '<span>該当なし</span>';
      }
      // テーブルに住所のカラムを作成
      trAddress.appendChild(thAddress);
      trAddress.appendChild(tdAddress);
      // テーブルに距離・時間のカラムを作成
      trDestination.appendChild(thDestination);
      trDestination.appendChild(tdDestination);
      // テーブルに電話番号のカラムを作成
      trPhoneNumber.appendChild(thPhoneNumber);
      trPhoneNumber.appendChild(tdPhoneNumber);
      // テーブルにWebページの追加
      trWebsite.appendChild(thWebsite);
      trWebsite.appendChild(tdWebsite);
      // テーブル子要素として挿入
      abstractTable.appendChild(trAddress);
      abstractTable.appendChild(trDestination);
      abstractTable.appendChild(trPhoneNumber);
      abstractTable.appendChild(trWebsite);
      divTable.appendChild(abstractTable);

      divContent.appendChild(divImage);
      divContent.appendChild(divTable);

      placeSearch.appendChild(createInfo);
      createInfo.appendChild(divHead);
      createInfo.appendChild(divContent);
    }

    let markerAround;
    let service = new google.maps.places.PlacesService(map);
    service.nearbySearch(request, function (results, status) {
      if (status === 'OK') {
        for (let i = 0; i < results.length; i++) {
          let count = i + 1;
          createMarker(results[i], count);
           markerAround.addListener('click', function () {
            infowindow = new google.maps.InfoWindow({
              content: results[i].name,
              position: results[i].geometry.location
            });
            infowindow.open({
              map: map
            });
           });
          service.getDetails({
            placeId: `${results[i].place_id}`,
            fields: ['website', 'formatted_phone_number']
          }, function(place, status) {
            if(status === 'OK') {
            // 現在地からのおすすめの観光地までの距離を取得
              let directionsService = new google.maps.DirectionsService();
              let touristLatLng = new google.maps.LatLng(results[i].geometry.location.lat(), results[i].geometry.location.lng());
              let route = {
                origin: currentPos,
                destination: touristLatLng,
                travelMode: 'WALKING',
                unitSystem: google.maps.UnitSystem.METRIC
              }
              directionsService.route(route, function(response, status) {
                if(status === 'OK') {
                  createInfo(results[i], place, count, response);
                }
              })
            }
          });
        }
      } 
    });
    }
  search();
  });
  }
});



