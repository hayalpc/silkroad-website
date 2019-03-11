<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 9.03.2019
 * Time: 16:25
 */

class Guild extends stdClass{

    public static function get($id)
    {
        $sql = "SELECT * FROM SRO_VT_SHARD.dbo._Guild WHERE ID=:ID";
        $sta = Db::getConnection()->prepare($sql);
        $sta->execute([':ID'=>$id]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByCharID($CharID)
    {
        $sql = "SELECT * FROM SRO_VT_SHARD.dbo._Guild WHERE ID IN(SELECT GuildID FROM SRO_VT_SHARD.dbo._GuildMember WHERE CharID=:CharID)";
        $sta = Db::getConnection()->prepare($sql);
        $sta->execute([':CharID'=>$CharID]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }
}