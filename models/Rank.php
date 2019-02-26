<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 26.02.2019
 * Time: 01:31
 */

class Rank extends stdClass
{
    const THIEF = 2;
    const HUNTER = 3;
    const TRADER = 1;

    public static function getJob($JobType)
    {
        $cache = cache()->get("getJob-$JobType");
        if (!$cache) {
            $sql = "SELECT TOP 50 t1.*,t2.NickName16 FROM [SRO_VT_SHARD].[dbo].[_CharTriJob] t1 JOIN SRO_VT_SHARD.dbo._Char t2 on t2.CharID=t1.CharID  WHERE [JobType] = :JobType  ORDER BY [Level] DESC, [Exp] DESC";
            $sta = DB::getConnection()->prepare($sql);
            $sta->execute([':JobType' => $JobType]);
            $cache = $sta->fetchAll(PDO::FETCH_ASSOC);
            cache()->add("getJob-$JobType", $cache, 60 * 60);
        }
        return $cache;
    }

    public static function getPlayer()
    {
        $cache = cache()->get("getPlayer");
        if (!$cache) {
            $sql = "SELECT TOP 50 [_Char].[CharName16] , [_Char].[CurLevel] , [_Char].[CharID] , SUM([_Items].[Optlevel]) AS ItemPoints
                        FROM SRO_VT_SHARD.dbo.[_Char] 
                            INNER JOIN SRO_VT_SHARD.dbo.[_Inventory] ON [_Char].[CharID] = [_Inventory].[CharID] 
                            INNER JOIN SRO_VT_SHARD.dbo.[_Items] ON [_Inventory].[ItemID] = [_Items].[ID64]
                        WHERE [_Char].[CharName16] NOT LIKE '%GM%' AND [_Char].[CharName16] NOT LIKE '%GA%' AND [_Inventory].[Slot] between 1 and 50
                            GROUP BY [_Char].[CharName16],[_Char].[CurLevel],[_Char].[CharID]
                            ORDER BY [_Char].[CurLevel] DESC ,SUM([_Items].[Optlevel]) DESC";
            $sta = DB::getConnection()->prepare($sql);
            $sta->execute();
            $cache = $sta->fetchAll(PDO::FETCH_ASSOC);
            cache()->add("getPlayer", $cache, 60 * 60);
        }
        return $cache;
    }

    public static function getGuild()
    {
        $cache = cache()->get("getGuild");
        if (!$cache) {
            $sql = "SELECT  TOP 50 _Guild.Name as Name,_Guild.ID as GuildID,Lvl, SUM(_Items.OptLevel) AS ItemPoints,count(DISTINCT _GuildMember.CharID ) AS MemberCount
                        FROM SRO_VT_SHARD.dbo._Char 
                            INNER JOIN SRO_VT_SHARD.dbo._Inventory ON _Char.CharID = _Inventory.CharID 
                            INNER JOIN SRO_VT_SHARD.dbo._Items ON _Inventory.ItemID = _Items.ID64 
                            INNER JOIN SRO_VT_SHARD.dbo._GuildMember ON _Char.CharID = _GuildMember.CharID 
                            INNER JOIN SRO_VT_SHARD.dbo._Guild ON _GuildMember.GuildID = _Guild.ID
                        WHERE _Guild.Name != _Char.Charname16
                            GROUP BY _Guild.ID,_Guild.Name, _Guild.GatheredSP,_Guild.Lvl
                            ORDER BY SUM(_Items.Optlevel) DESC";
            $sta = DB::getConnection()->prepare($sql);
            $sta->execute();
            $cache = $sta->fetchAll(PDO::FETCH_ASSOC);
            cache()->add("getGuild", $cache, 60 * 60);
        }
        return $cache;
    }

    public static function getUniqueHistory($top = 10)
    {
        $sql = 'SELECT TOP '.$top.' c.CharID, t.CharName, un.CodeName128, un.Name, t.time FROM SRO_VT_ACCOUNT.dbo.Evangelion_uniques t
        JOIN SRO_VT_SHARD.dbo._Char c ON c.CharName16 COLLATE SQL_Latin1_General_CP1_CI_AS = t.CharName COLLATE SQL_Latin1_General_CP1_CI_AS
        JOIN FILTER.dbo._UniqueName un ON un.CodeName128 COLLATE SQL_Latin1_General_CP1_CI_AS = t.MobName COLLATE SQL_Latin1_General_CP1_CI_AS 
    ORDER BY
        t.ID DESC';

        $sta = DB::getConnection()->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }
}