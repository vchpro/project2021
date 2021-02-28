<?php

    $default_open = 1; // По умолчанию открываем 1 элемент списка

    error_reporting(0);
    require "db.php";

    if(!isset($_SESSION['logged_user'])) {
        echo "<script>document.location.href = '/index.php';</script>";
    }

    if(!$user["access"]) {
        echo "<script>document.location.href = '/app.php';</script>";
        die;
    }

    function generate_string($strength = 16) {
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
    
        return $random_string;
    }

    function update_keys() {
        $students = R::getAll('SELECT * FROM `users` WHERE `access` = 0');

            $arr = new ArrayObject(array());
            foreach($students as $student) {
                $arr->append(array($student["info1"] . ", " . $student["info2"], $student["auth"]));
            }

            $randString = generate_string(24);

            if (file_exists('table/' . $randString . ".csv")) {
                unlink('table/' . $randString . ".csv");
            }

            $fp = fopen('table/'.$randString.'.csv', 'w');

            fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF8 setup

            foreach ($arr as $fields) {
                fputcsv($fp, $fields, ';', '"');
            }

            fclose($fp);
            $newCSV = "table/" . $randString . ".csv";

            // R::exec("DELETE from settings where 1");
            $settings = R::findOne('settings', 'id = ?', array(1));
            unlink($settings["lastkeys"]);
            $settings["lastkeys"] = $newCSV;
            R::store($settings);
    }

    // $randKey = generate_string(16);

    // // R::exec("DELETE from users where name = '".$line[0] . ", " . $line[1]."'");

    // while(R::count('users', "auth = ?", array($randKey)) > 0) {
    //     $randKey = generate_string(16);
    // }

