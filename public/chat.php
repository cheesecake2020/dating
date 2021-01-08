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
$userdata = $user->viewprofile($login_user['email']);
$userimg = $user->viewImg($login_user['user_id']);
$title = 'マイページ';
require_once('header.php');
require_once('navmenu.php');
?>
<!-- DIRECT CHAT -->

<section class="mymain">

    <div class="container">
    
        <div class="chat-right mb-3">
            <img class="chatimg  ml-3" src="../images/right.jpg" alt="ユーザー写真">
            <div class="chat">
                <p class="msg-right mb-0">メッセージ</p>
                <time>1/1</time>
            </div>
        </div>
        <p class="mb-0"> ユーザー名</p>
        <div class="chat-left mb-3 ">
            <img class="chatimg mr-3" src="../images/nezuko.png" alt="相手写真">
            <div class="chat">
                <p class="msg-left mb-0">メッセージ2</p>
                <time>1/1</time>
            </div>
        </div>
        <div class="chat-right mb-3">
            <img class="chatimg  ml-3" src="../images/right.jpg" alt="ユーザー写真">
            <div class="chat">
                <p class="msg-right mb-0">メッセージ</p>
                <time>1/1</time>
            </div>
        </div>
     
        <p class="mb-0"> ユーザー名</p>
        <div class="chat-left mb-3 ">
            <img class="chatimg mr-3" src="../images/nezuko.png" alt="相手写真">
            <div class="chat">
                <p class="msg-left mb-0">メッセージ2</p>
                <time>1/1</time>
            </div>
        </div>
        <div class="chat-right mb-3">
            <img class="chatimg  ml-3" src="../images/right.jpg" alt="ユーザー写真">
            <div class="chat">
                <p class="msg-right mb-0">メッセージ</p>
                <time>1/1</time>
            </div>
        </div>
     
    </div>
</section>

<!-- /.card-body -->
<div class="card-footer">
    <form action="#" method="post">
        <div class="input-group">
            <input type="text" name="message" placeholder="Type Message ..." class="form-control">
            <span class="input-group-append">
                <button type="button" class="btn btn-primary">Send</button>
            </span>
        </div>
    </form>
</div>
<!-- /.card-footer-->
</div>
<!--/.direct-chat -->
<?php require_once('footer.php'); ?>