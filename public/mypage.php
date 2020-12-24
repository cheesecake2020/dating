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


?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../lib/style.css">
    <title>マイページ</title>
</head>

<body>
    <main>
        <h2>マイページ</h2>
        <p>ログインユーザー：<?php echo h($login_user['name']); ?></p>
        <p>メールアドレス：<?php echo h($login_user['email']); ?></p>
        <p>プロフィール写真:未設定</p>
        <?php foreach ($userdata as $val) : ?>
            <p>性別：<?php echo setGender($val['gender']); ?></p>
            <p>誕生日：<?php echo $val['birthdate']; ?></p>
            <p>年齢：<?php echo getAge($val['birthdate']); ?>歳</p>
            <p>居住地：<?php echo getState($val['state'],$states);?></p>
            <p>趣味：<?php echo$val['hobby'];?></p>
            <p>性格：<?php echo$val['personality'];?></p>



        <?php endforeach; ?>


        <p><a href="editprofile.php">プロフィール</a>を編集しますか？</p>
        <form action="logout.php" method="POST">
            <button type="submit" >ログアウト</button>
        
        </form>
        </main>
</body>

</html>