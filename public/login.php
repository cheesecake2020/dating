<?php
session_start();
require_once('../classes/UserLogic.php');
ini_set('display_errors', "On");
// if(empty($_SERVER["HTTPS"])){
//     $sever="http://";  
// }else{
//     $sever="https://";
// }
$result = UserLogic::checklogin();
if ($result) {
    header('Location:'.$sever.$_SERVER['HTTP_HOST'].'/public/mypage.php');
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
    header('Location:'.$sever.$_SERVER['HTTP_HOST'].'/public/login_form.php');
    return;
}
// ログイン成功時の処理
$result = UserLogic::login($email, $password);
// ログイン失敗時の処理
if (!$result) {
    header('Location:'.$sever.$_SERVER['HTTP_HOST'].'/public/login_form.php');
    return;
}
$user = new UserLogic;
$decision = $user->judglogin($email);
$title = 'ログイン';
require_once('header.php');
// 初回ログインはプロフィール作成
if ($decision === '0') :
    $updatelogin = $user->updatelogin($email);
?>
    <main>
        <h2>ログイン完了</h2>
        <p>ログインしました！</p>
        <a href="editprofile.php">プロフィール作成</a>
    </main>
    <!-- 2回目以降は異性一覧 -->
<?php else :
    include('search.php'); ?>
<?php endif;
require_once('footer.php'); ?>