<?php
session_start();
require_once('../classes/UserLogic.php');
ini_set('display_errors', "On");
$result = UserLogic::checklogin();
if($result){
    header('Location:http://localhost:8889/dating_app/public/mypage.php');
    return;
}
// エラーメッセージ
$err = [];

// バリデーション
if (!$email = filter_input(INPUT_POST, 'email')) {
    $err['email'] = 'メールアドレスを記入してください';
}
if (!$password = filter_input(INPUT_POST, 'password')) {
    $err['password'] = 'パスワードを記入してください';
};

// ログインする処理
if (count($err) > 0) {
    // エラーがあった場合は戻す
    $_SESSION = $err;
    header('Location:http://localhost:8889/dating_app/public/login_form.php');
    return;
}
// ログイン成功時の処理
$result = UserLogic::login($email, $password);
// ログイン失敗時の処理
if (!$result) {
    header('Location:http://localhost:8889/dating_app/public/login_form.php');
    return;
} 
require_once('header.php');

?>

<body>
    <main>
        <h2>ログイン完了</h2>
        <p>ログインしました！</p>
        <a href="editprofile.php">プロフィール作成</a>
    </main>
    <?php require_once('footer.php');?>