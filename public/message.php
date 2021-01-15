<?php
session_start();
require_once('../classes/UserLogic.php');
require_once('../classes/ChatLogic.php');
ini_set('display_errors', "On");
$chat = new ChatLogic;
$login_user = $_SESSION['login_user'];
$token = filter_input(INPUT_POST, 'csrf_token');
// トークンがない、もしくは一致しない場合処理を中止
if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
    exit('不正なリクエストです');
}
unset($_SESSION['csrf_token']);
// バリデーション
if (!$message = filter_input(INPUT_POST, 'message')) {
    header('Location:http://localhost:8889/dating_app/public/chatlist.php');
}
if (!$roomid = filter_input(INPUT_POST, 'roomid')) {
    header('Location:http://localhost:8889/dating_app/public/chatlist.php');
}

if(!empty($message)){
   $chat->createMsg($login_user['user_id'],$roomid,$message);
}else{
    echo 'エラー';
}