<?php
session_start();
require_once('../classes/UserLogic.php');
require_once('../classes/ChatLogic.php');
require_once('../classes/functions.php');
ini_set('display_errors', "On");
// ログインしているか判定、していなかったら新規登録画面へ返す
$result = UserLogic::checklogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location:http://localhost:8889/dating_app/public/signup_form.php');
    return;
}
$title = 'メッセージ';
require_once('header.php');
require_once('navmenu.php');
// ゲットの値受け取り
if (isset($_GET['id'])) {
    $otherid = $_GET['id'];
}
$user = new UserLogic;
$chat = new ChatLogic;

$othername = $user->getByothername($otherid);
$otherimage = $user->getByotherimage($otherid);
$login_user = $_SESSION['login_user'];
$userimage = $user->getByotherimage($login_user['user_id']);
$get = $chat->Createroom($login_user['user_id'], $otherid);
$roomNum = $chat->getRoom($login_user['user_id'], $otherid);
$chatMsg = $chat->getMsg($roomNum);
?>
<!-- DIRECT CHAT -->

<section class="mymain">
    <div class="container" id="chat">
        <h4 class="text-center"><?php echo h($othername); ?></h4>
        <?php if ($chatMsg) : ?>
            <?php foreach ($chatMsg as $Msg) : ?>
                <?php if ($Msg['send_userid'] === $login_user['user_id']) : ?>
                    <div class="chat-right mb-3" id="inner_left_pannel">
                        <img class="chatimg  ml-3" src="<?php echo h($userimage); ?>" alt="ユーザー写真">
                        <div class="chat">
                            <p class="msg-right mb-0"><?php echo h($Msg['message']); ?></p>
                            <time><?php echo h($Msg['created_at']); ?></time>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($Msg['send_userid'] === $otherid) : ?>
                    <div class="chat-left mb-3 ">
                        <img class="chatimg mr-3" src="<?php echo h($otherimage); ?>" alt="相手写真">
                        <div class="chat">
                            <p class="msg-left mb-0"><?php echo h($Msg['message']); ?></p>
                            <time><?php echo h($Msg['created_at']); ?></time>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- /.card-body -->
<div class="card-footer">
    <form method="POST" id="cardfooter">
        <div class="hidden_box">
            <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">　
            <input type="hidden" name="roomid" value="<?php echo h($roomNum); ?>">　
        </div>
        <div class="input-group">
            <input type="text" name="message" id="message" class="form-control ">
            <span class="input-group-append">
                <button type="submit" id="mybutton" class="btn btn-primary">送信</button>
            </span>
        </div>
    </form>
</div>
<!-- /.card-footer-->

<?php require_once('footer.php'); ?>