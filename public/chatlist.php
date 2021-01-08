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
$title='マッチング一覧';
require_once('header.php');
require_once('navmenu.php');
$matchid=$like->Matchid($login_user['user_id']);
$val=implode(',',$matchid);
$matchusers=$like->MatchUser($val);
// echo'<pre>';
// var_dump($matchusers);
// echo'</pre>';
?>
<main>
<?php if($matchusers=== false):?>
        <p>まだいいねがきていません</p>
        <?php else:?>
    <!-- いいねした人を表示する -->
    <?php foreach($matchusers as $user):?>
        <div class="flex">
            <!-- プロフィールのリンク -->
            <a href="chat.php?id=<?php echo h($user['user_id']);?>">
            <img class="likeimg" src="<?php echo h($user['profile_path']);?>" alt="異性の写真" >
            </a>
            <div class="item">
                <p><?php echo h($user['name']);?>さん<br class="br">とマッチングしました。</p>
            </div>
        </div>
        <?php endforeach;?>
        <?php endif;?>

</main>
<?php require_once('footer.php');?>