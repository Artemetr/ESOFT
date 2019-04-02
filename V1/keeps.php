<?php
    require __DIR__."/libs/dbc.php";

    if (!$_SESSION) {
        require __DIR__."/libs/lo.php";
    }

    $data = $_POST;
    if(isset($data['btn_byby'])) {
        require __DIR__."/libs/lo.php";
    }

    if(isset($data['btn_add_new_task'])) {
        if (1 == 2) {

        } else {
            $new_task = R::dispense('tasks');
            $new_task->login = $_SESSION['logged_user']->login;
            $new_task->name = $data['add_task_name'];
            $new_task->short_name = $data['add_short_task_name'];
            $new_task->important = $data['add_important_task'];
            $new_task->friends = $data['add_friends_task'];
            $new_task->about = $data['add_about_task'];
            $start = $data['add_start_date_task'];
            $end = $data['add_end_date_task'];
            if ($start) {
                $new_task->start_date = $start;
            } elseif ($end) {
                $new_task->start_date = $end;
            } else {
                $new_task->start_date = date('Y-m-d');
            }

            if ($end) {
                $new_task->end_date = $end;
            } elseif ($start) {
                $new_task->end_date = $start;
            } else {
                $new_task->end_date = date('Y-m-d');
            }
            R::store($new_task);

            header('Location: http://artemetr.1gb.ru/keeps.php');
        }
    }

    if(isset($data['btn_day'])) {
        $now_d = date('Y-m-d');
        $_SESSION['sort_data']->start = $now_d;
        $_SESSION['sort_data']->end = $now_d;
        $_SESSION['test']->day = 1;
        header('Location: http://artemetr.1gb.ru/keeps.php');
    }
    if(isset($data['btn_week'])) {
        $now_d = date('Y-m-d');
        $_SESSION['sort_data']->start = $now_d;
        $_SESSION['sort_data']->end = date('Y-m-d', strtotime(' + 7 days'));;
        $_SESSION['test']->week = 1;
        header('Location: http://artemetr.1gb.ru/keeps.php');
    }
    if(isset($data['btn_mon'])) {
        $now_d = date('Y-m-d');
        $_SESSION['sort_data']->start = $now_d;
        $_SESSION['sort_data']->end = date('Y-m-d', strtotime(' + 1 month'));
        $_SESSION['test']->mon = 1;
        header('Location: http://artemetr.1gb.ru/keeps.php');
    }

    if(isset($data['btn_select_date'])) {
        $start = $data['start_select_date'];
        $end = $data['end_select_date'];
        $nn = NULL;
        if ($start) {
            $nn->start = $start;
        } else {
            $nn->start = "0000-00-00";
        }
        if ($end) {
            $nn->end = $end;
        } else {
            $nn->end = "9999-01-01";
        }
        $_SESSION['sort_data'] = $nn;
        header('Location: http://artemetr.1gb.ru/keeps.php');
    }

    $all_user_task = R::find('tasks', "login = ? AND start_date>=? AND end_date<=? ORDER BY start_date ASC", array($_SESSION['logged_user']->login,$_SESSION['sort_data']->start,$_SESSION['sort_data']->end));
    $n_all_user_task = count($all_user_task);

    if(isset($data['btn_up'])) {
        $all_user_task = R::find('tasks', "login = ? AND start_date>=? AND end_date<=? ORDER BY start_date ASC", array($_SESSION['logged_user']->login,$_SESSION['sort_data']->start,$_SESSION['sort_data']->end));
        echo '<script>//console.log("'.$all_user_task.'")</script>';
    }

    if(isset($data['btn_down'])) {
        $all_user_task = R::find('tasks', "login = ? AND start_date>=? AND end_date<=? ORDER BY start_date DESC", array($_SESSION['logged_user']->login,$_SESSION['sort_data']->start,$_SESSION['sort_data']->end));
        echo '<script>//console.log("'.$all_user_task.'")</script>';
    }

    if($_SESSION['test']->day == 1) {
        $all_user_task = R::find('tasks', "login = ? AND start_date=? ORDER BY start_date DESC", array($_SESSION['logged_user']->login,$_SESSION['sort_data']->start));
        $_SESSION['test']->day = 0;
        echo '<script>//console.log("'.$all_user_task.'")</script>';
    }

    if($_SESSION['test']->week == 1) {
        $all_user_task = R::find('tasks', "login = ? AND start_date>=? AND start_date<=? ORDER BY start_date DESC", array($_SESSION['logged_user']->login,$_SESSION['sort_data']->start,$_SESSION['sort_data']->end));
        $_SESSION['test']->week = 0;
        echo '<script>//console.log("'.$all_user_task.'")</script>';
    }

    if($_SESSION['test']->mon == 1) {
        $all_user_task = R::find('tasks', "login = ? AND start_date>=? AND start_date<=? ORDER BY start_date DESC", array($_SESSION['logged_user']->login,$_SESSION['sort_data']->start,$_SESSION['sort_data']->end));
        $_SESSION['test']->mon = 0;
        echo '<script>//console.log("'.$all_user_task.'")</script>';
    }



