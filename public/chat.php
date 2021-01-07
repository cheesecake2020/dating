<?php
session_start();
require('../vendor/autoload.php');
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
$userdata = $user->viewprofile($login_user['email']);
$userimg = $user->viewImg($login_user['user_id']);
$title='マイページ';
require_once('header.php');
require_once('navmenu.php');
use Ratchet\Server\IoServer;
use MyApp\Chat;
    $server = IoServer::factory(
        new Chat(),
        8080
    );

    $server->run();
?>
<main>

    <p>メッセージはありません</p>
</main>
<?php require_once('footer.php');?>