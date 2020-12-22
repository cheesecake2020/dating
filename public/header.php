<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マッチングサイト</title>
</head>
<body>
    
<header>
    <nav>
    <div class="logo">
        <a href="#">カップリン<span>グ．</span></a>
    </div>
            <ul class="menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#product">product</a></li>
                <li><a href="#contact">contact</a></li>
            </ul>
            <div>
            <form action="login.php" method="POST">
    <div>
    <label for="email">メールアドレス：<input type="email" name="email"></label>
    <?php if(isset($err['email'])):?>
        <p class="err"><?php echo $err['email'];?></p>
    <?php endif;?>

    </div>
    <div>
    <label for="password">パスワード：<input type="password" name="password"></label>
    <?php if(isset($err['password'])):?>
        <p class="err"><?php echo $err['password'];?></p>
    <?php endif;?>
    </div>
    <button type="submit">ログイン</button>
    </form>
    <form action="register.php" method="POST">
    <div>
    <label for="username">お名前：<input type="text" name="username"></label>
    </div>
    <div>
    <label for="email">メールアドレス：<input type="email" name="email"></label>
    </div>
    <div>
    <label for="password">パスワード：<input type="password" name="password"></label>
    </div>
    <div>
    <label for="password_conf">パスワード確認：<input type="password" name="password_conf"></label>
    </div>
    <input type="hidden" name="csrf_token" value="<?php echo h(setToken());?>">
    <button type="submit">新規登録</button>
            </div>
    </nav>
</header>