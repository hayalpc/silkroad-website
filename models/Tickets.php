<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 9.02.2019
 * Time: 21:57
 */

class Tickets extends stdClass
{

    public static function getAllOwn($JID)
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Tickets WHERE CharName16 COLLATE Latin1_General_CI_AS in(SELECT t.CharName16 FROM SRO_VT_SHARD.dbo._Char t,SRO_VT_SHARD.dbo._User u WHERE u.UserJID=:JID AND t.CharID = u.CharID) ORDER BY id DESC";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':JID'=>$JID]);
        return $sta->fetchAll(PDO::FETCH_CLASS, 'Tickets');
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM SRO_VT_PANEL.dbo._Tickets WHERE id=:id";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':id' => $id]);
    }

    public static function close($id)
    {
        self::updateStatus($id, 'closed');
    }

    public static function updateStatus($id, $status)
    {
        $sql = "UPDATE SRO_VT_PANEL.dbo._Tickets SET Status=:status WHERE id=:id";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':id' => $id, ':status' => $status]);
    }

    public static function add($CharName16, $Message)
    {
        $sql = "INSERT INTO SRO_VT_PANEL.dbo._Tickets (CharName16,Message,Status,CreateTime) VALUES (:char,:msg,:status,GETDATE())";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([ ':char' => $CharName16, ':msg' => $Message, ':status' => 'new']);
    }

}