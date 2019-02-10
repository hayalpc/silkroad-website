<?php
/**
 * Created by PhpStorm.
 * User: ekrmn60
 * Date: 15.06.2018
 * Time: 16:56
 */

class Gallery
{

    public static function getImages()
    {
        $con = DB::getConnection();
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Galery  WHERE Service='1' Order By ID Desc";
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }
}