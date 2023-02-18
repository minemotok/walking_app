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
      tdWebsite.innerHTML = `<a id="website" href="${touristAbstractInfo.website}">${touristAbstractInfo.website}</a>`;
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
            fields: ['website', 'formatted_phone_number', 'opening_hours']
          }, function(place, status) {
            if(status === 'OK') {
              console.log(place);
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
                  console.log(response);
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



