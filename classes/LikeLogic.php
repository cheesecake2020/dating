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
            $row = $stmt->fetch();
           
                return $row;
            
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return false;
        }
    
    }
}