?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Панель управления</title>
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
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
    
    <?php

    if(isset($_POST["change-token"])) {
        if($user["auth"] != $_POST["new-token"]) {
            $default_open = 2;
            if(R::count('users', "auth = ?", array($_POST["new-token"])) == 0) {
                $log = R::dispense("logs");
                $log["from_id"] = $user["id"];
                $log["to_id"] = -1;
                $log["new"] = "Смена своего ключа на: ".$_POST["new-token"];
                R::store($log);

                $user["auth"] = $_POST["new-token"];
                R::store($user);
                echo '
                <div class="alert alert-success" role="alert">
                    Успешно!
                </div>
                ';
            }
            else {
                echo '
                <div class="alert alert-danger" role="alert">
                Этот ключ уже используется!
                </div>
                ';
            }
        }
    }

    if(isset($_POST["create-new"])) {

        if($user["access"] >= 1) {
            $log = R::dispense("logs");
            $log["from_id"] = $user["id"];
            $log["to_id"] = -1;
            $log["new"] = "Создание нового ученика";
            R::store($log);

            $randKey = generate_string(16);

            while(R::count('users', "auth = ?", array($randKey)) > 0) {
                $randKey = generate_string(16);
            }


            $new_user = R::dispense("users");
            $new_user["info1"] = "Новый ученик";
            $new_user["info2"] = "";
            $new_user["info3"] = "";
            $new_user["info4"] = "";
            $new_user["auth"] = $randKey;
            $new_user["info6"] = "";
            $new_user["info7"] = "";
            $new_user["info8"] = "";
            $new_user["info9"] = "";
            $new_user["info10"] = "";
            $new_user["info11"] = "";
            $new_user["info12"] = "";
            $new_user["info13"] = "";
            $new_user["info14"] = "";
            $new_user["info15"] = "";
            $new_user["info16"] = "";
            $new_user["info17"] = "";
            R::store($new_user);

            update_keys();

            echo '
            <div class="alert alert-success" role="alert">
                Успешно!
            </div>
            ';
        }

    }


    if(isset($_POST["create-new2"])) {
        $default_open = 3;
        if($user["access"] >= 2) {
            $log = R::dispense("logs");
            $log["from_id"] = $user["id"];
            $log["to_id"] = -1;
            $log["new"] = "Создание нового преподавателя";
            R::store($log);

            $randKey = generate_string(16);

            while(R::count('users', "auth = ?", array($randKey)) > 0) {
                $randKey = generate_string(16);
            }


            $new_user = R::dispense("users");
            $new_user["info1"] = "Новый преподаватель";
            $new_user["access"] = 1;
            $new_user["info2"] = "";
            $new_user["info3"] = "";
            $new_user["info4"] = "";
            $new_user["auth"] = $randKey;
            $new_user["info6"] = "";
            $new_user["info7"] = "";
            $new_user["info8"] = "";
            $new_user["info9"] = "";
            $new_user["info10"] = "";
            $new_user["info11"] = "";
            $new_user["info12"] = "";
            $new_user["info13"] = "";
            $new_user["info14"] = "";
            $new_user["info15"] = "";
            $new_user["info16"] = "";
            $new_user["info17"] = "";
            R::store($new_user);


            echo '
            <div class="alert alert-success" role="alert">
                Успешно!
            </div>
            ';
        }

    }


    if(isset($_POST["edit-student"]) || isset($_POST["delete-student"])) {
        if($user["access"] >= 1) {

            $edit_user = R::findOne('users', 'id = ?', array($_POST["edit-to-id"]));

            if($edit_user && ($edit_user["access"] == 0 || ($edit_user["access"] == 1 && $user["access"] >= 2))) {

                if($edit_user["access"] == 1 && $user["access"] >= 2) {
                    $default_open = 3;
                }

                if(isset($_POST["delete-student"])) {
                    $log = R::dispense("logs");
                    $log["from_id"] = $user["id"];
                    $log["to_id"] = $edit_user["id"];
                    $log["new"] = "Удаление ученика: ";

                    if($edit_user["access"] == 1 && $user["access"] >= 2) {
                        $default_open = 3;
                        $log["new"] = "Удаление преподавателя: ";
                    }

                    foreach ($edit_user as $key => $value) {
                        if($key == "edit-to-id" || $key == "edit-student" ) {
                            continue;
                        }

                        $log["new"] .= $key . "=> " . $value . "; ";
                    }


                    R::store($log);

                    // $find = R::findOne('users', 'id = ?',[$_POST["edit-to-id"]]);
                    // $delete = R::load('users', $edit_user->id);
                    R::trash($edit_user);
                }
                
                
                else {
                    $log = R::dispense("logs");
                    $log["from_id"] = $user["id"];
                    $log["to_id"] = $edit_user["id"];
                    $log["new"] = "Редактирование ученика: ";

                    if($edit_user["access"] == 1 && $user["access"] >= 2) {
                        $default_open = 3;
                        $log["new"] = "Редактирование преподавателя: ";
                    }

                    foreach ($_POST as $key => $value) {
                        if($key == "edit-to-id" || $key == "edit-student" ) {
                            continue;
                        }

                        $log["new"] .= $key . "=> " . $value . "; ";
                    }


                    R::store($log);

                    foreach ($_POST as $key => $value) {
                        if($key == "auth") {
                            if($edit_user["auth"] != $value) {
                                if(R::count('users', "auth = ?", array($value)) == 0) {
                                    $edit_user["auth"] = $value;
                                }
                                else {
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                    Этот ключ уже используется!
                                    </div>
                                ';
                                }
                            }
                            
                        }

                        if($key == "edit-to-id" || $key == "edit-student" || $key == "access" || $key == "auth" || $key == "id") {
                            continue;
                        }
                        $edit_user[$key] = $value;
                    }

                    R::store($edit_user);
                }

                update_keys();

                echo '
                <div class="alert alert-success" role="alert">
                    Успешно!
                </div>
                ';
            }
            else {
            //     echo '
            //     <div class="alert alert-danger" role="alert">
            //     Действие невозможно.
            //     </div>
            // ';
            }
        }
    }
    ?>

    <button type="button" class="btn btn-danger logout" onclick="document.location.href='/logout.php'">Выйти</button>
    
    <div class="accordion" id="accordionExample" class="accordion" style="width:100%;">
        <div class="card">
            <div class="card-header" id="headingOne">
            <h5 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Управление учениками
                </button>
            </h5>
            </div>

            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">

                <nav class="navbar navbar-light bg-light find-student">
                    <form class="form-inline" method="post" action="advanced.php">
                        <input class="form-control mr-sm-2" type="search" placeholder="ФИО" aria-label="ФИО" name="find-name" value="<?=$_POST["find-name"]?>">
                        <input class="form-control mr-sm-2" type="search" placeholder="Класс" aria-label="Класс" name="find-class" value="<?=$_POST["find-class"]?>">
                        <input class="form-control mr-sm-2" type="search" placeholder="Предметная область" aria-label="Предметная область" name="find-lesson" value="<?=$_POST["find-lesson"]?>">
                        <input class="form-control mr-sm-2" type="search" placeholder="Научный руководитель" aria-label="Научный руководитель" name="find-teacher" value="<?=$_POST["find-teacher"]?>">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="find-student">Найти</button>
                    </form>
                </nav>

                <form method="post" action="advanced.php" class="find-student">
                    <button class="btn btn-danger" type="submit" name="reset-find-student" style="display:block;width:157px;margin: 0 auto;margin-top:15px;">Сбросить фильтр</button>
                </form>

            <?php
        if($user["access"] >= 1) {
            $keys = R::getAll('SELECT * FROM `settings`');
            foreach($keys as $key) {
                echo '
                <button type="submit" class="btn btn-info" name="do_reg" style="margin: 0 auto;margin-top:30px; display:block;" onclick="document.location.href=\''.$key["lastkeys"].'\'">Скачать таблицу с ключами</button>
                <form method="post" action="advanced.php">
                    <button type="submit" class="btn btn-primary" style="margin: 0 auto;margin-top:30px; display:block;" name="create-new">Создать ученика</button>
                </form>
                ';
            }
            ?>

            <?php

            $students;

            if(isset($_POST["reset-find-student"]) || !isset($_POST["find-student"])) {
                $students = R::getAll('SELECT * FROM `users` WHERE `access` = 0  ORDER by id DESC');
            }

            else {
                $students = R::getAll('SELECT * FROM `users` WHERE `access` = 0  AND `info1` LIKE "%'.$_POST["find-name"].'%" AND `info2` LIKE "%'.$_POST["find-class"].'%" AND `info3` LIKE "%'.$_POST["find-lesson"].'%" AND `info4` LIKE "%'.$_POST["find-teacher"].'%" ORDER by id DESC');
            }

            if(count($students) > 0) {

                foreach($students as $student) {
                    echo '<form method="post" action="advanced.php" class="student-form-edit edit-'.$student["id"].'" id="edit-'.$student["id"].'""></form>';
                }


                echo '<table class="table table-striped table-white">
                <thead>
                    <tr>
                    <th scope="col">ФИО</th> <!-- 1 -->
                    <th scope="col">Класс</th> <!-- 2 -->
                    <th scope="col">Предметная область</th> <!-- 3 -->
                    <th scope="col">Научный руководитель</th> <!-- 4 -->
                    <th scope="col">Ключ</th> <!-- 5 -->
                    <th scope="col">Итог</th> <!-- 6 -->
                    <th scope="col">Актуальность (max 3)</th> <!-- NEW -->
                    <th scope="col">Цель (max 2)</th> <!-- 7 -->
                    <th scope="col">Задачи (max 3)</th> <!-- 8 -->
                    <th scope="col">Значимость (max 2)</th> <!-- 9 -->
                    <th scope="col">Раскрытие проблемы (max 10)</th> <!-- 10 -->
                    <th scope="col">Выводы (max 5)</th> <!-- 11 -->
                    <th scope="col">Оформление (max 10)</th> <!-- 12 -->
                    <th scope="col">Раскрытие темы (max 4)</th> <!-- 13 -->
                    <th scope="col">Соблюдение регламента (max 2)</th> <!-- 14 -->
                    <th scope="col">Наглядность (max 4)</th> <!-- 15 -->
                    <th scope="col">Ответы на вопросы (max 3)</th> <!-- 16 -->
                    <th scope="col">Речь (max 2)</th> <!-- 17 -->
                    <th scope="col"></th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>';

                foreach($students as $student) {
                    echo '
                    <tr>
                            <td><input disabled name="info1" type="text" value="'.$student["info1"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info2" type="text" value="'.$student["info2"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info3" type="text" value="'.$student["info3"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info4" type="text" value="'.$student["info4"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="auth" type="text" value="'.$student["auth"].'" form="edit-'.$student["id"].'" required></td>
                            <td><input disabled type="text" class="always-disabled" value="'.($student["info6"] + $student["info7"] + $student["info8"] + $student["info9"] + $student["info10"] + $student["info11"] + $student["info12"] + $student["info13"] + $student["info14"] + $student["info15"] + $student["info16"] + $student["info17"]).'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info17" type="number" min="0" max="3" value="'.$student["info17"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info6" type="number" min="0" max="2" value="'.$student["info6"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info7" type="number" min="0" max="3" value="'.$student["info7"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info8" type="number" min="0" max="2" value="'.$student["info8"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info9" type="number" min="0" max="10" value="'.$student["info9"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info10" type="number" min="0" max="5" value="'.$student["info10"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info11" type="number" min="0" max="10" value="'.$student["info11"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info12" type="number" min="0" max="4" value="'.$student["info12"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info13" type="number" min="0" max="2" value="'.$student["info13"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info14" type="number" min="0" max="4" value="'.$student["info14"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info15" type="number" min="0" max="3" value="'.$student["info15"].'" form="edit-'.$student["id"].'"></td>
                            <td><input disabled name="info16" type="number" min="0" max="2" value="'.$student["info16"].'" form="edit-'.$student["id"].'"></td>
                            <td>
                                <input type="hidden" name="edit-to-id" value="'.$student["id"].'" form="edit-'.$student["id"].'">
                                <button name="edit-student" type="button" class="btn btn-primary edit-student edit-'.$student["id"].'" name="edit-student edit-'.$student["id"].'" form="edit-'.$student["id"].'">Редактировать</button>
                            </td>
                            <td>
                                <button name="delete-student" type="button" class="btn btn-danger delete-student" form="edit-'.$student["id"].'">Удалить</button>
                            </td>
                    </tr>';
                }


            }
            echo '    </tbody>
            </table>';
        }
