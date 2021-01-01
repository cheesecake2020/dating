<?php
session_start();
require_once('../classes/UserLogic.php');
ini_set('display_errors',"On");
// エラーメッセージ
$err = [];
$user =new UserLogic;
$token =filter_input(INPUT_POST,'csrf_token');
// トークンがない、もしくは一致しない場合処理を中止
if(!isset($_SESSION['csrf_token']) || $token !==$_SESSION['csrf_token']){
    exit('不正なリクエストです');
}
unset($_SESSION['csrf_token']);
// バリデーション
if(!$username=filter_input(INPUT_POST,'name')){
    $err[]='ユーザー名を記入してください';
}
if(!$email=filter_input(INPUT_POST,'email')){
    $err[]='メールアドレスを記入してください';
}
$password = filter_input(INPUT_POST,'password');
// 正規表現：半角英数字を8文字以上100文字以下
if(!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)){
    $err[]='パスワードは英数字を8文字以上100文字以下にしてください';
}
$password_conf = filter_input(INPUT_POST,'password_conf');
if($password !== $password_conf ){
    $err[]='確認用パスワードと異なっています。';
}
// エラーが０だったらユーザー登録をする
if(count($err)===0){
    $hasCreated = $user->createUser($_POST);

    if(!$hasCreated){
        $err[]='登録に失敗しました。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>ユーザー登録確認画面</title>
</head>
<body>
    <main>
        <h2>登録確認画面</h2>
    <?php if(count($err)>0):?>
        <?php foreach($err as $e) :?>
            <p class="err"><?php echo $e;?></p>
        <?php endforeach;?>
        <?php else:?>
        <p>ユーザー登録が完了しました</p>
        <?php endif;?>
        <a href="signup_form.php">戻る</a>
    </main>
    <?php require_once('footer.php');?>