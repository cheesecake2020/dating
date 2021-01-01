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

// echo "<pre>";
// var_dump($result);
// echo "<pre>";
?>
<main>

    <div class="flex">

        <?php foreach ($result as $user) : ?>
            <div class="box">
                <a href="other_page.php?id=<?php echo h($user['user_id']); ?>">
                    <img src="<?php echo h($user['profile_path']); ?>" alt="プロフィール写真" width="100px">
                </a>
                <p><?php echo h($user['name']); ?><?php echo getAge($user['birthdate']); ?>歳</p>
            </div>
        <?php endforeach; ?>

    </div>



</main>
<?php require_once('footer.php');?>