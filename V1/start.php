<?php                                     
	require __DIR__."/*path*/dbc.php";

	if ($_SESSION) {
        header('Location: http://*my_site*/keeps.php');
    }
	$data = $_POST;
	$err_sign = '';
	$vi_sign = 'none;';
	$opo_sign = '0';

	if(isset($data['btn_sign'])) {
        $user = R::findOne('users', "login = ?", array($data['login_sign']));
        $vis_sign = 'block';
        $opo_sign = '1';
	    if(trim($data['login_sign']) == '') {
            $err_sign = 'Введите логин!';
        } elseif ($data['password_sign'] == ''){
	        $err_sign = 'Введите пароль!';
        } elseif (!$user) {
            $err_sign = "Пользватель не найден!";
        } elseif (password_verify($data['password_sign'], $user->password) == false) {
            $err_sign = "Введён неверный логин или пароль!";
        } else {
            $_SESSION['logged_user'] = $user;
            $_SESSION['view_mode'] = 0;
            $dta->start = "0000-00-00";
            $dta->end = "9999-01-01";
            $_SESSION['sort_data'] = $dta;
            $_SESSION['upd'] = 1;
            $_SESSION['view_mode'] = 1;
            $err_sign = "Всё верно!<br>Unno momento...";
            header('Location: http://*my_site*/keeps.php');
        }
    }

    $err_reg = '';
    $vi_reg = 'none;';
    $opo_reg = '0';

    if(isset($data['btn_reg'])) {
        //авторизация
        $vis_reg = 'block';
        $opo_reg = '1';
        if(trim($data['login_reg']) == '') {
            $err_reg = 'Введите логин!';
        } elseif ($data['email_reg'] == '') {
            $err_reg = 'Введите Email!';
        } elseif (stristr($data['email_reg'], '@') == FALSE || stristr($data['email_reg'], '.') == FALSE) {
            $err_reg = 'Некорректный Email!';
        } elseif ($data['password_reg'] == ''){
            $err_reg = 'Введите пароль!';
        } elseif (strlen($data['password_reg']) < 7) {
            $err_reg = 'Слишком короткий<br>пароль!';
        } elseif ($data['password2_reg'] == ''){
            $err_reg = 'Введите повторный пароль!';
        }  elseif ($data['password_reg'] != $data['password2_reg']){
            $err_reg = 'Пароли не совпадают!';
        } elseif (R::count('users', "login = ?", array($data['login_reg'])) != 0) {
            $err_reg = "Пользователь с таким именем<br>уже существует";
        }  elseif (R::count('users', "email = ?", array($data['email_reg'])) != 0) {
            $err_reg = "Пользователь с такой почтой<br>уже существует";
        } else {
            $user = R::dispense('users');
            $user->login = $data['login_reg'];
            $user->email = $data['email_reg'];
            $user->password = password_hash($data['password_reg'], PASSWORD_DEFAULT);
            R::store($user);
            $_SESSION['logged_user'] = $user;
            $_SESSION['view_mode'] = 0;
            $dta->start = "0000-00-00";
            $dta->end = "9999-01-01";
            $_SESSION['sort_data'] = $dta;
            $_SESSION['upd'] = 1;
            $_SESSION['view_mode'] = 1;
            $err_reg = "Вы зарегистрированы!<br>Момент!";
            header('Location: http://*my_site*/keeps.php');
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title></title>

    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/hg-start.css">
    <link rel="stylesheet" type="text/css" href="/css/modal.css">
    <link rel="stylesheet" type="text/css" href="/css/flex.css">
</head>
<body class="start_hg">
<main class="start_hg__main">
    <div class="box">
        <p class="name-start">KayliKeep</p>
        <p class="with-start">for your tasks</p>
        <div class="btn_start_sign_div">
            <a href="#" class="btn_start_sign" id="btn_modal_sign">Войти</a>
        </div>
        <div class="btn_start_reg_div">
            <a href="#" class="btn_start_reg" id="btn_modal_reg">Зарегистрироваться</a>
        </div>
    </div>
</main>

<!--#region Лишнее но нужное  -->
<header content="start_hg__header">

</header>
<div class="start_hg__left">

</div>
<div class="start_hg__right">

</div>
<footer class="start_hg__footer">

</footer>
<!--#endregion -->

<form action="#" method="POST" class="modal_window" id="form_sign" style="display: <?php echo @$vis_sign; ?>">
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
                <div class="container_content" id="o_sign" style="opacity: <?php echo @$opo_sign; ?>">
                        <p class="hat">Войти</p>
                        <input class="cin_start" type="text" id="login_sign" name="login_sign" placeholder="Login" value="<?php echo @$data['login_sign']; ?>" />
                        <input class="cin_start" type="password" id="password_sign" name="password_sign" placeholder="Password" value="<?php echo @$data['password_sign']; ?>"/>
                        <?php if(@$err_sign != '') {echo '<div class="err_txt">'.@$err_sign.'</div>';} ?>
                        <button class="btn_start_sign" style="border: none; margin-bottom: 50px" id="btn_sign" name="btn_sign">Вход</button>
                </div>
            </div>
            <div class="exit">
                <a href="#" id="exit_sign">свернуть</a>
            </div>
        </main>
    </div>
</form>

<form action="#" method="POST" class="modal_window" id="form_reg" style="display: <?php echo @$vis_reg; ?>">
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
                <div class="container_content" id="o_reg" style="opacity: <?php echo @$opo_reg; ?>">
                    <p class="hat">Регистрация</p>
                    <input class="cin_start" type="text" id="login_reg" name="login_reg" placeholder="Login" value="<?php echo @$data['login_reg']; ?>" />
                    <input class="cin_start" type="text" id="login_reg" name="email_reg" placeholder="Email" value="<?php echo @$data['email_reg']; ?>" />
                    <input class="cin_start" type="password" id="password_reg" name="password_reg" placeholder="Password" value="<?php echo @$data['password_reg']; ?>"/>
                    <input class="cin_start" type="password" id="password2_reg" name="password2_reg" placeholder="Confirm Password" value="<?php echo @$data['password2_reg']; ?>"/>
                    <?php if(@$err_reg != '') {echo '<div class="err_txt">'.@$err_reg.'</div>';} ?>
                    <button class="btn_start_sign" style="border: none; margin-bottom: 50px; width: 200px; margin-left: 55px;" id="btn_reg" name="btn_reg">Зарегистрироваться</button>
                </div>
            </div>
            <div class="exit">
                <a href="#" id="exit_sign">свернуть</a>
            </div>
        </main>
    </div>
</form>



<script src="//ajax.googleapis.com/ajax/*path*/jquery/3.1.0/jquery.min.js"></script>
<script>
    $(function () {
        console.log('la');
        $('#btn_modal_sign').click(function () {
            console.log('allo');
            $('#form_sign').fadeIn(500, function () {
                $('#o_sign').css('opacity','1');
            });
        });
        $('#exit_sign').click(function () {
            $('#o_sign').css('opacity','0');
            $('#form_sign').fadeOut(600);
        });
        $(document).click(function (event) {
            if ($(event.target).closest('#o_sign').length || $(event.target).closest('#btn_modal_sign').length || $(event.target).closest('#btn_sign').length) return;
            $('#o_sign').css('opacity','0');
            $('#form_sign').fadeOut(600);
            event.stopPropagation();
        });

        $('#btn_modal_reg').click(function () {
            console.log('allo');
            $('#form_reg').fadeIn(500, function () {
                $('#o_reg').css('opacity','1');
            });
        });
        $('#exit_reg').click(function () {
            $('#o_reg').css('opacity','0');
            $('#form_reg').fadeOut(600);
        });
        $(document).click(function (event) {
            if ($(event.target).closest('#o_reg').length || $(event.target).closest('#btn_modal_reg').length || $(event.target).closest('#btn_reg').length) return;
            $('#o_reg').css('opacity','0');
            $('#form_reg').fadeOut(600);
            event.stopPropagation();
        });
    });
</script>
</body>
</html>
