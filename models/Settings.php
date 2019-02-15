<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 29.05.2018
 * Time: 17:09
 */

class Settings
{
    private static $config = null;

    public static function getSliders()
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._SliderImages  WHERE Service='1' ORDER BY Sort ASC, ID DESC";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getToplamOnlineOyuncu()
    {
        $sql = "SELECT count(1) AS total FROM FILTER.dbo._OnlinePlayers WHERE cur_status=1";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchColumn(0);
    }
    public static function getToplamOnlineCH()
    {
        $sql = "SELECT count(1) AS total FROM FILTER.dbo._OnlinePlayers,SRO_VT_SHARD.dbo._Char WHERE cur_status=1 AND _Char.CharName16=_OnlinePlayers.CharName16 COLLATE SQL_Latin1_General_CP1_CI_AS AND _Char.RefObjID<1940";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchColumn(0);
    }
    public static function getToplamOnlineEU()
    {
        $sql = "SELECT count(1) AS total FROM FILTER.dbo._OnlinePlayers,SRO_VT_SHARD.dbo._Char WHERE cur_status=1 AND _Char.CharName16=_OnlinePlayers.CharName16 COLLATE SQL_Latin1_General_CP1_CI_AS AND _Char.RefObjID>14870";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchColumn(0);
    }

    public static function getConfig($key)
    {
        if (is_null(self::$config))
            self::loadConfig();
        return isset(self::$config[$key]) ? self::$config[$key] : false;
    }

    public static function loadConfig()
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Setting WHERE ID = '1'";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        $config1 = $sta->fetch(PDO::FETCH_ASSOC);
        return self::$config = $config1;
    }

    public static function getFortress($id)
    {
        $sql = "SELECT _Guild.Name,_SiegeFortress.Tax FROM SRO_VT_SHARD.dbo._SiegeFortress,SRO_VT_SHARD.dbo._Guild WHERE GuildID=ID AND FortressID = :FortressID";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':FortressID'=>$id]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }
    public static function getNews()
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._News  WHERE Service=1 order by ID Desc";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function getDownload()
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Download order by ID Desc";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSWStatus()
    {
        $timeout = 1;
        $socket = fsockopen(self::getConfig('Server_ip'),self::getConfig('Server_port'),$errno,$errstr,$timeout);
        return $socket ? 'Online' : 'Offline';
    }

    public static function getSwProperties()
    {
        return [
            'exp'=>'25x',
            'ptexp'=>'35x',
            'sp'=>'10x',
            'drop'=>'10x',
            'golddrop'=>'10x',
            'cap'=>'110',
            'alchemy'=>'+10(+2 ADV)',
            'version'=>'1.4xx'
        ];
    }
}