?>
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Управление аккаунтом
                </button>
            </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
            <div class="card-body">
                <nav class="navbar navbar-light bg-light find-student">
                    <form class="form-inline" method="post" action="advanced.php">
                        <span style="margin-right:10px;font-size:16px;">Ваш ключ: </span> <input class="form-control mr-sm-2" type="search" placeholder="" aria-label="Ваш ключ" name="new-token" value="<?=$user["auth"]?>" required>
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="change-token">Изменить</button>
                    </form>
                </nav>
            </div>
            </div>
        </div>

        <?php
        if($user["access"] >= 2) {
            $students = R::getAll('SELECT * FROM `users` WHERE `access` = 1  ORDER by id DESC');

            echo '

            <div class="card">
                <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Управления преподавателями
                    </button>
                </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="card-body">
                <form method="post" action="advanced.php">
                    <button type="submit" class="btn btn-primary" style="margin: 0 auto;margin-top:30px; display:block;" name="create-new2">Создать преподавателя</button>
                 </form>
            
                    ';

                    if(count($students) > 0) {
                     foreach($students as $student) {
                        echo '<form method="post" action="advanced.php" class="student-form-edit edit-'.$student["id"].'" id="edit-'.$student["id"].'""></form>';
                    }


                    echo '<table class="table table-striped table-white table-little" style="margin-top:30px">
            <thead>
                <tr>
                <th scope="col">ФИО</th> <!-- 1 -->
                <th scope="col">Ключ</th> <!-- 5 -->
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>';

            foreach($students as $student) {
                echo '
                <tr>
                        <td><input disabled name="info1" type="text" value="'.$student["info1"].'" form="edit-'.$student["id"].'"></td>
                        <td><input disabled name="auth" type="text" value="'.$student["auth"].'" form="edit-'.$student["id"].'" required></td>
                        
                        <td>
                            <input type="hidden" name="edit-to-id" value="'.$student["id"].'" form="edit-'.$student["id"].'">
                            <button name="edit-student" type="button" class="btn btn-primary edit-student edit-'.$student["id"].'" name="edit-student edit-'.$student["id"].'" form="edit-'.$student["id"].'">Редактировать</button>
                        </td>
                        <td>
                            <button name="delete-student" type="button" class="btn btn-danger delete-student" form="edit-'.$student["id"].'">Удалить</button>
                        </td>
                </tr>';
            }

                echo '
                </tbody>
                </table>
                </div>
                </div>
            </div>';
        }
        }
        ?>


    </div>


