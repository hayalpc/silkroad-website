<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
 * Date: 8.06.2018
 * Time: 02:44
 */

class EPinKod
{
    public $ID;
    public $Status;
    public $Val1;
    public $Val2;
    public $Val3;
    public $Price;
    public $StrUserID;
    public $Bonus;
    public $Order;
    public $Date;

    public static function get($ID)
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._EpinKod  Where ID=:ID";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':ID' => $ID]);
        return $sta->fetchObject('EPinKod');
    }

    public function insert()
    {
        $con = DB::getConnection();
        $sql = "INSERT INTO [SRO_VT_PANEL].[dbo].[_EpinKod] (Status, Val1, Val2, Price, Val3, StrUserID, Bonus, [Order]) VALUES (:Status, :Val1, :Val2, :Price, :Val3, :StrUserID, :Bonus, :Order);";
        $sta = $con->prepare($sql);
        $sta->execute([
            ':Status'=>$this->Status,
            ':Val1'=>$this->Val1,
            ':Val2'=>$this->Val2,
            ':Val3'=>$this->Val3,
            ':Price'=>$this->Price,
            ':StrUserID'=>$this->StrUserID,
            ':Bonus'=>$this->Bonus,
            ':Order'=>$this->Order,
        ]);
        $this->ID = $con->lastInsertId();
    }

    public function update()
    {
        $con = DB::getConnection();
        $sql = "UPDATE SRO_VT_PANEL.dbo._EpinKod SET Status=:Status, Val1=:Val1, Val2=:Val2, Price=:Price, Val3=:Val3, StrUserID=:StrUserID, Bonus=:Bonus, [Order]=:Order WHERE ID=:ID";
        $sta = $con->prepare($sql);
        $sta->execute([
            ':Status'=>$this->Status,
            ':Val1'=>$this->Val1,
            ':Val2'=>$this->Val2,
            ':Val3'=>$this->Val3,
            ':Price'=>$this->Price,
            ':StrUserID'=>$this->StrUserID,
            ':Bonus'=>$this->Bonus,
            ':Order'=>$this->Order,
            ':ID'=>$this->ID,
        ]);

    }

    /**
     * @param string $val1
     * @param string $val2
     * @param string $val3
     * @return EPinKod
     */
    public static function check($val1 = '', $val2 = '', $val3 = '')
    {
        $con = DB::getConnection();
        $sql = 'SELECT * FROM SRO_VT_PANEL.dbo._EpinKod WHERE Val1 = :Val1 AND Val2 = :Val2 AND Val3 = :Val3';
        $sta = $con->prepare($sql);
        $sta->execute([
            ':Val1' => $val1,
            ':Val2' => $val2,
            ':Val3' => $val3,
        ]);
        return $sta->fetchObject('EPinKod');
    }

    public static function getBonus($amount)
    {
        return 0;
        switch ($amount) {
            case 5 :
                $bonus = 0;
                break;
            case 10 :
                $bonus = 0;
                break;
            case 25 :
                $bonus = 0;
                break;
            case 50 :
                $bonus = 10;
                break;
            case 75 :
                $bonus = 15;
                break;
            case 100 :
                $bonus = 25;
                break;
            case 250 :
                $bonus = 75;
                break;
            default :
                $bonus = 0;
                break;
        }
        return $bonus;
    }

    public static function bonus($amount)
    {
        switch ($amount) {
            case 5 :
                $bonus = 0;
                break;
            case 10 :
                $bonus = 0;
                break;
            case 25 :
                $bonus = 0;
                break;
            case 50 :
                $bonus = 10;
                break;
            case 75 :
                $bonus = 15;
                break;
            case 100 :
                $bonus = 25;
                break;
            case 250 :
                $bonus = 75;
                break;
            default :
                $bonus = 0;
                break;
        }
        return $amount + $bonus;
    }

    public function add()
    {
        
    }

}