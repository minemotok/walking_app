$(function () {
  let error = Array();
  $('#send_bar').on('click', function () {
    // 入力チェック
    let weekData = $('#week-data').val();
    weekData = weekData.replace(/[０-９]/g,
      function (str) {
        return String.fromCharCode(str.charCodeAt(0) - 0xFEE0);
      });
    let pattern = "(19[0-9]{2}|20[0-9]{2})/([1-9]|1[0-2])/([1-9]|[12][0-9]|3[01])";
    let regexp = new RegExp(pattern);
    if (weekData == '') {
      error.push("日付が入力されていません");
    } else if (weekData.length > 10) {
      error.push("10文字以内にしてください");
    } else if (regexp.test(weekData.toString(10)) === false) {
      error.push("正式な値で入力してください");
    }

  if (error.length !== 0) {
    let message;
    $.each(error, function (index, element) {
        message = element;
    })
    $.confirm({
      "title": "入力エラー",
      "message": message,
      "buttons": {
        "OK": {
          "action": function () {
            return false;
          }
        },
        "キャンセル": {
          "action": function () {
            return false;
          }
        }
      }
    });
    };
  // エラーメッセージがなかったらajax通信でphpにPOSTする
    if (error.length === 0) {
      let date = new Date(weekData);
      let week = ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"];
      let year = date.getFullYear();
      let month = date.getMonth() + 1;
      const startDate = date.getDate() - date.getDay();
      let date_obj = {};
        for (let i = 0; i < week.length; i++) {
          date_obj[`search${i}`] = year + '-' + month + '-' + (startDate + i);
      }
      const date_json = JSON.stringify(date_obj);
    let url = "http://localhost:8000/walking_app/my_app/week_data/home/date_api.php";
    $.ajax({
      type: "POST",
      url: url,
      data: date_json,
      contentType: "application/json; charset=UTF-8",
      dataType: "json"
    })
      .done(function (data) {
        setBarChart(data);
        let start = data.date0.replace(/-/g, "/");
        let end = data.date6.replace(/-/g, "/");
        $('#bar-title').text(start + "～" + end);
      })
      .fail(function () {
        communicationError("通信に失敗しました");
      })
      .always(function () {
        communicationError("通信が完了しました");
    })
  }
});
});
function communicationError(message) {
    $.confirm({
      "title": "通信状況",
      "message": message,
      "buttons": {
        "OK": {
          "action": function () {
            return false;
          }
        },
        "キャンセル": {
          "action": function () {
            return false;
          }
        }
      }
    });
}

$('#send_pie').on('click', function () {
  let error = Array();
    // 入力チェック
    let weekData = $('#week-data').val();
    weekData = weekData.replace(/[０-９]/g,
      function (str) {
        return String.fromCharCode(str.charCodeAt(0) - 0xFEE0);
      });
    let pattern = "(19[0-9]{2}|20[0-9]{2})/([1-9]|1[0-2])/([1-9]|[12][0-9]|3[01])";
    let regexp = new RegExp(pattern);
    if (weekData == '') {
      error.push("日付が入力されていません");
    } else if (weekData.length > 10) {
      error.push("10文字以内にしてください");
    } else if (regexp.test(weekData.toString(10)) === false) {
      error.push("正式な値で入力してください");
    }

  if (error.length !== 0) {
    let message;
    $.each(error, function (index, element) {
        message = element;
    })
    $.confirm({
      "title": "入力エラー",
      "message": message,
      "buttons": {
        "OK": {
          "action": function () {
            return false;
          }
        },
        "キャンセル": {
          "action": function () {
            return false;
          }
        }
      }
    });
    };
  // エラーメッセージがなかったらajax通信でphpにPOSTする
    if (error.length === 0) {
      let date = new Date(weekData);
      let week = ["日曜日", "月曜日", "火曜日", "水曜日", "木曜日", "金曜日", "土曜日"];
      let year = date.getFullYear();
      let month = date.getMonth() + 1;
      const startDate = date.getDate() - date.getDay();
      let date_obj = {};
        for (let i = 0; i < week.length; i++) {
          date_obj[`search${i}`] = year + '-' + month + '-' + (startDate + i);
      }
      const date_json = JSON.stringify(date_obj);
    let url = "http://localhost:8000/walking_app/my_app/week_data/home/date_api.php";
    $.ajax({
      type: "POST",
      url: url,
      data: date_json,
      contentType: "application/json; charset=UTF-8",
      dataType: "json"
    })
      .done(function (data) {
        let date = { };
        for (let i = 0; i < 7; i++) {
          date[`time${i}`] = Math.round(data[`time${i}`] * 10) / 10;
        }
        setPieChart(date);
        let start = date.date0.replace(/-/g, "/");
        let end = date.date6.replace(/-/g, "/");
        $('#pie_title').text(start + "～" + end);
      })
      .fail(function () {
        communicationError("通信に失敗しました");
      })
      .always(function () {
        communicationError("通信が完了しました");
    })
  }
});

function communicationError(message) {
    $.confirm({
      "title": "通信状況",
      "message": message,
      "buttons": {
        "OK": {
          "action": function () {
            return false;
          }
        },
        "キャンセル": {
          "action": function () {
            return false;
          }
        }
      }
    });
  }