<?php 
session_start();
require_once('../classes/functions.php');
require_once('../classes/UserLogic.php');
error_reporting(-1);
ini_set('display_errors', "On");
$result = UserLogic::checklogin();
if($result){
    header('Location:http://localhost:8889/dating_app/public/mypage.php');
    return;
}
$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>ユーザー登録画面</title>
</head>
<body>
<main>

    <h2>ユーザー登録フォーム</h2>
    <?php if(isset($login_err)):?>
        <p class="err"><?php echo $login_err;?></p>
    <?php endif;?>
    <form action="register.php" method="POST">
    <div>
    <label for="username">お名前：<input type="text" name="name"></label>
    </div>
    <div>
    <label for="email">メールアドレス：<input type="email" name="email"></label>
    </div>
    <div>
    <label for="password">パスワード：<input type="password" name="password"></label>
    </div>
    <div>
    <label for="password_conf">パスワード確認：<input type="password" name="password_conf"></label>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo h(setToken());?>">
    <button type="submit">新規登録</button>
    </form>
    <a href="login_form.php">ログインする</a>
</main>
</body>
</html>