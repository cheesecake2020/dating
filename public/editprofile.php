<?php
session_start();
require_once('../classes/UserLogic.php');
require_once('../classes/functions.php');
ini_set('display_errors', "On");
$login_user = $_SESSION['login_user'];
error_reporting(E_ALL & ~E_NOTICE);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../lib/style.css">
    <title>マイページ</title>
</head>

<body>
    <main>
        <header>
            <h2>マイページ</h2>
        </header>

        <form action="check_profile.php" method="POST" id="form">
            <input type="hidden" name="user_id" value="<?php echo  h($login_user['user_id']); ?>">
            <div class="form-control">
                <p>お名前：<?php echo h($login_user['name']); ?></p>
            </div>
            <div class="form-control">
                <p>プロフィール写真：<a href="">未設定</a></p>
            </div>
            <div class="form-control">
                <label for="gender" class="type">性別
                    <input type="radio" value="1" name="gender" required>男性
                    <input type="radio" value="2" name="gender" required>女性
                    <?php if (!$gender) : ?>
                        <p class="err"><?php echo $error['gender']; ?></p>
                    <?php endif; ?>
                </label>
            </div>
            <div class="form-control">
                <label for="blood_type">血液型
                    <select name="blood_type" id="blood_type">
                        <?php foreach ($blood_types as $key => $val) : ?>
                            <option value="<?php echo h($key); ?>" ><?php echo h($val); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!$blood_type) : ?>
                        <p class="err"><?php echo $error['blood_type']; ?></p>
                    <?php endif; ?>
                </label>
            </div>
            <div class="form-control">
                <label for="birthdate">誕生日
                    <input type="date" id="birthdate" name="birthdate" value="1990-01-01" max="2002-12-20">
                </label>
                <?php if (!$birthdate) : ?>
                    <p class="err"><?php echo  $error['birthdate']; ?></p>
                <?php endif; ?>
            </div>
            <div class="form-control">
                <label for="state">居住地
                    <select name="state" id="state">
                        <?php foreach ($states as $key => $val) : ?>
                            <option value="<?php echo h($key); ?>" name="state"><?php echo h($val); ?></option>
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
                            <option value="<?php echo h($key); ?>" name="school_career"><?php echo h($val); ?></option>
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
                            <option value="<?php echo h($key); ?>"><?php echo h($val); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!$work) : ?>
                        <p class="err"><?php echo  $error['work']; ?></p>
                    <?php endif; ?>
                </label>
            </div>
            <div class="form-control">
                <label for="hobby">趣味
                    <input type="text" name="hobby" id="hobby" value="<?php echo h($hobby); ?>"required>
                    <?php if (!$hobby) : ?>
                        <p class="err"><?php echo  $error['hobby']; ?></p>
                    <?php endif; ?>
                </label>
            </div>
            <div class="form-control">
                <label for="personality">性格
                    <input type="text" name="personality" id="personality" value="<?php echo h($personality); ?>" required>
                    <?php if (!$personality) : ?>
                        <p class="err"><?php echo  $error['personality']; ?></p>
                    <?php endif; ?>
                </label>
            </div>
            <div class="form-control error">
                <label for="message">メッセージ </label>
                <textarea name="message" cols="30" rows="10" id="message" required><?php echo h($message); ?></textarea>
                <?php if (!$message) : ?>
                    <p class="err"><?php echo  $error['message']; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" name="register">送信</button>
        </form>


        <form action="logout.php" method="POST">
            <button type="submit" name="logout">ログアウト</button>

        </form>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../lib/validator.js"></script>
</body>

</html>