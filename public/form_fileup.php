<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../classes/UserLogic.php');
require_once('../classes/functions.php');
ini_set('display_errors', "On");
$login_user = $_SESSION['login_user'];
$title = 'マイページ';
require_once('header.php');
require_once('navmenu.php');

?>


<main class="container">

    <h1>プロフィール写真</h1>
    <form enctype="multipart/form-data" action="check_fileup.php" method="POST">
        <div class="form-group">
            <label >写真を選択してください</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
            <input class="form-control-file"name="img" type="file" accept="image/*" />
        </div>
        <!-- エラーがあれば表示 -->
        <?php if (isset($error)) : ?>
            <?php foreach ($error as $val) : ?>
                <p class="err"><?php echo $val; ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <!-- エラー表示おわり -->
<div class="btnflex">
        <button class="btn btn-primary mr-5"type="submit">送信</button>
    </form>

    <button class="btn btn-outline-dark"><a href="editprofile.php">戻る</a></button>

    </div>
</main>
<?php require_once('footer.php'); ?>