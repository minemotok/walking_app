<?php
session_start();
$host = $_SERVER['HTTP_HOST'];
if (!empty($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], $host) !== false) {
  $refere = $_SERVER['HTTP_REFERER'];
} else {
  $dir = dirname($_SERVER['PHP_SELF'], 2);
  header("Location: //$host$dir/inquiry.php");
}

?>
<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ内容確認画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="confirmation.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4e00f87af3.js" crossorigin="anonymous"></script>
  </head>

  <body>
    <!-- header部分 -->
    <div class="container">
      <div class="row">
        <div class="col">
          <h1>お問い合わせ</h1>
        </div>
      </div>

      <div class="row confirm_text">
        <div class="col-1">
          <i class="fa-solid fa-circle-exclamation"></i>
        </div>
        <div class="col-11 element_item">
          <p>まだ、お問い合わせ入力は完了していません</p>
          <p>入力内容をご確認ください</p>
          <p>この内容でお問い合わせする場合は、送信ボタンを押してください</p>
        </div>
      </div>

      <div class="row">
        <div class="col arrow">
          <span>入力</span>
          <span id="confirmation">確認</span>
          <span>完了</span>
        </div>
      </div>

      <form action="../complete/complete.php" method="POST">
        <div class="row frame">
          <div class="col framework">
            <table>
              <tr class="separate_blue">
                <td class="title"><span>法人/個人 <span class="gray">【任意】</span></span></td>
                <td class="contents"><span><?php if (isset($_SESSION['job_category']) === false) {
                                            echo "";
                                          } else {
                                            echo $_SESSION['job_category'];
                                          } ?></span></td>
              </tr>
              <tr class="separate_sky">
                <td class="title"><span>会社名 <span class="skin">【法人の場合のみ】</span></span></td>
                <td class="contents"><span>
                    <?php if (isset($_SESSION['company_name']) === false) {
                    echo "";
                  } else {
                    echo $_SESSION['company_name'];
                  } ?> </span></td>
              </tr>
              <tr class="separate_blue">
                <td class="title"><span>氏名 <span class="red">【必須】</span></span></td>
                <td class="contents"><span><?= $_SESSION['username']; ?></span></td>
              </tr>
              <tr class="separate_sky">
                <td class="title"><span>性別 <span class="gray">【任意】</span></span></td>
                <td class="contents"><span><?php if (isset($_SESSION['gender']) === false) {
                                            echo "";
                                          } else {
                                            echo $_SESSION['gender'];
                                          } ?></span></td>
              </tr>
              <tr class="separate_blue">
                <td class="title"><span>生年月日 <span class="red">【必須】</span></span></td>
                <td class="contents"><span><?= $_SESSION['birth_day']; ?></span></td>
              </tr>
              <tr class="separate_sky">
                <td class="title"><span>メールアドレス <span class="red">【必須】</span></span></td>
                <td class="contents"><span><?= $_SESSION['mailaddress']; ?></span></td>
              </tr>
              <tr class="separate_blue">
                <td class="title"><span>郵便番号 <span class="red">【必須】</span></span></td>
                <td class="contents"><span><?= $_SESSION['post']; ?></span></td>
              </tr>
              <tr class="separate_sky">
                <td class="title"><span>都道府県 <span class="red">【必須】</span></span></td>
                <td class="contents"><span><?= $_SESSION['prefecture']; ?></span></td>
              </tr>
              <tr class="separate_blue">
                <td class="title"><span>住所 <span class="red">【必須】</span></span></td>
                <td class="contents"><span><?= $_SESSION['address']; ?></span></td>
              </tr>
              <tr class="separate_sky">
                <td id="content_area"><span>お問い合わせ内容 <span class="red">【必須】</span></span></td>
                <td class="contents"><span><?= $_SESSION['contents']; ?></span></td>
              </tr>
            </table>
          </div>

          <div class="row submit_button">
            <div class="col-3">
              <button type="button" id="back_button">
                <?php
              echo '<a id="back" href="' . $refere . '">戻る</a>';
              ?>
              </button>
            </div>
            <div class="col">
              <input type="submit" value="送信" name="localstorage_submit" id="submitButton">
            </div>
          </div>
        </div>

      </form>
  </body>

  <!-- ローカルストレージに格納する -->
  <script>
  const submit = document.getElementById('submitButton');
  submit.addEventListener('click', function() {
    let inquiry_data = {
      job_category: '<?php if (isset($_SESSION['job_category']) === false) {
                        echo "";
                      } else {
                        echo $_SESSION['job_category'];
                      } ?>',
      company_name: '<?php if (isset($_SESSION['company_name']) === false) {
                        echo "";
                      } else {
                        echo $_SESSION['company_name'];
                      } ?>',
      username: '<?= $_SESSION['username']; ?>',
      gender: '<?php if (isset($_SESSION['gender']) === false) {
                  echo "";
                } else {
                  echo $_SESSION['gender'];
                } ?>',
      birth_day: '<?= $_SESSION['birth_day']; ?>',
      mailaddress: '<?= $_SESSION['mailaddress']; ?>',
      post: '<?= $_SESSION['post']; ?>',
      prefecture: '<?= $_SESSION['prefecture']; ?>',
      address: '<?= $_SESSION['address']; ?>',
      contents: '<?= $_SESSION['contents']; ?>'
    }

    let json = JSON.stringify(inquiry_data);
    localStorage.setItem('input_data', json);
  });
  </script>

</html>