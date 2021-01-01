<?php
session_start();
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
// 配列の用意
$otherusers = [];
$otherusers[] = $user->getById($_GET['id']);
$like =new LikeLogic;
$islike = $like->ckeckLike($login_user['user_id'],$_GET['id']);

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
        
        <form action="#" method="post" id="form">　
            <!--  いいねの挙動-->
            <?php if($islike=== false || $islike === 0):?>
                <?php echo'<button type="submit"><i class="far fa-paper-plane"></i>いいねを送る</button>';?>
                <?php else:?>
                    <?php echo '<button class="like" type="submit"><i class="fas fa-heart"></i>いいねを送りました</button>';?>
            <?php endif;?>
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
<?php require_once('footer.php');?>