<script>
    var input = document.querySelectorAll('input'); // get the input element
    input.forEach(element => {
        element.addEventListener('input', resizeInput); // bind the "resizeInput" callback on "input" event
        resizeInput.call(element); // immediately call the function

        function resizeInput() {
            this.style.width = String(this.value).length + 2 + "ch";
        }
    });


    var submits = document.querySelectorAll('.edit-student');
    submits.forEach(element => {  
        element.onclick = function() {
            element.classList.remove("btn-primary");
            element.classList.add("btn-success");
            element.innerHTML = "Сохранить";
            tmp = document.querySelectorAll('input[form="'+element.className.split(" ")[2]+'"]');
            tmp.forEach(element2 => {
                element2.disabled = false;
            });

            document.querySelector(".always-disabled").disabled = true;
            setTimeout(() => element.setAttribute("type", "submit"), 100);
            
        }
    });

    var deleters = document.querySelectorAll('.delete-student');
    deleters.forEach(element => {  
        element.onclick = function() {
            element.innerHTML = "Подтвердить";

            setTimeout(() => element.setAttribute("type", "submit"), 100);
            
        }
        
    });

    <?php 
        if($default_open == 1) {
            // По умолчанию 1 элемент открыт, ничего делать не нужно
        }

        else if($default_open == 2) {
            echo "$('#collapseTwo').collapse();";
        }

        else {
            echo "$('#collapseThree').collapse();";
        }
    ?>
</script>
</body>
</html>
