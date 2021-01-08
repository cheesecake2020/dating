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
    public  function ckeckLike($userid, $other_userid)
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
    public  function sendLike($userid, $other_userid)
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
    public  function DeleteLike($userid, $other_userid)
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

    /**
     * もらったいいねのidを取得
     * @param int $userid
     * @return  array $array
     */
    public  function getLikeArray($userid)
    {
        $array=[];
        $rows=$this->getLike($userid);
        foreach($rows as $val){
            $array[]=$val['user_id'];
        }
        return $array;
    }
    /**
     * 送ったいいねのidを取得
     * @param int $userid
     * @return  array $array
     */
    public  function getsendLikeArray($userid)
    {
        $array=[];
        $rows=$this->Allsendlike($userid);
        foreach($rows as $val){
            $array[]=$val['user_id'];
        }
        return $array;
    }
     /**
     * マッチングIDのチェック
     * @param int $userid
     * @return  array $result
     */
    public  function Matchid($userid)
    {
        $getlikes=$this->getsendLikeArray($userid);
        $sendlikes=$this->getLikeArray($userid);
        $result=array_intersect ($getlikes , $sendlikes );
        return $result;
    }
    
     /**
     * マッチング相手のデータを取得
     * @param int $matchid
     * @param int $count
     * @return  array $result
     */
    public  function MatchUser($matchid)
    {
        // 配列をカンマで加工
        $val=implode(',',$matchid);
        // INでidを取得
            $sql = "SELECT* FROM users WHERE user_id IN (?)";
            $pdo = $this->dbConnect();
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, (string)h($val), PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } catch (\Exception $e) {
                echo '<br>えらー：' . $e->getMessage();
                echo 'SQL：' . $sql;
                return '失敗';
            }
    }
    /**
     * 送ったいいねのすべてを表示
     * @param int $userid
     * @return  $result
     */
    public  function Allsendlike($userid)
    {
        $sql = "SELECT* FROM $this->table_name JOIN users ON likes.now_page_profile_id = users.user_id WHERE likes.send_like_userid = ?";
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

    /**
     * 異性とマッチングしているか
     * @param int $userid $other_userid
     * @return  $result
     */
    public  function checkMatch($userid, $other_userid)
    {

        // 自分がいいねしているか
        if ($this->ckeckLike($userid, $other_userid)) {
            // 相手もいいねしているか
            $sql = "SELECT * FROM $this->table_name  WHERE now_page_profile_id = :userid AND send_like_userid =:otherid";
            $pdo = $this->dbConnect();
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':userid', (int)h($userid), PDO::PARAM_INT);
                $stmt->bindValue(':otherid', (int)h($other_userid), PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
               
            } catch (\Exception $e) {
                echo '<br>えらー：' . $e->getMessage();
                return '失敗';
            }
        }
    }
}
