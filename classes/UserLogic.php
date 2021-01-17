<?php
require_once('dbconnect.php');
require_once('functions.php');

class UserLogic extends Dbc
{
    public $table_name = 'users';
    /**
     * ユーザを登録する
     * @param array $userData
     * @return bool $result
     */
    public  function createUser($userData)
    {
        $result = false;
        $sql = "INSERT INTO $this->table_name (name,email,password) VALUES (?,?,?)";
        // ユーザーデータを配列に入れる
        $arr = [];
        $arr[] = $userData['name'];
        $arr[] = $userData['email']; //email
        $arr[] = password_hash($userData['password'], PASSWORD_DEFAULT); //password

        $pdo = $this->dbConnect();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute($arr);
            $pdo->commit();
            $result = true;
            return $result;
        } catch (\Exception $e) {
            echo $e;
            echo '<br>配列:' . var_export($arr);
            $pdo->rollBack();
            return $result;
        }
    }
    /**
     * ユーザを更新する
     * @param array $userData
     * @return bool $result
     */
    public  function updateUser($userData)
    {
        $result = false;
        $sql = "UPDATE $this->table_name SET gender =:gender, blood_type = :blood_type, birthdate = :birthdate,school_career =:school_career, state = :state, work = :work, hobby = :hobby, personality = :personality,message = :message WHERE user_id =:user_id ";
        $pdo = $this->dbConnect();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':gender', (int)h($userData['gender']), PDO::PARAM_INT);
            $stmt->bindValue(':blood_type', (string)h($userData['blood_type']), PDO::PARAM_STR);
            $stmt->bindValue(':birthdate', (string)h($userData['birthdate']), PDO::PARAM_STR);
            $stmt->bindValue(':state', (string)h($userData['state']), PDO::PARAM_STR);
            $stmt->bindValue(':school_career', (string)h($userData['school_career']), PDO::PARAM_STR);
            $stmt->bindValue(':work', (string) h($userData['work']), PDO::PARAM_STR);
            $stmt->bindValue(':hobby', (string) h($userData['hobby']), PDO::PARAM_STR);
            $stmt->bindValue(':personality', (string)h($userData['personality']), PDO::PARAM_STR);
            $stmt->bindValue(':message', (string)h($userData['message']), PDO::PARAM_STR);
            $stmt->bindValue(':user_id', (int)h($userData['user_id']), PDO::PARAM_INT);

            $stmt->execute();
            $pdo->commit();
            $result = true;
            return $result;
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            $pdo->rollBack();
        }
    }

    /**
     * ログイン処理
     * @param string $email
     * @param string $password
     * @return bool $result
     */
    public static function login($email, $password)
    {
        // 結果
        $result = false;
        //ユーザーをemailから検索して取得
        $user = self::getUserByEmail($email);
        if (!$user) {
            $_SESSION['msg'] = 'メールアドレスが一致しません';
            return $result;
        }
        // パスワードの紹介
        if (password_verify($password, $user['password'])) {
            // ログイン成功
            session_regenerate_id(true); //新しいセッションを作る
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        } else {
            $_SESSION['msg'] = 'パスワードが一致しません';
            return $result;
        };
    }

    /**
     * emailからユーザーを取得
     * @param string $email
     * @return array|bool $user|false
     */
    public static function getUserByEmail($email)
    {
        $pdo = new Dbc();
        // SQLの準備
        $sql = 'SELECT * FROM users WHERE email = ?';
        // emailを配列に入れる
        $arr = [];
        $arr[] = $email;

        try {
            $stmt = $pdo->dbConnect()->prepare($sql);
            $stmt->execute($arr);
            // SQLの実行
            // SQLの結果を返す
            $user = $stmt->fetch();
            return $user;
        } catch (\Exception $e) {
            echo $e;
            return false;
        }
    }

    /**
     * ログイン☑
     * @param void
     * @return bool $result
     */
    public static function checklogin()
    {
        $result = false;
        // セッションにログインユーザーが入っていなかったらfalse
        if (isset($_SESSION['login_user']) && $_SESSION['login_user']['user_id'] > 0) {

            return $result = true;
        }
        return $result;
    }

    /**
     * ログアウト処理
     * @param void
     * @return array $result
     */
    public static function logout()
    {
        $_SESSION = array();
        // セッションを切断するにはセッションクッキーも削除する。
        // Note: セッション情報だけでなくセッションを破壊する。
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
            session_destroy();
        }
    }

    /**
     * プロフィール表示
     * @param string $email
     * @return bool $userData
     */
    public function viewprofile($email)
    {

        // SQLの準備
        $sql = "SELECT * FROM $this->table_name WHERE email = ?";
        $pdo = $this->dbConnect();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, (string)h($email), PDO::PARAM_STR);
            $stmt->execute();
            $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $userData;
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return $e;
        }
    }
    /**
     * プロフィールファイルの保存
     * @param string $filenameファイル名
     * @param string $save_path保存先のパス
     * @param int $user_id 誰の画像か
     * @return bool $result
     */
    public function fileSave($filename, $save_path, $user_id)
    {
        $result = false;

        $sql = "UPDATE $this->table_name SET profile_photo= :profile_photo, profile_path = :profile_path WHERE user_id =:user_id";
        $pdo = $this->dbConnect();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':profile_photo', (string)h($filename), PDO::PARAM_STR);
            $stmt->bindValue(':profile_path', (string)h($save_path), PDO::PARAM_STR);
            $stmt->bindValue(':user_id', (int)h($user_id), PDO::PARAM_INT);
            $stmt->execute();
            $pdo->commit();
            $result = true;
            return $result;
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            $pdo->rollBack();
            return $result;
        }
    }
    /**
     * ファイルデータの取得
     * @param int $user_id 誰の画像か
     * @return array $filedata
     */
    public function viewImg($user_id)
    {
        $sql = "SELECT * FROM images WHERE user_id=?";
        $pdo = $this->dbConnect();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, (string)h($user_id), PDO::PARAM_INT);
            $stmt->execute();
            $filedata =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $filedata;
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return $e;
        }
    }
    /**
     * useridから性別を取得
     * @param int $userid
     * @return int $gender
     */
    public static function getgender($userid)
    {
        $pdo = new Dbc();
        // SQLの準備
        $sql = 'SELECT gender FROM users WHERE user_id = ?';
        // useridを配列に入れる
        $arr = [];
        $arr[] = $userid;

        try {
            $stmt = $pdo->dbConnect()->prepare($sql);
            // SQLの実行
            $row = $stmt->execute($arr);
            // SQLの結果を返す
            while ($row = $stmt->fetch()) {
                return $row['gender'];
            }
        } catch (\Exception $e) {
            echo $e;
            return false;
        }
    }
    /**
     * 異性のデータ取得
     * @param int $gender
     * @return 
     */
    public function getDifferent($gender)
    {
        // データ型変える
        $gender = (int)($gender);
        // 異性の番号を取得
        $differnt_sex = 0;
        if ($gender === 1) {
            $differnt_sex = 2;
        } elseif ($gender === 2) {
            $differnt_sex = 1;
        }

        $sql = "SELECT * FROM users WHERE gender=?";
        $pdo = $this->dbConnect();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, (int)h($differnt_sex), PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return $e;
        }
    }
    /**
     * 異性のid取得
     * @param int $id
     * @return 
     */
    public function getById($id)
    {
        if (empty($id)) {
            exit('idがふせいです');
        }
        $sql = "SELECT * FROM  $this->table_name Where user_id = :id";
        $pdo = $this->dbConnect();
        try {
            $dbh = $this->dbConnect();
            // sqlの準備
            $stmt = $dbh->prepare($sql);
            // プレースホルダーの設定SQLインジェクションを防ぐ
            $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
            // SQLの実行
            $stmt->execute();
            // 結果を取得
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return $e;
        }
    }
    /**
     * 異性の名前取得
     * @param int $id
     * @return 
     */
    public function getByothername($id)
    {
        if (empty($id)) {
            exit('idがふせいです');
        }
        $sql = "SELECT name FROM  $this->table_name Where user_id = :id";
        $pdo = $this->dbConnect();
        try {
            $dbh = $this->dbConnect();
            // sqlの準備
            $stmt = $dbh->prepare($sql);
            // プレースホルダーの設定SQLインジェクションを防ぐ
            $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
            // SQLの実行
            $stmt->execute();
            // 結果を取得
            while ($row = $stmt->fetch()) {
                return $row['name'];
            }
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return $e;
        }
    }
        /**
     * 異性の名前取得
     * @param int $id
     * @return 
     */
    public function getByotherimage($id)
    {
        if (empty($id)) {
            exit('idがふせいです');
        }
        $sql = "SELECT profile_path FROM  $this->table_name Where user_id = :id";
        $pdo = $this->dbConnect();
        try {
            $dbh = $this->dbConnect();
            // sqlの準備
            $stmt = $dbh->prepare($sql);
            // プレースホルダーの設定SQLインジェクションを防ぐ
            $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
            // SQLの実行
            $stmt->execute();
            // 結果を取得
            while ($row = $stmt->fetch()) {
                return $row['profile_path'];
            }
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return $e;
        }
    }
        /**
     * emailがDBにあるかチェック
     * @param string $email
     * @return 
     */
    public function checkEmail($email)
    {
        $result = false;
        $sql = "SELECT email FROM  $this->table_name Where email = :email";
        $pdo = $this->dbConnect();
        try {
            $dbh = $this->dbConnect();
            // sqlの準備
            $stmt = $dbh->prepare($sql);
            // プレースホルダーの設定SQLインジェクションを防ぐ
            $stmt->bindValue(':email', (string)$email, \PDO::PARAM_STR);
            // SQLの実行
            $stmt->execute();
            // 結果を取得
            while ($row = $stmt->fetch()) {
                return $row['email'];
            }           
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return $result;
        }
    }
          /**
     * ログイン判定
     * @param string $email
     * @return string $row['login']
     */
    public function judglogin($email)
    {
        $sql = "SELECT login FROM  $this->table_name Where email = :email";
        $pdo = $this->dbConnect();
        try {
            $dbh = $this->dbConnect();
            // sqlの準備
            $stmt = $dbh->prepare($sql);
            // プレースホルダーの設定SQLインジェクションを防ぐ
            $stmt->bindValue(':email', (string)$email, \PDO::PARAM_STR);
            // SQLの実行
            $stmt->execute();
            // 結果を取得
            while ($row = $stmt->fetch()) {
                return $row['login'];
            }           
        } catch (\Exception $e) {
           return $e->getMessage();
        }
    }
        /**
     * ログイン更新
     * @param string $email
     * @return 
     */
    public function updatelogin($email)
    {
        $result = false;
        $sql = "UPDATE $this->table_name SET login = 1 WHERE email = :email";
        $pdo = $this->dbConnect();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            // プレースホルダーの設定SQLインジェクションを防ぐ
            $stmt->bindValue(':email', (string)$email, \PDO::PARAM_STR);
            // SQLの実行
            $stmt->execute();
            $pdo->commit();
            $result = true;
            return $result;
        } catch (\Exception $e) {
            echo $e->getMessage();
            $pdo->rollBack();
            return $result;
        }
    }
}
