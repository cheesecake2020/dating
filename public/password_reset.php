<?php
session_start();
require_once('../classes/UserLogic.php');
require_once('../classes/chatLogic.php');
require_once('../classes/functions.php');
ini_set('display_errors', "On");
$title = 'パスワードリセット';
require_once('header.php');

?>
<div class="container my-5">
    <h2 class="mb-5">パスワードの再設定</h2>
    <p>ご登録のメールアドレスをご入力いただき、受信されたメールにしたがってパスワードの再設定を行ってください。</p>
    <form action="password_check.php" method="POST">
    <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">
        <div class="form-group">
            <label for="username">ご登録のメールアドレス</label>
            <input class="form-control" type="email" name="email" placeholder="メールアドレス"required>
        </div>
        <button type="submit" name="reset-password"class="btn btn-primary mb-2">送信</button>
        <a href="login_form.php"><button class="btn btn-outline-secondary mb-2">戻る</button></a>
    </form>
</div>
<?php require_once('footer.php');?>