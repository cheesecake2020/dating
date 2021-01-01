<?php
session_start();
require_once('../classes/UserLogic.php');
if(!$logout =filter_input(INPUT_POST,'logout'))
{
    exit('不正なリクエストです');
}
ini_set('display_errors',"On");
// ログインしているか判定、セッションが切れていたらログインしてくださいとメッセージをだす
$result = UserLogic::checklogin();

if(!$result){
    exit('セッションが切れましたので、ログインし直してください');
}

// ログアウトする
UserLogic::logout();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>ログアウト</title>
</head>
<body>
    <main>
        <h2>ログアウト完了</h2>
        <p>ログアウトしました！</p>
        <a href="login_form.php">ログイン画面へ</a>
        
    </main>
    <?php require_once('footer.php');?>