<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../classes/UserLogic.php');
require_once('../classes/LikeLogic.php');
require_once('../classes/functions.php');
ini_set('display_errors', "On");
// ログインしているか判定、していなかったら新規登録画面へ返す
$result = UserLogic::checklogin();
if (!$result) {
    $_SESSION['login_err'] = 'ユーザーを登録してログインしてください';
    header('Location:http://localhost:8889/dating_app/public/signup_form.php');
    return;
}
require_once('header.php');
$like = new LikeLogic;
$login_user = $_SESSION['login_user'];
$token = filter_input(INPUT_POST, 'csrf_token');

// トークンがない、もしくは一致しない場合処理を中止
if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
    exit('不正なリクエストです');
}
unset($_SESSION['csrf_token']); //トークン削除

// 値のバリデーション
if (!$likeid = filter_input(INPUT_POST, 'like')) {
    $err1 = '送信に失敗しました';
}
if (!$deleteid = filter_input(INPUT_POST, 'like_delete')) {
    $err2 = '送信に失敗しました';
}

// エラーがない&いいねか削除判定
if (!isset($err1) && $_POST['like']) {
    // いいねをDBに入れる
    $result = $like->sendLike($login_user['user_id'], $likeid);
    //    echo'成功しました';
}
if (!isset($err2) && $_POST['like_delete']) {
    //いいねをDBから消す
    $result = $like->DeleteLike($login_user['user_id'], $deleteid);
    //    echo'取り消しました';
}
