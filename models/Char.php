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
        $sql = "SELECT _Char.*,(SELECT TOP 1 silk_point FROM SRO_VT_ACCOUNT.dbo.SK_Silk WHERE JID = UserJID) AS JobPoint FROM SRO_VT_SHARD.dbo._Char,SRO_VT_SHARD.dbo._User  WHERE _Char.CharID=:CharID AND _User.CharID=_Char.CharID";
        $sta = Db::getConnection()->prepare($sql);
        $sta->execute([':CharID'=>$id]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public static function getUniques($id)
    {
        $sql = "SELECT TOP 10 t.time,un.Name AS MobRealName FROM SRO_VT_ACCOUNT.dbo.Evangelion_uniques t
JOIN FILTER.dbo._UniqueName un ON un.CodeName128 COLLATE SQL_Latin1_General_CP1_CI_AS = t.MobName COLLATE SQL_Latin1_General_CP1_CI_AS
WHERE t.CharName in(SELECT CharName16 COLLATE Latin1_General_CI_AS FROM SRO_VT_SHARD.dbo._Char WHERE CharID=:CharID) 
GROUP BY t.time,un.Name 
    ORDER BY
        SRO_VT_ACCOUNT.dbo.UNIX_TIMESTAMP(t.time) DESC";
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

    public static function getItems($id)
    {
        $sql = "SELECT inv.CharID, inv.Slot,i.OptLevel, i.ID64, co.ID, co.CodeName128, it.Name FROM SRO_VT_SHARD.dbo._Inventory inv, SRO_VT_SHARD.dbo._Items i, SRO_VT_SHARD.dbo._RefObjCommon co LEFT OUTER JOIN FILTER.dbo._ItemName it ON co.NameStrID128 COLLATE SQL_Latin1_General_CP1_CI_AS = it.CodeName128 WHERE inv.CharID= :CharID AND inv.ItemID= i.ID64 AND i.RefItemID= co.ID AND inv.Slot< 13 ORDER BY inv.Slot ASC";
        $sta = DB::getConnection()->prepare($sql);
        $sta->execute([':CharID'=>$id]);
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getItemFileName($code)
    {
        if($code == 'DUMMY_OBJECT')
            return false;
        $irk = self::getIrk($code);
        $cinsiyet = self::getCinsiyet($code);
        if(!$cinsiyet)
            return $code;
        $level = self::getLevel($code);
        $aa = "";
        $tip = self::getTip($code,$aa);
        $file = $irk."/".$cinsiyet."/".$tip."_".$level.$aa.".PNG";
        return "/assets/img/equipment/item/".$file;
    }

    public static function getIrk($code)
    {
        $a = substr($code,0,strlen("ITEM_EU"));
        if(strpos($code,'_SET_') !== false && (strpos($code,'LIGHT') !== false || strpos($code,'CLOTHES') !== false || strpos($code,'HEAVY') !== false)) {
            return "common";
        }elseif($a == "ITEM_EU"){
            return "europe";
        }else{
            return "china";
        }
    }

    public static function getTip($code,&$a = "")
    {
        $ex = explode("_",strtolower($code));
        $b = "";
        $c = "";
        if(strpos($code,'CLOTHES') !== false) {
            $c = strpos(strtolower($code),'_set_a_') !== false ? '_set_a' : (strpos(strtolower($code),'_set_b_') !== false ? '_set_b' : '');
            $a = "_".$ex[5];
            $b = "clothes";
        }elseif(strpos($code,'LIGHT') !== false) {
            $c = strpos(strtolower($code),'_set_a_') !== false ? '_set_a_' : (strpos(strtolower($code),'_set_b_') !== false ? '_set_b' : '');
            $a = "_".$ex[5];
            $b = "light";
        }elseif(strpos($code,'HEAVY') !== false) {
            $c = strpos(strtolower($code),'_set_a_') !== false ? '_set_a' : (strpos(strtolower($code),'_set_b_') !== false ? '_set_b' : '');
            $a = "_".$ex[5];
            $b = "heavy";
        }elseif(strpos($code,'_SHIELD_') !== false && strpos($code,'_SET_') !== false) {
            $c = strpos(strtolower($code),'_set_a_') !== false ? '_set_a' : (strpos(strtolower($code),'_set_b_') !== false ? '_set_b' : '');
            $b = $ex[1]."_".$ex[2];
        }elseif(strpos($code,'_NECKLACE_') !== false && strpos($code,'_SET_') !== false) {
            $c = strpos(strtolower($code),'_set_a_') !== false ? '_set_a' : (strpos(strtolower($code),'_set_b_') !== false ? '_set_b' : '');
            $b = $ex[1]."_".$ex[2];
        }elseif(strpos($code,'_RING_') !== false && strpos($code,'_SET_') !== false) {
            $c = strpos(strtolower($code),'_set_a_') !== false ? '_set_a' : (strpos(strtolower($code),'_set_b_') !== false ? '_set_b' : '');
            $b = $ex[1]."_".$ex[2];
        }elseif(strpos($code,'_EARRING_') !== false && strpos($code,'_SET_') !== false) {
            $c = strpos(strtolower($code),'_set_a_') !== false ? '_set_a' : (strpos(strtolower($code),'_set_b_') !== false ? '_set_b' : '');
            $b = $ex[1]."_".$ex[2];
        }else{
            $b = $ex[2];
        }
        $a .= $c;
        return $b;
    }

    public static function getLevel($code)
    {
        $a = substr($code,0,strlen(strtolower("ITEM_EU_W")));
        $a = strtolower($a);
        $ex = explode("_",$code);
        if($a == strtolower("ITEM_EU_W") || $a == strtolower("ITEM_CH_W") || $a == strtolower("ITEM_EU_M") || $a == strtolower("ITEM_CH_M")){
            return !empty($ex[4]) ? $ex[4] : '';
        }elseif(strpos($code,'_EARRING_') !== false || strpos($code,'_NECKLACE_') !== false || strpos($code,'_RING_') !== false) {
            return !empty($ex[3]) ? $ex[3] : '';
        }else{
            return !empty($ex[3]) ? $ex[3] : '';
        }
    }

    public static function getCinsiyet($code)
    {
        $a = substr($code,0,strlen("ITEM_EU_W"));
        if($a == "ITEM_EU_W" || $a == "ITEM_CH_W")
            return "woman_item";
        elseif($a == "ITEM_EU_M" || $a == "ITEM_CH_M")
            return "man_item";
        elseif(strpos($code,'_EARRING_') !== false){
            return "acc";
        }elseif(strpos($code,'_NECKLACE_') !== false) {
            return "acc";
        }elseif(strpos($code,'_RING_') !== false){
            return "acc";
        }elseif(strpos($code,'_SHIELD_') !== false){
            return "shield";
        }else{
            return "weapon";
        }
    }

    public static function getPlus($code)
    {
        if(strpos($code,'_RARE') !== false) {
            return true;
        }else{
            return false;
        }
    }

    public static function getSortOfItem($code)
    {
        $a = substr($code,0,strlen("ITEM_EU"));
        if($a == "ITEM_EU"){
            if(strpos($code,'CLOTHES') !== false) {
                return "Robe";
            }elseif(strpos($code,'LIGHT') !== false) {
                return "Light Armor";
            }elseif(strpos($code,'HEAVY') !== false) {
                return "Heavy Armor";
            }elseif(strpos($code,'SHIELD') !== false) {
                return "Shield";
            }else{
                return "Weapon";
            }
        }elseif($a == "ITEM_CH"){
            if(strpos($code,'CLOTHES') !== false) {
                return "Garment";
            }elseif(strpos($code,'LIGHT') !== false) {
                return "Protector";
            }elseif(strpos($code,'HEAVY') !== false) {
                return "Armor";
            }elseif(strpos($code,'SHIELD') !== false) {
                return "Shield";
            }else{
                return "Weapon";
            }
        }
        return "";
    }

    public static function getRareType($code)
    {
        $code = strtolower($code);
        if(strpos($code,'a_rare') !== false && self::getLevel($code) < 11) {
            return "sos". self::getLevel($code);
        }elseif(strpos($code,'b_rare') !== false && self::getLevel($code) < 11) {
            return "som";
        }elseif(strpos($code,'c_rare') !== false && self::getLevel($code) < 11) {
            return "sun";
        }elseif(strpos($code,'rare') !== false){
            return "nova";
        }else{
            return "";
        }
    }

    public static function generateItemList($list)
    {
        $data = [];
        foreach ($list as $item) {
            $data[$item['Slot']] = [
                'level'=>self::getLevel($item['CodeName128']),
                'dummy'=>$item['CodeName128'] == 'DUMMY_OBJECT',
                'code'=>$item['CodeName128'],
                'url'=>self::getItemFileName($item['CodeName128']),
                'name'=>$item['Name'],
                'is_sos'=>self::getPlus($item['CodeName128']),
                'rare'=>self::getRareType($item['CodeName128']),
                'plus'=>$item['OptLevel'],
                'sortofitem'=>self::getSortOfItem($item['CodeName128'])
            ];
        }
        if(get_client_ip() == '85.96.54.62') {
            pre($data);
        }
        return $data;
    }

    public static function bugKurtar($CharName)
    {
        $sql = "UPDATE [SRO_VT_SHARD].[dbo].[_Char] SET LatestRegion = 26752, PosX = 1285, PosY = 206451218, PosZ = 176 WHERE CharName16 = :CharName";
        $sta = DB::getConnection()->prepare($sql);
        $sta->execute([':CharName'=>$CharName]);
    }

}