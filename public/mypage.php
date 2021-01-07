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
$title='マイページ';
require_once('header.php');
require_once('navmenu.php');
?>
<main>
    <h2>マイページ</h2>
    <?php foreach ($userdata as $user) : ?>
        <?php if (empty($user['profile_path'])) : ?>
            <img  src="../lib/nophoto.svg" alt="デフォルトアカウント写真" >
        <?php else : ?>
            <img class="img"src="<?php echo h($user['profile_path']); ?>" alt="プロフィール写真" >
        <?php endif; ?>

        <p>ユーザー名：<?php echo h($login_user['name']); ?></p>
        <p>性別：<?php echo setGender($user['gender']); ?></p>
        <p>誕生日：<?php echo $user['birthdate']; ?></p>
        <p>年齢：<?php echo getAge($user['birthdate']); ?>歳</p>
        <p>血液型：<?php echo getBlood($user['blood_type'], $blood_types); ?>型</p>
        <p>居住地：<?php echo getState($user['state'], $states); ?></p>
        <p>職業：<?php echo getWork($user['work'], $works); ?></p>
        <p>最終学歴：<?php echo getSchool($user['school_career'], $school); ?></p>
        <p>趣味：<?php echo $user['hobby']; ?></p>
        <p>性格：<?php echo $user['personality']; ?></p>
        <p>メッセージ：<br class="br"><?php echo $user['message']; ?></p>




    <?php endforeach; ?>

    <button class="btn btn-outline-primary mb-3"><a href="editprofile.php">プロフィールを編集</a></button>

    <form action="logout.php" method="POST">
        <input class="btn btn-primary"type="submit" value="ログアウト" name="logout">
    </form>


</main>
<?php require_once('footer.php'); ?>