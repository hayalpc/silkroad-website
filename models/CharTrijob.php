<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 9.03.2019
 * Time: 16:25
 */

class CharTrijob extends stdClass{


    public static function getByCharID($CharID)
    {
        $sql = "SELECT * FROM SRO_VT_SHARD.dbo._CharTrijob WHERE CharID=:CharID";
        $sta = Db::getConnection()->prepare($sql);
        $sta->execute([':CharID'=>$CharID]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }
}