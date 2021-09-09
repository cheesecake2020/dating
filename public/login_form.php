<?php
session_start();
require_once('../classes/UserLogic.php');
require_once('../classes/functions.php');
if(empty($_SERVER["HTTPS"])){
    $sever="http://";  
}else{
    $sever="https://";
}
$result = UserLogic::checklogin();
if ($result) {
    header('Location:'.$sever.$_SERVER['HTTP_HOST'].'/public/mypage.php');
    return;
}


$err = $_SESSION;
// セッションを消す
$_SESSION = array();
session_destroy();
$title = 'ログイン';
require_once('header.php');
?>
<section class="home">
    <div class="container">
        <div class="text1">
            <div>
                <h1 class="h1">カップリング．</h1>
                <p>男女の出会いをサポート</p>
            </div>
            <div class="mybox">
                <button class="btn btn-primary login " data-toggle="modal" data-target="#loginModal">ログイン</button>
                <a href="signup_form.php"><button class="btn btn-primary login mt-3">新規登録</button></a>
                <button class="btn btn-primary login mt-3" data-toggle="modal" data-target="#guestModal">体験(男性アカウント）</button>
            </div>
        </div>
    </div>
</section>


<div id="loginModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">ログインする</h2>
                <button class="btn btn-secondary" data-dismiss="modal">✖</button>
            </div>
            <div class="modal-body">
                <?php if (isset($login_err)) : ?>
                    <p class="err"><?php echo $login_err; ?></p>
                <?php endif; ?>
                <form action="login.php" method="POST" class="modal-body">

                    <div class="form-group">
                        <label for="email">メールアドレス：</label>
                        <input class="form-control" type="email" name="email">
                        <?php if (isset($err['email'])) : ?>
                            <p class="err"><?php echo $err['email']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password">パスワード：</label>
                        <input class="form-control" type="password" name="password">
                        <?php if (isset($err['password'])) : ?>
                            <p class="err"><?php echo $err['password']; ?></p>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">ログイン</button>
                </form>
                <a href="password_reset.php">パスワードを忘れ方</a>
            </div>
        </div>
    </div>

</div>
<div id="guestModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">お試しログイン</h2>
                <button class="btn btn-secondary" data-dismiss="modal">✖</button>
            </div>
            <div class="modal-body">
                <?php if (isset($login_err)) : ?>
                    <p class="err"><?php echo $login_err; ?></p>
                <?php endif; ?>
                <form action="login.php" method="POST" class="modal-body">

                    <div class="form-group">
                        <label for="email">メールアドレス：</label>
                        <input class="form-control" type="password" name="email"value="shoitiro@example.com" readonly>
                    </div>

                    <div class="form-group">
                        <label for="password">パスワード：</label>
                        <input class="form-control" type="password" name="password"value="shoitiro55" readonly>
                    </div>

                    <button type="submit" class="btn btn-success">ログイン</button>
                </form>
                <a href="signup_form.php">新規登録はこちら</a>
            </div>
        </div>
    </div>

</div>




<?php require_once('footer.php'); ?>