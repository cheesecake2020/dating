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
     * @return bool $user
     */
    public function viewprofile($email)
    {
       
        // SQLの準備
        $sql = "SELECT * FROM $this->table_name WHERE email = ?";
        $pdo = $this->dbConnect();
        $pdo->beginTransaction();
       
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, (string)h($email), PDO::PARAM_STR);

            $stmt->execute();
            $userData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pdo->commit();
            return $userData;
           
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            $pdo->rollBack();
            
        }
    }
}
