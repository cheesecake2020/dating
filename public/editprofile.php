<?php
if (!isset($_SESSION)) {
    session_start();
}
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
error_reporting(E_ALL & ~E_NOTICE);
$user = new UserLogic;
$userdata = $user->viewprofile($login_user['email']);
$title = 'マイページ編集';
require_once('header.php');
require_once('navmenu.php');
?>
<main>

    <h2>マイページ</h2>


    <form action="check_profile.php" method="POST" id="form">
        <input type="hidden" name="user_id" value="<?php echo  h($login_user['user_id']); ?>">
        <div>
            <p>お名前：<?php echo h($login_user['name']); ?></p>
        </div>
        <?php foreach ($userdata as $user) : ?>
            <div class="form-group">
                <?php if (empty($user['profile_path'])) : ?>
                    <p>写真が設定されていません</p>
                <?php else : ?>
                    <img class="img" src="<?php echo $user['profile_path']; ?>" alt="プロフィール写真">
                <?php endif; ?>
                <a href="form_fileup.php">写真を編集する</a>
            </div>

            <div class="flex">性別  
            <div class="form-check form-check-inline">
                <input class="form-check-input"  type="radio" name="gender" value="1"
                <?php if ($user['gender'] === '1') {echo "checked";}  ?> required>
                <label class="form-check-label" for="gender">男性</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input"  type="radio" name="gender" value="2"
                <?php if ($user['gender'] === '2') {echo "checked";} ?> required>
                <label class="form-check-label" for="gender">女性</label>
            </div>
            </div>
                <?php if (!$gender) : ?>
                    <p class="err"><?php echo $error['gender']; ?></p>
                <?php endif; ?>

            </div>
            <div class="form-group">
                <label for="blood_type">血液型</label>
                <select name="blood_type" id="blood_type" class="form-control">
                    <?php foreach ($blood_types as $key => $val) : ?>
                        <!-- データベースと一致していたらセレクトする -->
                        <?php ($key === $user['blood_type']) ? $select = 'selected' : $select = ''; ?>
                        <option value="<?php echo h($key); ?>" <?php echo $select; ?>>
                            <?php echo h($val); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!$blood_type) : ?>
                    <p class="err"><?php echo $error['blood_type']; ?></p>
                <?php endif; ?>

            </div>
            <div class="form-group">
                <label for="birthdate">誕生日</label>
                <input class="form-control" type="date" id="birthdate" name="birthdate" value="<?php echo $user['birthdate']; ?>" max="2002-12-20">
                <?php if (!$birthdate) : ?>
                    <p class="err"><?php echo  $error['birthdate']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="state">居住地</label>
                <select name="state" id="state" class="form-control">
                    <?php foreach ($states as $key => $val) : ?>
                        <?php ($key === $user['state']) ? $select = 'selected' : $select = ''; ?>
                        <option value="<?php echo h($key); ?>" name="state" <?php echo $select; ?>>
                            <?php echo h($val); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!$state) : ?>
                    <p class="err"><?php echo  $error['state']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="school_career">学歴</label>
                <select name="school_career" id="school_career" class="form-control">
                    <?php foreach ($school as $key => $val) : ?>
                        <?php ($key === $user['school_career']) ? $select = 'selected' : $select = ''; ?>
                        <option value="<?php echo h($key); ?>" name="school_career" <?php echo $select; ?>>
                            <?php echo h($val); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!$school_career) : ?>
                    <p class="err"><?php echo  $error['school_career']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="work">職業</label>
                <select name="work" id="work" class="form-control">
                    <?php foreach ($works as $key => $val) : ?>
                        <?php ($key === $user['work']) ? $select = 'selected' : $select = ''; ?>
                        <option value="<?php echo h($key); ?>" <?php echo $select; ?>>
                            <?php echo h($val); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!$work) : ?>
                    <p class="err"><?php echo  $error['work']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="hobby">趣味</label>
                <input class="form-control" type="text" name="hobby" id="hobby" value="<?php echo h($user['hobby']); ?>" required>
                <?php if (!$hobby) : ?>
                    <p class="err"><?php echo  $error['hobby']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="personality">性格</label>
                <input class="form-control" type="text" name="personality" id="personality" value="<?php echo h($user['personality']); ?>" required>
                <?php if (!$personality) : ?>
                    <p class="err"><?php echo  $error['personality']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="message">メッセージ </label>
                <textarea class="form-control" name="message" cols="30" rows="10" id="message" required><?php echo h($user['message']); ?></textarea>
                <?php if (!$message) : ?>
                    <p class="err"><?php echo  $error['message']; ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div class="flex">
            <button type="submit" name="register" class="btn btn-primary">送信</button>
        </form>
        <a href="mypage.php" class="btn btn-primary">戻る</a>
        <form action="logout.php" method="POST">
            <input type="submit" class="btn btn-primary" value="ログアウト" name="logout">
        </form>

        </div>
</main>
<?php require_once('footer.php'); ?>