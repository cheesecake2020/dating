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
$login_user = $_SESSION['login_user'];
$user = new UserLogic;
// ゲットの値受け取り
if(isset($_GET['id'])){
    $otherid=$_GET['id'];
}
// 配列の用意
$otherusers = [];
$otherusers[] = $user->getById($otherid);
$like = new LikeLogic;
$islike = $like->ckeckLike($login_user['user_id'], $otherid);
require_once('header.php');
require_once('navmenu.php');
// echo "<pre>";
// var_dump($otherimages);
// echo "<pre>";
?>
<main>
    <h2>プロフィール</h2>
    <?php foreach ($otherusers as $user) : ?>
        <img src="<?php echo h($user['profile_path']); ?>" alt="プロフィール写真" width="100px">

        <form  method="POST" id="likeform">
            <input type="hidden" name="csrf_token" value="<?php echo h(setToken()); ?>">　
            <input type="hidden"  name="userid" value="<?php echo h($login_user['user_id']);?>">
            <!--  いいねの挙動-->
            <?php if ($islike === false) : ?>
                <input type="hidden"  name="like" value="<?php echo h($otherid);?>">　
                <button class="nolike" type="submit"><i class="far fa-paper-plane"></i>いいねを送る</button>
            <?php else : ?><!--  いいねの挙動-->
                <input type="hidden" name="like_delete" value="<?php echo h($otherid);?>">　
                <button class="like" type="submit"><i class="fas fa-heart"></i>いいねを送りました</button>
            <?php endif; ?>
        </form>

        <p>ユーザー名：<?php echo h($user['name']); ?></p>
        <p>性別：<?php echo setGender($user['gender']); ?></p>
        <p>誕生日：<?php echo h($user['birthdate']); ?></p>
        <p>年齢：<?php echo getAge($user['birthdate']); ?>歳</p>
        <p>居住地：<?php echo getState($user['state'], $states); ?></p>
        <p>趣味：<?php echo h($user['hobby']); ?></p>
        <p>性格：<?php echo h($user['personality']); ?></p>
    <?php endforeach; ?>


    <button><a href="search.php">戻る</a></button>
</main>
<?php require_once('footer.php'); ?>