<?php
session_start();
require_once('../classes/UserLogic.php');
require_once('../classes/functions.php');
ini_set('display_errors', "On");
// ログインしているか判定、していなかったら新規登録画面へ返す
$result = UserLogic::checklogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location:http://localhost:8889/dating_app/public/signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];
$user = new UserLogic;
$gender = $user->getgender($login_user['user_id']);

$result = $user->getDifferent($gender);

require_once('header.php');
require_once('navmenu.php');
?>
<main>

    <div class="flex">
        <?php foreach ($result as $user) : ?>
            <div class="box">
            <img src="<?php echo h($user['img_path']); ?>" alt="プロフィール写真" width="100px">
            <p><?php echo h($user['name']); ?><?php echo getAge($user['birthdate']); ?>歳</p>
            </div>
        <?php endforeach; ?>

    </div>



</main>