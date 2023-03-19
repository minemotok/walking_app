if(document.getElementById('chart') != null) {
  let pieGraph = document.getElementById('chart');
    data = [0, 0, 0, 0, 0, 0, 0];
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
  window.pieChart = new Chart(pieGraph, pieConfig);
  pieChart.canvas.parentNode.style.height = '450px';
  pieChart.canvas.parentNode.style.width = '900px';
  pieChart.canvas.style.margin = '0 200px';
}

function setPieChart(date) {
  pieChart.destroy();
  let pieGraph = document.getElementById('chart');
  data = [
        date.time0,
        date.time1,
        date.time2,
        date.time3,
        date.time4,
        date.time5,
        date.time6
      ];
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
  window.pieChart = new Chart(pieGraph, pieConfig);
  pieChart.canvas.parentNode.style.height = '450px';
  pieChart.canvas.parentNode.style.width = '900px';
  pieChart.canvas.style.margin = '0 200px';
}