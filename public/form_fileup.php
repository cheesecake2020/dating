<?php
session_start();
require_once('../classes/UserLogic.php');
require_once('../classes/functions.php');
ini_set('display_errors', "On");
$login_user = $_SESSION['login_user'];


?>
<!-- ①フォームの説明 -->
<!-- ②$_FILEの確認 -->
<!-- ③バリデーション -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>アップロードフォーム</title>
    <link rel="stylesheet" href="../lib/style.css">
</head>

<body>
    <main>
        <h1>プロフィール写真</h1>
        <form enctype="multipart/form-data" action="check_fileup.php" method="POST">

            <label class="file-up">写真を選択してください
                <input type="hidden" name="MAX_FILE_SIZE" value="32768" />
                <input name="img" type="file" accept="image/*" />
            </label>
            <button type="submit">送信</button>
        </form>
        <div>
            <?php foreach ($files as $file) : ?>

                <img src="<?php echo h($file['file_path']); ?>" alt="">
                <p><?php echo h($file['description']); ?></p>
            <?php endforeach; ?>
        </div>

    </main>
</body>

</html>