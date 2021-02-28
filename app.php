<?php

    error_reporting(0);
    require "db.php";

    if(!isset($_SESSION['logged_user'])) {
        echo "<script>document.location.href = '/index.php';</script>";
    }

    if($user["access"] >= 1) {
        echo "<script>document.location.href = '/advanced.php';</script>";
    }

?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Личный кабинет</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel='stylesheet prefetch' href='http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css'>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

      <link rel="stylesheet" href="css/style.css">
      <link rel="stylesheet" href="css/main.css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body>
    


    <button type="button" class="btn btn-danger logout" onclick="document.location.href='/logout.php'">Выйти</button>

    <?php
    if($user["access"] == 0) {
        echo '
        <div class="info">
            
            <div class="row">
                <div class="col-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">ФИО и класс</a>
                        <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">ФИО научного руководителя</a>
                        <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Предметная область</a>
                        <a class="list-group-item list-group-item-action" id="list-5-list" data-toggle="list" href="#list-5" role="tab" aria-controls="5">Баллы</a>
                    </div>
                </div>

                <div class="col-8">
                        <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">'.$user["info1"] . ", " . $user["info2"] .'</div>
                        <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">'.$user["info4"].'</div>
                        <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">'.$user["info3"].'</div>
                        <div class="tab-pane fade" id="list-5" role="tabpanel" aria-labelledby="list-5-list">
                            Цель (max 2): '.$user["info6"].';
                            Задачи (max 3): '.$user["info7"].' <br>
                            Актуальность (max 3): '.$user["info17"].';
                            Значимость (max 2): '.$user["info8"].'<br>
                            Раскрытие проблемы (max 10): '.$user["info9"].';
                            Выводы (max 5): '.$user["info10"].';<br>
                            Оформление (max 10): '.$user["info11"].';
                            Раскрытие темы (max 4): '.$user["info12"].'<br>
                            Соблюдение регламента (max 2): '.$user["info13"].';
                            <th scope="col">Наглядность (max 4): '.$user["info14"].'<br>
                            Ответы на вопросы (max 3): '.$user["info15"].';
                            Речь (max 2): '.$user["info16"].'<br>
                            <b>Итог: '.($user["info17"] + $user["info6"] + $user["info7"] + $user["info8"] + $user["info9"] + $user["info10"] + $user["info11"] + $user["info12"] + $user["info13"] + $user["info14"] + $user["info15"] + $user["info16"]).' </b><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }
    ?>


</body>
</html>
