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
$title='マイページ編集';
require_once('header.php');
require_once('navmenu.php');
?>
    <main>
       
            <h2>マイページ</h2>
       

        <form action="check_profile.php" method="POST" id="form">
            <input type="hidden" name="user_id" value="<?php echo  h($login_user['user_id']); ?>">
            <div class="form-control">
                <p>お名前：<?php echo h($login_user['name']); ?></p>
            </div>
            <?php foreach ($userdata as $user) : ?>
            <div class="form-control">
                <?php if($user['profile_path']===''):?>
                    <p>写真が設定されていません</p>
                    <?php else:?>
                <img class="img"src="<?php echo $user['profile_path']; ?>" alt="プロフィール写真">
                <?php endif;?>
                <a href="form_fileup.php">写真を編集する</a>
            </div>
            <div class="form-control">
                    <label for="gender" class="type">性別 </label>
                        <input type="radio" value="1" name="gender" <?php if($user['gender'] === '1'){echo "checked";}  ?> required>男性
                        <input type="radio" value="2" name="gender" <?php if($user['gender'] === '2') {echo "checked";}?> required>女性
                        <?php if (!$gender) : ?>
                            <p class="err"><?php echo $error['gender']; ?></p>
                        <?php endif; ?>
                   
            </div>
            <div class="form-control">
                <label for="blood_type">血液型
                    <select name="blood_type" id="blood_type">
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
                </label>
            </div>
            <div class="form-control">
                <label for="birthdate">誕生日
                    <input type="date" id="birthdate" name="birthdate" value="<?php echo $user['birthdate']; ?>" max="2002-12-20">
                </label>
                <?php if (!$birthdate) : ?>
                    <p class="err"><?php echo  $error['birthdate']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-control">
                <label for="state">居住地
                    <select name="state" id="state">
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
                </label>
            </div>
            <div class="form-control">
                <label for="school_career">学歴
                    <select name="school_career" id="school_career">
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
                </label>
            </div>
            <div class="form-control error">
                <label for="work">職業
                    <select name="work" id="work">
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
                </label>
            </div>
            <div class="form-control">
                <label for="hobby">趣味
                    <input type="text" name="hobby" id="hobby" value="<?php echo h($user['hobby']); ?>" required>
                    <?php if (!$hobby) : ?>
                        <p class="err"><?php echo  $error['hobby']; ?></p>
                    <?php endif; ?>
                </label>
            </div>
            <div class="form-control">
                <label for="personality">性格
                    <input type="text" name="personality" id="personality" value="<?php echo h($user['personality']); ?>" required>
                    <?php if (!$personality) : ?>
                        <p class="err"><?php echo  $error['personality']; ?></p>
                    <?php endif; ?>
                </label>
            </div>
            <div class="form-control error">
                <label for="message">メッセージ </label>
                <textarea name="message" cols="30" rows="10" id="message" required><?php echo h($user['message']); ?></textarea>
                <?php if (!$message) : ?>
                    <p class="err"><?php echo  $error['message']; ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <button type="submit" name="register">送信</button>
        </form>
        <a href="mypage.php">戻る</a>

        <form action="logout.php" method="POST">
        <input type="submit" value="ログアウト" name="logout">

        </form>
    </main>
    <?php require_once('footer.php');?>