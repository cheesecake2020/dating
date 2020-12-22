<?php
session_start();
require_once('../classes/UserLogic.php');
require_once('../classes/functions.php');
$login_user = $_SESSION['login_user'];
ini_set('display_errors', "On");
$userData = $_POST;
$user =new UserLogic;
// ----------未入力チェック----------/
$error=[];
    if (!$gender = filter_input(INPUT_POST, 'gender')) {
        $error['gender'] = '性別を選択してください';
    };
    if (!$blood_type = filter_input(INPUT_POST, 'blood_type')) {
        $error['blood_type'] = '血液型を選択してください';
    };
    if (!$birthdate = filter_input(INPUT_POST, 'birthdate')) {
        $error['birthdate'] = '誕生日を入力してください';
    };
    if (!$state = filter_input(INPUT_POST, 'state')) {
        $error['state'] = '居住地を選択してください';
    };
    if (!$school_career = filter_input(INPUT_POST, 'school_career')) {
        $error['school_career'] = '学歴を選択してください';
    };
    if (!$work = filter_input(INPUT_POST, 'work')) {
        $error['work'] = '職業を選択してください';
    };
    if (!$hobby = filter_input(INPUT_POST, 'hobby')) {
        $error['hobby'] = '趣味を入力してください';
    };
    if (!$personality = filter_input(INPUT_POST, 'personality')) {
        $error['personality'] = '性格を入力してください';
    };
    if (!$message = filter_input(INPUT_POST, 'message')) {
        $error['message'] = 'メッセージを入力してください';
    };
    // 空の連想配列は削除する
    $judge=array_filter($error);
    // var_dump($userData);
    // エラーがなかったら更新
    if(empty($judge)){
        // データベース更新
        $user->updateUser($userData);
        include('ok_profile.php');
    }else{
        include('editprofile.php');

    }

?>

