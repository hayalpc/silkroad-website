<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
* Date: 2.06.2018
* Time: 02:59
*/
class Store{

    public static function get($ID)
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Mall WHERE ID=:ID";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([
            ':ID'=>$ID,
        ]);
        return $sta->fetchObject('Store');
    }

    public static function getMall()
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Mall order by Type Desc";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

}