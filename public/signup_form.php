<?php
session_start();
require_once('../classes/functions.php');
require_once('../classes/UserLogic.php');
error_reporting(-1);
ini_set('display_errors', "On");
$result = UserLogic::checklogin();
if ($result) {
    header('Location:http://localhost:8889/dating_app/public/mypage.php');
    return;
}
$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);
$title = 'ユーザー登録';
require_once('header.php');
?>


<section class="home">
   <div class="container">
<div class="text2">

    <h3>新規登録</h3>
    <?php if (isset($login_err)) : ?>
        <p class="err"><?php echo $login_err; ?></p>
    <?php endif; ?>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="username">お名前：</label>
            <input class="form-control" type="text" name="name">
        </div>
        <div class="form-group">
            <label for="email">メールアドレス：</label>
            <input class="form-control" type="email" name="email">
        </div>
        <div class="form-group">
            <label for="password">パスワード：</label>
            <input class="form-control" type="password" name="password">
        </div>
        <div class="form-group">
            <label for="password_conf">パスワード確認：</label>
            <input class="form-control" type="password" name="password_conf">
        </div>
        <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
        <button type="submit" class="btn login btn-primary mb-2">新規登録</button>
    </form>
    <a href="login_form.php">ログインする</a>
</div>
   </div>
      

</section>

<?php require_once('footer.php'); ?>