<?php
session_start();
require_once('../classes/UserLogic.php');
$user = new UserLogic;
// 送信されていたら
if(isset($_POST["reset-password"])||$_POST["reset-password"]){
    $err = [];
    // バリデーション
    $token = filter_input(INPUT_POST, 'csrf_token');
    // トークンがない、もしくは一致しない場合処理を中止
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        $err['csrf']='不正なリクエストです';
        exit();
    }
    if (!$email = filter_input(INPUT_POST, 'email')) {
        $err['email'] = 'メールアドレスを入力してください';
    }
    // メールを送る処理
    if (empty($err)) {
        $checkEmail = $user->checkEmail($email);
        $passResetToken = md5(uniqid(rand(),true));
        $text='メールを送信しました';
    }else{
     // エラーがあった場合は戻す
    header('Location:http://localhost:8889/dating_app/public/password_reset.php');
    }

}else{
    header('Location:http://localhost:8889/dating_app/public/login_form.php');
}
var_dump($checkEmail);
var_dump($passResetToken);