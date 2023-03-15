if (document.getElementById('myChart') != null) {
let chart = document.getElementById('myChart');
  let label = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  let data = Array();
  if (typeof (routes_data) != 'undefined') {
    let route_data = JSON.parse(routes_data);
      data = [route_data.sun_distance,
                route_data.mon_distance,
                route_data.tue_distance,
                route_data.wed_distance,
                route_data.thu_distance,
                route_data.fri_distance,
                route_data.sat_distance
              ];
  }
  // 棒グラフの設定
  let barConfig = {
    type: 'bar',
    data: {
      labels: label,
      datasets: [{
        data: data,
        label: '1日に歩いた距離',
        backgroundColor: [
          '#ff0000',
          '#ff69b4',
          '#ff8b00',
          '#00bfff',
          '#008000',
          '#ffe135',
          '#88654e'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          min: 0,
          max: 16,
          title: {
            display: true,
            text: '1日に散歩した距離(Km)',
            scale: {
              pointLabels: {
                fontSize: 20
              }
            },
            padding: {
              bottom: 30
            }
          },
          scale: {
            pointLabels: {
              fontSize: 30
            }
          },
          ticks: {
            callback: function (value, index, ticks) {
              return value + 'Km';
            },
          },
        },
      }
    }
  }
  let barChart = new Chart(chart, barConfig);
}