if(document.getElementById('chart') != null) {
  let pieGraph = document.getElementById('chart');
  let data = Array();
  if(typeof(times_data) != 'undefined') {
    let time_data = JSON.parse(times_data);
    data = [
      time_data.sun_time,
      time_data.mon_time,
      time_data.tue_time,
      time_data.wed_time,
      time_data.thu_time,
      time_data.fri_time,
      time_data.sat_time
    ]
  }
    let pieConfig = {
      type: 'pie',
      data: {
          labels: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
          datasets: [{
            backgroundColor: [
              '#ff0000',
              '#ff69b4',
              '#ff8b00',
              '#00bfff',
              '#008000',
              '#ffe135',
              '#88654e'
            ],
            data: data
          }]
      },
      options: {
        plugins: {
          title: {
            display: true,
            text: "一週間で散歩した時間データ(h)"
          }
        }
      }
    }
  let pieChart = new Chart(pieGraph, pieConfig);
  pieChart.canvas.parentNode.style.height = '400px';
  pieChart.canvas.parentNode.style.width = '850px';
  pieChart.canvas.style.margin = '0 160px';
}