if (isset($data['btn_calendar'])) {
        $_SESSION['view_mode'] = 1;
    }
    if (isset($data['btn_stik'])) {
        $_SESSION['view_mode'] = 0;
    }

    if(isset($data['btn_edit_new_task'])) {
        $t_h = $_POST['t_id'];
        //echo '<script>//console.log("'.$t_h.'")</script>';
        $s = R::find('tasks', "login = ?", array($_SESSION['logged_user']->login));
        foreach ($s as $ky => &$vv) {
            echo '<script>//console.log("'.$ky.'")</script>'.'<script>//console.log("'.$t_h.'")</script>';
            if($ky == $data['t_id']) {
                $_SESSION['test']->test = $data['edit_start_date_task'];
                $s[$ky]->name = $data['edit_task_name'];
                echo '<script>//console.log("'.$ky.'")</script>';
                $s[$ky]->short_name = $data['edit_short_task_name'];
                $s[$ky]->important = $data['edit_important_task'];
                $s[$ky]->friends = $data['edit_friends_task'];
                $s[$ky]->about = $data['edit_about_task'];
                $start = $data['edit_start_date_task'];
                $end = $data['edit_start_date_task'];
                if ($start) {
                    $s[$ky]->start_date = $start;
                } elseif ($end) {
                    $s[$ky]->start_date = $end;
                } else {
                    $s[$ky]->start_date = date('Y-m-d');
                }
                if ($end) {
                    $s[$ky]->end_date = $end;
                } elseif ($start) {
                    $s[$ky]->end_date = $start;
                } else {
                    $s[$ky]->end_date = date('Y-m-d');
                }
                R::storeAll($s);
                header('Location: http://artemetr.1gb.ru/keeps.php');
                break;
            }

        }
    }

    if(isset($data['btn_delete_task'])) {
        $t_h = $_POST['t_id'];
        //echo '<script>//console.log("'.$t_h.'")</script>';
        $s = R::findOne('tasks', "login = ? AND id = ?", array($_SESSION['logged_user']->login, $t_h));
        //echo "<pre>$t_h:{$s}<br>";
        //var_dump($s);
        R::trash($s);
        header('Location: http://artemetr.1gb.ru/keeps.php');
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Заметки || KayliKeep</title>

    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/hg-start.css">
    <link rel="stylesheet" type="text/css" href="/css/modal.css">
    <link rel="stylesheet" type="text/css" href="/css/hg-keeps.css">
</head>
<body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<header>
    <div id="hat">
        <div class="h_l">
            <p style="margin:0px">KayliKeep <?php if($_SESSION){echo " | ".$_SESSION['logged_user']->login;} ?></p>
        </div>
        <form action="#" method="POST" id="byby">
            <div class="h_r">
                <button id="btn_bybya" name="btn_byby">Выход</button>
            </div>
        </form>
    </div>
</header>

<form action="#" method="POST" id="add_form" name="add_form">
    <div style="position:fixed;bottom: 30px;right: 30px;width:60px;height: 60px;box-shadow: 0 0 2px rgba(0, 0, 0, 0.2); border-radius: 50px;">
        <a href="#" class="af" id="btn_add_Task"><div style="margin-top: 17px;">new</div></a>
    </div>
    <div style="position:fixed;bottom: 30px;left: 30px;width:110px;height: 300px;box-shadow: 0 0 2px rgba(0, 0, 0, 0.3); border-radius: 20px;">
        <div class="l_b">
            <p>Режимы отображения</p>
            <button id="btn_calendar" name="btn_calendar" style="margin-left: 22px">Календарь</button>
            <button id="btn_stik" name="btn_stik" style="margin-left: 27px">Стикеры</button>
            <p>Фильтр по<br>дате</p>
            <a href="#" id="btn_data" style="margin-left: 22px">Настроить</a>
            <p>Сортировка по дате</p>
            <button id="btn_up" name="btn_up" style="">Возрастание</button>
            <button id="btn_down" name="btn_down" style="margin-left: 24px">Убывание</button>
        </div>
    </div>
</form>

<main>
    <form action="#" method="POST">
        <input type="hidden" id="t_hidden" name="t_hidden" value="">
        <div style="height: 70px"></div>
        <?php
            if (@$_SESSION['view_mode'] == 1) {
                foreach ($all_user_task as $key => &$value) {
                    echo
                    '
                        <div class="tc">
                            <a href="#" id="btn_t_'.$key.'" name="btn_t_'.$key.'">
                                <div class="tc_box">    
                                    <div class="tc_box_nbox"> 
                                        <div class="tc_box_date">';
                                            if ($all_user_task[$key]->start_date != '0000-00-00' && $all_user_task[$key]->start_date != null) {
                                                echo date_format(date_create($all_user_task[$key]->start_date), 'd.m.Y');
                                            }
                                            echo '</div>
                                            <div class="tc_box_del"></div>
                                            <div class="tc_box_name">'.$all_user_task[$key]->name.'</div>
                                            <div class="tc_box_content">Важность:'.$all_user_task[$key]->important.'</div>
                                            <div class="tc_box_content">'.$all_user_task[$key]->short_name.'</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    ';
        
                    echo
                    '
                        <script>
                            $(function () {
                                $("#btn_t_'.$all_user_task[$key]->id.'").click(function () {
                                    $("#form_edit_task").fadeIn(500, function () {
                                        $("#o_edit_task").css("opacity","1");
                                    });
                                    $("#t_hidden").value = "1";
                                    $("#t_id").val("'.$key.'");
                                    //console.log("Открылось");
                                    //console.log(document.getElementById("t_id").value);
                                    $("#edit_task_name").val("'.$all_user_task[$key]->name.'");
                                    $("#edit_short_task_name").val("'.$all_user_task[$key]->short_name.'");
                                    $("#edit_important_task").val("'.$all_user_task[$key]->important.'");
                                    $("#edit_friends_task").val("'.$all_user_task[$key]->friends.'");
                                    $("#edit_about_task").val("'.$all_user_task[$key]->about.'");
                                    $("#edit_start_date_task").val("'.$all_user_task[$key]->start_date.'");
                                    $("#edit_end_date_task").val("'.$all_user_task[$key]->end_date.'");
                                });
                                $("#exit_edit_task").click(function () {
                                    $("#o_edit_task").css("opacity","0");
                                    $("#form_edit_task").fadeOut(600);
                                    $("#t_hidden").value = "0";
                                    $("#t_id").val("'.$key.'");
                                    //console.log("Закрылось");
                                });
                            });
                        </script>
                    ';
                }
            } 
            elseif (@$_SESSION['view_mode'] == 0) {
                foreach ($all_user_task as $key => &$value) {
                    echo
                    '
                        <div class="task">
                            <a href="#" id="btn_t_'.$all_user_task[$key]->id.'" name="btn_t_'.$all_user_task[$key]->id.'">
                                <div class="task_box">
                                    <div class="task_box_nbox">
                                        <div class="task_box_name">'.$all_user_task[$key]->name.'</div>
                                        <div class="task_box_content"><br>'.$all_user_task[$key]->friends.'<br> Важность: ';
                                        if($all_user_task[$key]->important == null) {
                                            echo "-";
                                        } else echo $all_user_task[$key]->important.'<br>';
                                        if ($all_user_task[$key]->start_date != '0000-00-00' && $all_user_task[$key]->start_date != null) {
                                            echo 'Начало:<br>';
                                            echo date_format(date_create($all_user_task[$key]->start_date), 'd.m.Y');
                                            echo '<br>';
                                        }
                                        if ($all_user_task[$key]->end_date != '0000-00-00' && $all_user_task[$key]->end_date != null) {
                                            echo 'Окончание:<br>';
                                            echo date_format(date_create($all_user_task[$key]->end_date), 'd.m.Y');
                                            echo '<br>';
                                        }
                                        echo '<br>'.$all_user_task[$key]->short_name.'
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    ';
        
                    echo
                    '
                        <script>
                            $(function () {
                                $("#btn_t_';echo $key;echo '").click(function () {
                                    $("#form_edit_task").fadeIn(500, function () {
                                        $("#o_edit_task").css("opacity","1");
                                    });
                                    $("#t_hidden").value = "1";
                                    $("#t_id").val("'.$key.'");
                                    //console.log("Открылось");
                                    $("#edit_task_name").val("'.$all_user_task[$key]->name.'");
                                    $("#edit_short_task_name").val("'.$all_user_task[$key]->short_name.'");
                                    $("#edit_important_task").val("'.$all_user_task[$key]->important.'");
                                    $("#edit_friends_task").val("'.$all_user_task[$key]->friends.'");
                                    $("#edit_about_task").val("'.$all_user_task[$key]->about.'");
                                    $("#edit_start_date_task").val("'.$all_user_task[$key]->start_date.'");
                                    $("#edit_end_date_task").val("'.$all_user_task[$key]->end_date.'");
                                });
                                $("#exit_edit_task").click(function () {
                                    $("#o_edit_task").css("opacity","0");
                                    $("#form_edit_task").fadeOut(600);
                                    $("#t_hidden").value = "0";
                                    $("#t_id").val("'.$key.'");
                                    //console.log("Закрылось");
                                });
                            });
                        </script>
                    ';
                }
            }
            
            echo
            '
                <script>
                    $(document).click(function (event) {
                        if ($(event.target).closest("#o_edit_task").length || $(event.target).closest("#btn_edit_task").length';
                        foreach ($all_user_task as $key => &$value) {
                            echo '|| $(event.target).closest("#btn_t_'.$all_user_task[$key]->id.'").length';
                        }
                        echo ') return;
                        $("#o_edit_task").css("opacity","0");
                        $("#form_edit_task").fadeOut(600);
                        event . stopPropagation();
                        $("#t_hidden").value = "0";
                        $("#t_id").val('.$all_user_task[$key]->id.');
                        //console . log("Закрылось");
                    });
                </script>
            ';
    
        ?>
        <!--<div class="tc">
            <button href="#" id="btn_t_no" name="btn_t_no" diex="1">
                <div class="tc_box">
                    <div class="tc_box_nbox">
                        <div class="tc_box_date">16.09.2000</div>
                        <div class="tc_box_del"></div>
                        <div class="tc_box_name">
                            Имя
                        </div>
                        <div class="tc_box_content">Краткое описаниеa sdasss ssssssssssssss ssss ssss sss</div>
                    </div>
                </div>
            </button>
        </div>-->
    </form>
</main>

<form action="#" method="POST" class="modal_window" id="form_edit_task" style="display: <?php echo @$data['t_hidden']; ?>">
    <input type="hidden" id="t_id" name="t_id" value="3">
    <div class="modal_form_sign_hg">
        <div class="modal_form_sign_hg__header">
        </div>
        <div class="modal_form_sign_hg__footer">
        </div>
        <div class="modal_form_sign_hg__right">
        </div>
        <div class="modal_form_sign_hg__left">
        </div>
        <main class="modal_form_sign_hg__main">
            <div class="container">
                <div class="container_content" id="o_edit_task" style="opacity: <?php echo @$opo_reg; ?>">
                    <div style="padding: 15px;">
                        <p class="hat" style="margin: 20px">Edit Task</p>
                        <input class="cin_start" type="text" id="edit_task_name" name="edit_task_name" placeholder="Название" value="<?php echo @$data['add_task_name']; ?>"  style="width: 278px; margin-left: 0px;"/>
                        <input class="cin_start" type="text" id="edit_short_task_name" name="edit_short_task_name" placeholder="Краткое описание" value="<?php echo @$data['add_short_task_name']; ?>"  style="width: 278px; margin-left: 0px;"/>
                        <input class="cin_start" type="text" id="edit_important_task" name="edit_important_task" placeholder="Оцените важность от 0 (не важно) до 10 (очень важно)" value="<?php echo @$data['add_important_task']; ?>" style="width: 278px; margin-left: 0px;"/>
                        <input class="cin_start" type="text" id="edit_friends_task" name="edit_friends_task" placeholder="Участники" value="<?php echo @$data['add_friends_task']; ?>" style="width: 278px; margin-left: 0px;"/>
                        <textarea rows="10" class="cin_start" type="text" id="edit_about_task" name="edit_about_task" rows="7" placeholder="Описание..." value="<?php echo @$data['add_about_task']; ?>" style="width: 275px; margin-left: 0px; border-radius: 12px; height: 45px; padding: 10px; outline: none; margin-bottom: 0px"></textarea>
                        <p class="err_txt" style="margin: 5px">Дата начала (не обязательно)</p>
                        <input class="cin_start" type="date" id="edit_start_date_task" name="edit_start_date_task" placeholder="Начало" value="<?php echo @$data['add_start_date_task']; ?>" style="width: 278px; margin-left: 0px; margin-bottom: 0px"/>
                        <p class="err_txt" style="margin: 5px">Дата окончания (не обязательно)</p>
                        <input class="cin_start" type="date" id="edit_end_date_task" name="edit_end_date_task" placeholder="Окончание" value="<?php echo @$data['add_end_date_task']; ?>" style="width: 278px; margin-left: 0px;"/>
                        <?php if(@$err_edit_task != '') {echo '<div class="err_txt">'.@$err_edit_task.'</div>';} ?>
                        <button class="btn_start_sign" style="border: none; margin-bottom: 10px; width: 200px; margin-left: 45px;" id="btn_edit_new_task" name="btn_edit_new_task">Применить</button>
                        <button class="btn_start_sign" style="border: none; margin-bottom: 20px; width: 200px; margin-left: 45px;" id="btn_delete_task" name="btn_delete_task">Удалить</button>
                    </div>
                    <!-- <input class="cin_start" type="text" id="password2_sign" placeholder="Confirm Password"/> -->
                </div>
            </div>
            <div class="exit">
                <a href="#" id="exit_edit_task">свернуть</a>
            </div>
        </main>
    </div>
</form>

<form action="#" method="POST" class="modal_window" id="form_add_task" style="display: <?php echo @$vis_reg; ?>">
    <div class="modal_form_sign_hg">
        <div class="modal_form_sign_hg__header">
        </div>
        <div class="modal_form_sign_hg__footer">
        </div>
        <div class="modal_form_sign_hg__right">
        </div>
        <div class="modal_form_sign_hg__left">
        </div>
        <main class="modal_form_sign_hg__main">
            <div class="container">
                <div class="container_content" id="o_add_task" style="opacity: <?php echo @$opo_reg; ?>">
                    <div style="padding: 15px;">
                        <p class="hat" style="margin: 20px">New Task</p>
                        <input class="cin_start" type="text" id="add_task_name" name="add_task_name" placeholder="Название" value="<?php echo @$data['add_task_name']; ?>"  style="width: 278px; margin-left: 0px;"/>
                        <input class="cin_start" type="text" id="add_short_task_name" name="add_short_task_name" placeholder="Краткое описание" value="<?php echo @$data['add_short_task_name']; ?>"  style="width: 278px; margin-left: 0px;"/>
                        <input class="cin_start" type="text" id="add_important_task" name="add_important_task" placeholder="Оцените важность от 0 (не важно) до 10 (очень важно)" value="<?php echo @$data['add_important_task']; ?>" style="width: 278px; margin-left: 0px;"/>
                        <input class="cin_start" type="text" id="add_friends_task" name="add_friends_task" placeholder="Участники" value="<?php echo @$data['add_friends_task']; ?>" style="width: 278px; margin-left: 0px;"/>
                        <textarea rows="10" class="cin_start" type="text" id="add_about_task" name="add_about_task" rows="7" placeholder="Описание..." value="<?php echo @$data['add_about_task']; ?>" style="width: 275px; margin-left: 0px; border-radius: 12px; height: 45px; padding: 10px; outline: none; margin-bottom: 0px"></textarea>
                        <p class="err_txt" style="margin: 5px">Дата начала (не обязательно)</p>
                        <input class="cin_start" type="date" id="add_start_date_task" name="add_start_date_task" placeholder="Начало" value="<?php echo @$data['add_start_date_task']; ?>" style="width: 278px; margin-left: 0px; margin-bottom: 0px"/>
                        <p class="err_txt" style="margin: 5px">Дата окончания (не обязательно)</p>
                        <input class="cin_start" type="date" id="add_end_date_task" name="add_end_date_task" placeholder="Окончание" value="<?php echo @$data['add_end_date_task']; ?>" style="width: 278px; margin-left: 0px;"/>
                        <?php if(@$err_add_task != '') {echo '<div class="err_txt">'.@$err_add_task.'</div>';} ?>
                        <button class="btn_start_sign" style="border: none; margin-bottom: 50px; width: 200px; margin-left: 45px;" id="btn_add_new_task" name="btn_add_new_task">Добавить</button>
                    </div>
                    <!-- <input class="cin_start" type="text" id="password2_sign" placeholder="Confirm Password"/> -->
                </div>
            </div>
            <div class="exit">
                <a href="#" id="exit_add_task">свернуть</a>
            </div>
        </main>
    </div>
</form>

<form action="#" method="POST" class="modal_window" id="form_select_date" style="display: <?php echo @$vis_reg; ?>">
    <div class="modal_form_sign_hg">
        <div class="modal_form_sign_hg__header">
        </div>
        <div class="modal_form_sign_hg__footer">
        </div>
        <div class="modal_form_sign_hg__right">
        </div>
        <div class="modal_form_sign_hg__left">
        </div>
        <main class="modal_form_sign_hg__main">
            <div class="container">
                <div class="container_content" id="o_select_date" style="opacity: <?php echo @$opo_reg; ?>">
                    <div style="padding: 15px;">
                        <p class="hat" style="margin: 20px">Time range</p>
                        <p class="err_txt" style="margin: 5px">Дата начала (не обязательно)</p>
                        <input class="cin_start" type="date" id="start_select_date" name="start_select_date" placeholder="Начало" value="<?php echo @$data['start_select_date']; ?>" style="width: 278px; margin-left: 0px; margin-bottom: 0px"/>
                        <p class="err_txt" style="margin: 5px">Дата окончания (не обязательно)</p>
                        <input class="cin_start" type="date" id="end_select_date" name="end_select_date" placeholder="Окончание" value="<?php echo @$data['end_select_date']; ?>" style="width: 278px; margin-left: 0px;"/>
                        <?php if(@$err_task != '') {echo '<div class="err_txt">'.@$err_task.'</div>';} ?>
                        <button class="btn_start_sign" style="border: none; margin-bottom: 0px; width: 200px; margin-left: 45px;" id="btn_select_date" name="btn_select_date">Применить</button>
                        <p class="hat" style="margin: 20px; font-size: 20px">или отобразить промежуток за</p>
                        <button class="btn_start_sign" style="border: none; margin-bottom: 20px; width: 200px; margin-left: 45px;" id="btn_day" name="btn_day">День</button>
                        <button class="btn_start_sign" style="border: none; margin-bottom: 20px; width: 200px; margin-left: 45px;" id="btn_week" name="btn_week">Неделю</button>
                        <button class="btn_start_sign" style="border: none; margin-bottom: 50px; width: 200px; margin-left: 45px;" id="btn_mon" name="btn_mon">Месяц</button>

                    </div>
                    <!-- <input class="cin_start" type="text" id="password2_sign" placeholder="Confirm Password"/> -->
                </div>
            </div>
            <div class="exit">
                <a href="#" id="exit_select_date">свернуть</a>
            </div>
        </main>
    </div>
</form>


<script>
    $(function () {
        //console.log('la');
        $('#btn_add_Task').click(function () {
            //console.log('allo');
            $('#form_add_task').fadeIn(500, function () {
                $('#o_add_task').css('opacity','1');
            });
        });
        $('#exit_add_task').click(function () {
            $('#o_add_task').css('opacity','0');
            $('#form_add_task').fadeOut(600);
        });
        $(document).click(function (event) {
            if ($(event.target).closest('#o_add_task').length || $(event.target).closest('#btn_add_new_task').length || $(event.target).closest('#btn_add_Task').length) return;
            $('#o_add_task').css('opacity','0');
            $('#form_add_task').fadeOut(600);
            event.stopPropagation();
        });



        $('#btn_data').click(function () {
            //console.log('allo');
            $('#form_select_date').fadeIn(500, function () {
                $('#o_select_date').css('opacity','1');
            });
        });
        $('#exit_select_date').click(function () {
            $('#o_select_date').css('opacity','0');
            $('#form_select_date').fadeOut(600);
        });
        $(document).click(function (event) {
            if ($(event.target).closest('#o_select_date').length || $(event.target).closest('#btn_data').length || $(event.target).closest('#btn_select_date').length) return;
            $('#o_select_date').css('opacity','0');
            $('#form_select_date').fadeOut(600);
            event.stopPropagation();
        });


        $('#btn_data').click(function () {
            //console.log('allo');
            $('#form_select_date').fadeIn(500, function () {
                $('#o_select_date').css('opacity','1');
            });
        });
        $('#exit_select_date').click(function () {
            $('#o_select_date').css('opacity','0');
            $('#form_select_date').fadeOut(600);
        });
        $(document).click(function (event) {
            if ($(event.target).closest('#o_select_date').length || $(event.target).closest('#btn_data').length || $(event.target).closest('#btn_select_date').length) return;
            $('#o_select_date').css('opacity','0');
            $('#form_select_date').fadeOut(600);
            event.stopPropagation();
        });
    });
</script>
</body>
</html>
