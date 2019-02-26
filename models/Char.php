<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 27.02.2019
 * Time: 00:33
 */

class Char extends stdClass
{

    public static function get($id)
    {
        $sql = "SELECT * FROM SRO_VT_SHARD.dbo._Char WHERE CharID=:CharID";
        $sta = Db::getConnection()->prepare($sql);
        $sta->execute([':CharID'=>$id]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUniques($id)
    {
        $sql = "SELECT TOP 10 t.*,un.Name AS MobRealName FROM SRO_VT_ACCOUNT.dbo.Evangelion_uniques t
JOIN FILTER.dbo._UniqueName un ON un.CodeName128 COLLATE SQL_Latin1_General_CP1_CI_AS = t.MobName COLLATE SQL_Latin1_General_CP1_CI_AS
WHERE t.CharName in(SELECT CharName16 COLLATE Latin1_General_CI_AS FROM SRO_VT_SHARD.dbo._Char WHERE CharID=:CharID) ORDER BY ID DESC";
        $sta = DB::getConnection()->prepare($sql);
        $sta->execute([':CharID'=>$id]);
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getGlobals($id)
    {
        $sql = "SELECT TOP 10 * FROM FILTER.dbo._GlobalChatLogs t WHERE t.CharName16 in(SELECT CharName16 COLLATE Latin1_General_CI_AS FROM SRO_VT_SHARD.dbo._Char WHERE CharID=:CharID) ORDER BY id DESC";
        $sta = DB::getConnection()->prepare($sql);
        $sta->execute([':CharID'=>$id]);
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }
}