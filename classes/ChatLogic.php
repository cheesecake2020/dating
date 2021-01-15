<?php
require_once('dbconnect.php');
require_once('functions.php');

class ChatLogic extends Dbc
{
    /**
     * チャットルーム作成
     * @param int $userid,$otherid
     * @return bool $result or int$roomNum
     */
    public  function Createroom($userid, $otherid)
    {
        // チャットルームがあるか
        $roomNum = $this->getroom($userid, $otherid);
        // なければ作成
        if ($roomNum === null) {
            $result = false;
            $sql = "INSERT INTO chatroom (1_userid,2_userid) VALUES (?,?)";
            $pdo = $this->dbConnect();
            $pdo->beginTransaction();
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, (int)h($userid), PDO::PARAM_INT);
                $stmt->bindValue(2, (int)h($otherid), PDO::PARAM_INT);
                $result = $stmt->execute();
                $pdo->commit();
                $result = true;
                return $result;
            } catch (\Exception $e) {
                echo $e;
                $pdo->rollBack();
                return $result;
            }
        } else {
            return $roomNum;
        }
    }

    /**
     * チャットルームid取得
     * @param int $userid,$otherid
     * @return bool $result
     */
    public  function getroom($userid, $otherid)
    {
        $sql = "SELECT room_id FROM chatroom WHERE 1_userid IN($userid, $otherid) AND 2_userid IN($userid, $otherid)";
        $pdo = $this->dbConnect();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            while ($row = $stmt->fetch()) {
               return $row['room_id'];
            }
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return $e;
        }
    }

    
    /**
     * メッセージをDBにいれる
     * @param int $userid,$roomid
     * @param string $message
     * @return bool $result
     */
    public  function createMsg($userid,$roomid,$message)
    {
            $result = false;
            $sql = "INSERT INTO messages (send_userid,message,room_id) VALUES (?,?,?)";
            $pdo = $this->dbConnect();
            $pdo->beginTransaction();
            try {
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(1, (int)h($userid), PDO::PARAM_INT);
                $stmt->bindValue(2, (string)h($message), PDO::PARAM_STR);
                $stmt->bindValue(3, (int)h($roomid), PDO::PARAM_INT);
                $result = $stmt->execute();
                $pdo->commit();
                $result = true;
                return $result;
            } catch (\Exception $e) {
                echo $e;
                $pdo->rollBack();
                return $result;
            }
     
    }

      /**
     * ルームのメッセージを取得
     * @param int $roomid
     * @return array $result
     */
    public  function getMsg($roomid)
    {
        $sql = "SELECT * FROM messages WHERE room_id=?";
        $pdo = $this->dbConnect();
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(1, (int)h($roomid), PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $e) {
            echo '<br>えらー：' . $e;
            echo 'SQL：' . $sql;
            return $e;
        }
    }
}
