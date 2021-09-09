<?php
require_once('../config/env.php');
ini_set('display_errors',"On");
 class Dbc
{
    public $table_name;
    // 関数一つに一つの機能のみをもたせる　引数と返り値を考える
    // 1.データベースに接続　
    // 引数なし　
    // 返り値：接続結果
    protected function dbConnect()
    {
        $host = DB_HOST;
        $dbname = DB_NAME;
        $user = DB_USER;
        $pass = DB_PASS;
        $port = DB_PORT;
        $dsn = "mysql:dbname=$dbname;port=$port;host=$host;charset=utf8";
        $dsn2 = "mysql:host=$host;dbname=$dbname;charaset=UTF8";
        try {
            $pdo = new \PDO($dsn, $user, $pass, [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);
            return $pdo;
        } catch (PDOException $e) {
            echo '接続失敗' . $e->getMessage();
            exit();
        };
        return $pdo;
    }
    // 2.データを取得する
    // 引数なし
    // 返り値：取得したデータ
    public function getAll()
    {
        // クラス内で別のファンクションを使うときはthisを使う
        $dbh = $this->dbConnect();
        //    SQLの準備
        $sql = "SELECT * FROM $this->table_name";
        // SQLの実行
        $stmt = $dbh->query($sql);
        // 結果を受け取る
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
        $dbh = null;
    }

    // 引数　id
    // 返り値$result
    public function getById($id)
    {
        if (empty($id)) {
            exit('idが不正です。');
        }

        $dbh = $this->dbConnect();
        // sqlの準備
        $stmt = $dbh->prepare("SELECT * FROM  $this->table_name Where id = :id");
        // プレースホルダーの設定SQLインジェクションを防ぐ
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        // SQLの実行
        $stmt->execute();
        // 結果を取得
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
            exit('ブログがありません');
        }
        return $result;
    }
    public function delete($id)
    {
        if (empty($id)) {
            exit('idが不正です。');
        }

        $dbh = $this->dbConnect();
        // sqlの準備
        $stmt = $dbh->prepare("DELETE FROM  $this->table_name Where id = :id");
        // プレースホルダーの設定SQLインジェクションを防ぐ
        $stmt->bindValue(':id', (int)$id, \PDO::PARAM_INT);
        // SQLの実行
        $stmt->execute();
        echo 'ブログを削除しました。';
        
    }
}
