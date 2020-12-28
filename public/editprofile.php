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
// var_dump($userdata);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../lib/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
    <title>マイページ</title>
</head>

<body>
<?php
require_once('navmenu.php');
?>
    <main>
       
            <h2>マイページ</h2>
       

        <form action="check_profile.php" method="POST" id="form">
            <input type="hidden" name="user_id" value="<?php echo  h($login_user['user_id']); ?>">
            <div class="form-control">
                <p>お名前：<?php echo h($login_user['name']); ?></p>
            </div>
            <div class="form-control">
                <p>プロフィール写真：<a href="form_fileup.php">未設定</a></p>
            </div>
            <div class="form-control">
                <?php foreach ($userdata as $user) : ?>
                    <label for="gender" class="type">性別
                        <input type="radio" value="1" name="gender" checked=" <?php if ($user['gender'] === 1) echo "checked"; ?>" required>男性
                        <input type="radio" value="2" name="gender" checked="<?php if ($user['gender'] === 2) echo "checked"; ?>" required>女性
                        <?php if (!$gender) : ?>
                            <p class="err"><?php echo $error['gender']; ?></p>
                        <?php endif; ?>
                    </label>
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
            <button type="submit" name="logout">ログアウト</button>

        </form>
    </main>
<script src="../lib/script.js"></script>
</body>

</html>