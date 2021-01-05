<?php
require_once('dbconnect.php');
require_once('functions.php');

class LikeLogic extends Dbc
{
    public $table_name = 'likes';
    /**
     * いいねをしているかチェック
     * @param int $userid,$other_userid
     * @return  $result
     */
    public  function ckeckLike($userid,$other_userid)
    {
        // SQLの準備
        $sql = "SELECT * FROM $this->table_name WHERE send_like_userid = ? AND now_page_profile_id = ?";
        $pdo = $this->dbConnect();
       
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, (int)h($userid), PDO::PARAM_INT);
            $stmt->bindValue(2, (int)h($other_userid), PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result;
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return '失敗';
        }
    
    }
      /**
     * いいねを登録
     * @param int $userid,$other_userid
     * @return  $result
     */
    public  function sendLike($userid,$other_userid)
    {
        $result = false;
        $sql = "INSERT INTO $this->table_name (send_like_userid,now_page_profile_id) VALUES (?,?)";
        $pdo = $this->dbConnect();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, (int)h($userid), PDO::PARAM_INT);
            $stmt->bindValue(2, (int)h($other_userid), PDO::PARAM_INT);
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
     * いいねを削除
     * @param int $userid,$other_userid
     * @return  $result
     */
    public  function DeleteLike($userid,$other_userid)
    {
        $result = false;
        $sql = "DELETE FROM $this->table_name WHERE send_like_userid = ? AND now_page_profile_id=?";
        $pdo = $this->dbConnect();
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, (int)h($userid), PDO::PARAM_INT);
            $stmt->bindValue(2, (int)h($other_userid), PDO::PARAM_INT);
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
     * もらったいいねの表示
     * @param int $userid
     * @return  $result
     */
    public  function getLike($userid)
    {
        // SQL 自分にいいねを送った相手のプロフィールを取得
        $sql = "SELECT * FROM $this->table_name JOIN users ON likes.send_like_userid = users.user_id WHERE now_page_profile_id = ?";
        $pdo = $this->dbConnect();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, (int)h($userid), PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e->getMessage();
            echo 'SQL：' . $sql;
            return '失敗';
        }
    }
}