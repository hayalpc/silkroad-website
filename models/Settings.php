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
    private static $properties = null;

    public static function getSliders()
    {
        $cache = cache()->get('getSliders');
        if (!$cache) {
            $sql = "SELECT * FROM SRO_VT_PANEL.dbo._SliderImages  WHERE Service='1' ORDER BY Sort ASC, ID DESC";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute();
            $cache = $sta->fetchAll(PDO::FETCH_ASSOC);
            cache()->add("getSliders", $cache, 60 * 60);
        }
        return $cache;
    }

    public static function getToplamOnlineOyuncu()
    {
        $cache = cache()->get('getToplamOnlineOyuncu');
        if (!$cache) {
            $sql = "SELECT count(1) AS total FROM FILTER.dbo._OnlinePlayers WHERE cur_status=1";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute();
            $cache = $sta->fetchColumn(0);
            cache()->add("getToplamOnlineOyuncu", $cache, 60 * 3);
        }
        return $cache;
    }

    public static function getToplamOnlineCH()
    {
        $cache = cache()->get('getToplamOnlineCH');
        if (!$cache) {
            $sql = "SELECT count(1) AS total FROM FILTER.dbo._OnlinePlayers,SRO_VT_SHARD.dbo._Char WHERE cur_status=1 AND _Char.CharName16=_OnlinePlayers.CharName16 COLLATE SQL_Latin1_General_CP1_CI_AS AND _Char.RefObjID<1940";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute();
            $cache = $sta->fetchColumn(0);
            cache()->add("getToplamOnlineCH", $cache, 60 * 3);
        }
        return $cache;
    }

    public static function getToplamOnlineEU()
    {
        $cache = cache()->get('getToplamOnlineEU');
        if (!$cache) {
            $sql = "SELECT count(1) AS total FROM FILTER.dbo._OnlinePlayers,SRO_VT_SHARD.dbo._Char WHERE cur_status=1 AND _Char.CharName16=_OnlinePlayers.CharName16 COLLATE SQL_Latin1_General_CP1_CI_AS AND _Char.RefObjID>14870";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute();
            $cache = $sta->fetchColumn(0);
            cache()->add("getToplamOnlineEU", $cache, 60 * 3);
        }
        return $cache;
    }

    public static function getConfig($key)
    {
        if (is_null(self::$config))
            self::loadConfig();
        return isset(self::$config[$key]) ? self::$config[$key] : false;
    }

    public static function loadConfig()
    {
        $cache = cache()->get('loadConfig');
        if (!$cache) {
            $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Setting WHERE ID = '1'";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute();
            $cache = $sta->fetch(PDO::FETCH_ASSOC);
            cache()->add('loadConfig', $cache);
        }
        return self::$config = $cache;
    }

    public static function getFortress($id)
    {
        $cache = cache()->get("getFortress-$id");
        if (!$cache) {
            $sql = "SELECT _Guild.Name,_SiegeFortress.TaxRatio FROM SRO_VT_SHARD.dbo._SiegeFortress,SRO_VT_SHARD.dbo._Guild WHERE GuildID=ID AND FortressID = :FortressID";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute([':FortressID' => $id]);
            $cache = $sta->fetch(PDO::FETCH_ASSOC);
            cache()->add("getFortress-$id", $cache, 60 * 60);
        }
        return $cache;
    }

    public static function getJob()
    {
        cache()->delete("getJob");
        $cache = cache()->get("getJob");
        if (!$cache) {
            $sql = "SELECT COUNT(*) AS [count],JobType FROM [SRO_VT_SHARD].[dbo].[_CharTriJob] WHERE JobType in(1,2,3) GROUP BY JobType";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute();
            $data = $sta->fetchAll(PDO::FETCH_ASSOC);
            $job = [1=>'Trader',2=>'Thief',3=>'Hunter'];
            $cache = [];
            $total = 0;
            foreach ($data as $datum) {
                $total += $datum["count"];
            }
            foreach ($data as $datum) {
                $cache[$datum['JobType']] = ['job'=>$job[$datum['JobType']], 'count'=>$datum["count"],'size'=>round($datum["count"] * 100 / $total,2)];
            }

            cache()->add("getJob", $cache, 60 * 60);
        }
        return $cache;
    }

    public static function getNews()
    {
        $cache = cache()->get("getNews");
        if (!$cache) {
            $sql = "SELECT * FROM SRO_VT_PANEL.dbo._News  WHERE Service=1 order by ID Desc";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute();
            $cache = $sta->fetchAll(PDO::FETCH_ASSOC);
            cache()->add("getNews", $cache, 60 * 60);
        }
        return $cache;
    }

    public static function getDownload()
    {
        $cache = cache()->get("getDownload");
        if (!$cache) {
            $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Download order by ID Desc";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute();
            $cache = $sta->fetchAll(PDO::FETCH_ASSOC);
            cache()->add("getDownload", $cache, 60 * 60);
        }
        return $cache;
    }

    public static function getSWStatus()
    {
        $timeout = 1;
        $socket = fsockopen(self::getConfig('Server_ip'), self::getConfig('Server_port'), $errno, $errstr, $timeout);
        return $socket ? 'Online' : 'Offline';
    }

    public static function getSwProperties()
    {
        return [
            'mastery_cap' => '220/440',
            'exp' => '25x',
            'ptexp' => '35x',
            'sp' => '10x',
            'drop' => '10x',
            'golddrop' => '10x',
            'tradegoods' => '10x',
            'cap' => '110',
            'alchemy' => '+10(+2 ADV)',
            'version' => '1.4xx',
            'pclimit' => '3',
            'joblimit' => '1',
            'iplimit' => '4',
        ];
    }

    public static function getSwProperty($k)
    {
        if (empty(self::$properties))
            self::$properties = self::getSwProperties();
        return isset(self::$properties[$k]) ? self::$properties[$k] : '-';
    }
}