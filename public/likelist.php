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
$like = new LikeLogic;
$getlikes = $like->getLike($login_user['user_id']);
$title='いいね一覧';
require_once('header.php');
require_once('navmenu.php');


?>
<main>
    <?php if(empty($getlikes)):?>
        <p>まだいいねがきていません</p>
        <?php else:?>
    <!-- いいねした人を表示する -->
    <?php foreach($getlikes as $like):?>
        <div class="flex">
            <!-- プロフィールのリンク -->
            <a href="other_page.php?id=<?php echo h($like['user_id']);?>">
            <img class="likeimg" src="<?php echo h($like['profile_path']);?>" alt="異性の写真" >
            </a>
            <div class="item">
                <p><?php echo h($like['name']);?>さん<br class="br">からいいねがありました。</p>
                <time><?php echo h($like['created_at']);?></time>
            </div>
        </div>
        <?php endforeach;?>
        <?php endif;?>

</main>
<?php require_once('footer.php');?>