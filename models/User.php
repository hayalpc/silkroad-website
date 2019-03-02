<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
 * Date: 31.05.2018
 * Time: 03:10
 */

class User
{
    public $JID;
    public $StrUserID;
    public $password;
    public $Status;
    public $GMrank;
    public $Name;
    public $Email;
    public $sex;
    public $certificate_num;
    public $address;
    public $postcode;
    public $phone;
    public $mobile;
    public $regtime;
    public $reg_ip;
    public $Time_log;
    public $freetime;
    public $sec_primary;
    public $sec_content;
    public $AccPlayTime;
    public $LatestUpdateTime_ToPlayTime;
    public $Play123Time;
    public $OnlineTimee;
    public $Ban;
    public $Money;
    public $Cafe;

    public static function get($JID)
    {
        $sql = "SELECT TB_User.*,(SELECT BakiyeTL FROM SRO_VT_PANEL.dbo._Bakiye WHERE StrUserID COLLATE SQL_Latin1_General_CP1_CI_AS =TB_User.StrUserID) AS BakiyeTL,(SELECT silk_own FROM SRO_VT_ACCOUNT.dbo.SK_Silk WHERE JID = TB_User.JID) AS BakiyeSilk FROM SRO_VT_ACCOUNT.dbo.TB_User  Where JID=:JID";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':JID' => $JID]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public static function getChars($JID)
    {
        $sql = "SELECT _User.UserJID,_User.CharID,_Char.* FROM SRO_VT_SHARD.dbo._User,SRO_VT_SHARD.dbo._Char WHERE _User.CharID=_Char.CharID AND _User.UserJID=:UserJID Order BY _Char.CurLevel DESC";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':UserJID' => $JID]);
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getHistory($StrUserID)
    {
        $sql = "SELECT TOP 100* FROM SRO_VT_PANEL.dbo._IslemGecmisi Where StrUserID=:StrUserID ORDER BY ID DESC";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':StrUserID' => $StrUserID]);
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function updatePassword($JID, $Password)
    {
        $sql = "UPDATE [SRO_VT_ACCOUNT].[dbo].[TB_User] SET [password] = :password WHERE [JID] = :JID;";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':JID' => $JID, ':password' => md5($Password)]);
    }

    public static function login($StrUserID, $password)
    {
        $sql = "SELECT TB_User.*,(SELECT TOP 1 BakiyeTL FROM SRO_VT_PANEL.dbo._Bakiye WHERE StrUserID COLLATE SQL_Latin1_General_CP1_CI_AS = TB_User.StrUserID) AS BakiyeTL,(SELECT TOP 1 silk_own FROM SRO_VT_ACCOUNT.dbo.SK_Silk WHERE JID = TB_User.JID) AS BakiyeSilk,(SELECT TOP 1 silk_gift FROM SRO_VT_ACCOUNT.dbo.SK_Silk WHERE JID = TB_User.JID) AS JobPoint FROM SRO_VT_ACCOUNT.dbo.TB_User  Where StrUserID=:StrUserID AND password=:password";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':StrUserID' => $StrUserID, ':password' => md5($password)]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public static function checkUsername($username)
    {
        $sql = "SELECT * FROM SRO_VT_ACCOUNT.dbo.TB_User  Where StrUserID=:StrUserID";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':StrUserID' => $username]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public static function checkEmail($email)
    {
        $sql = "SELECT * FROM SRO_VT_ACCOUNT.dbo.TB_User  Where Email=:Email";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':Email' => $email]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser()
    {
        try {
            $sql = "INSERT INTO [SRO_VT_ACCOUNT].[dbo].[TB_User](StrUserID,password,Email,certificate_num,sec_primary,sec_content) VALUES (:StrUserID,:password,:Email,:certificate_num,:sec_primary,:sec_content)";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute([
                ':StrUserID' => $this->StrUserID,
                ':password' => $this->password,
                ':Email' => $this->Email,
                ':certificate_num' => $this->certificate_num,
                ':sec_primary' => $this->sec_primary,
                ':sec_content' => $this->sec_content,
            ]);
            $this->JID = $con->lastInsertId();
            //            $this->JID = $sta->fetchColumn(0);
            return $this;
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function addSilk($JID, $silk)
    {
        $sql = "INSERT INTO SRO_VT_ACCOUNT.dbo.SK_Silk (JID,silk_own,silk_gift,silk_point) VALUES (:JID,:silk_own,'0','0')";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([
            ':JID' => $JID,
            ':silk_own' => $silk,
        ]);
    }

    public static function getBakiye($StrUserID)
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Bakiye  Where StrUserID=:StrUserID";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':StrUserID' => $StrUserID]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public static function harcaBakiye($StrUserID, $TL, $Durum = 'cikti')
    {
        try {
            $sql = "UPDATE [SRO_VT_PANEL].[dbo].[_Bakiye] SET BakiyeTL=BakiyeTL-:BakiyeTL WHERE StrUserID=:StrUserID;";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);

            if(self::addBakiyeLog($StrUserID, $Durum, $TL)){
                $sta->execute([
                    ':StrUserID' => $StrUserID,
                    ':BakiyeTL' => $TL,
                ]);
                return true;
            } else {
                return false;
            }
        } catch(Exception $e) {
            return false;
        }
    }

    public static function addBakiye($StrUserID, $TL, $Durum = 'girdi')
    {
        if(self::getBakiye($StrUserID)){
            try {
                $sql = "UPDATE [SRO_VT_PANEL].[dbo].[_Bakiye] SET BakiyeTL=BakiyeTL+:BakiyeTL WHERE StrUserID=:StrUserID;";
                $con = DB::getConnection();
                $sta = $con->prepare($sql);

                if(self::addBakiyeLog($StrUserID, $Durum, $TL)){
                    $sta->execute([
                        ':StrUserID' => $StrUserID,
                        ':BakiyeTL' => $TL,
                    ]);
                    return true;
                } else {
                    return false;
                }
            } catch(Exception $e) {
                return false;
            }
        } else {
            try {
                $sql = "INSERT INTO [SRO_VT_PANEL].[dbo].[_Bakiye]([StrUserID], [BakiyeTL]) VALUES ( :StrUserID,:BakiyeTL);";
                $con = DB::getConnection();
                $sta = $con->prepare($sql);
                if(self::addBakiyeLog($StrUserID, $Durum, $TL)){
                    $sta->execute([
                        ':StrUserID' => $StrUserID,
                        ':BakiyeTL' => $TL,
                    ]);
                    return true;
                } else {
                    return false;
                }
            } catch(Exception $e) {
                return false;
            }
        }
    }

    public static function addBakiyeLog($StrUserID, $Durum, $Tutar, $Bonus = 0)
    {
        return true;
        try {
            $sql = "INSERT INTO [SRO_VT_PANEL].[dbo].[_BakiyeLog] ([StrUserID], [Durum], [Tutar], [Bonus]) VALUES (:StrUserID, :Durum, :Tutar, :Bonus );";
            $con = DB::getConnection();
            $sta = $con->prepare($sql);
            $sta->execute([
                ':StrUserID' => $StrUserID,
                ':Durum' => $Durum,
                ':Tutar' => $Tutar,
                ':Bonus' => $Bonus,
            ]);
            return true;
        } catch(Exception $e) {
            return false;
        }
    }

    public static function addLog($StrUserID, $Durum)
    {
        $sql = "INSERT INTO [SRO_VT_PANEL].[dbo].[_IslemGecmisi]([StrUserID], [Durum], [IP], [Time]) VALUES ( :StrUserID, :Durum, :IP, getutcdate());";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([
            ':StrUserID' => $StrUserID,
            ':Durum' => $Durum,
            ':IP' => get_client_ip(),
        ]);
    }


    public static function getJobHonorBuffList()
    {
        $sql = 'SELECT
                    c.CharID,c.CharName16,c.NickName16, ctj.JobType,c.CurLevel,sks.silk_gift,ctj.Level
                FROM
                    SRO_VT_SHARD.dbo._Char c
                    JOIN SRO_VT_SHARD.dbo._CharTrijob ctj ON ctj.CharID=c.CharID 
                    JOIN SRO_VT_SHARD.dbo._User u ON u.CharID=c.CharID
                    JOIN SRO_VT_ACCOUNT.dbo.SK_Silk sks ON sks.JID=u.UserJID
                WHERE ctj.Level>=1 AND sks.silk_gift>=100 AND c.CurLevel>=105 AND LEN(c.NickName16)>1 ORDER BY ctj.Level DESC,sks.silk_gift DESC,c.CharName16 ASC';
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }


}