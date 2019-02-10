<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 9.02.2019
 * Time: 21:57
 */

class Tickets extends stdClass
{

    public static function getAll()
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Tickets ORDER BY id DESC";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
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

    public static function add($id, $CharName16, $Message)
    {
        $sql = "INSERT INTO SRO_VT_PANEL.dbo._Tickets (ParentTicket,CharName16,Message,Status) VALUES (:id,:char,:msg,:status)";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':id' => $id, ':char' => $CharName16, ':msg' => $Message, ':status' => 'unread']);
    }

}