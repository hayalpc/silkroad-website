<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
 * Date: 31.05.2018
 * Time: 03:10
 */

class Admin
{
    public $id;
    public $username;
    public $password;
    public $email;
    public $create_time;
    public $status;
    public $type;

    public static function get($JID)
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Admin  Where id=:id";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':id' => $JID]);
        return $sta->fetch(PDO::FETCH_ASSOC);
    }

    public static function updatePassword($JID, $Password)
    {
        $sql = "UPDATE [SRO_VT_PANEL].[dbo].[_Admin] SET [password] = :password WHERE [id] = :id;";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':id' => $JID, ':password' => md5($Password)]);
    }

    public static function login($StrUserID, $password)
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Admin  Where username=:username AND password=:password";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':username' => $StrUserID, ':password' => md5($password)]);
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

}