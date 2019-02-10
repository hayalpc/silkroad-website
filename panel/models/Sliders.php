<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 7.02.2019
 * Time: 12:56
 */

class Sliders extends stdClass
{
    public static function getAll()
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._SliderImages ORDER BY ID DESC";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_CLASS, 'Sliders');
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM SRO_VT_PANEL.dbo._SliderImages WHERE ID=:id";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':id' => $id]);
    }

    public static function close($id)
    {
        self::updateStatus($id, '0');
    }

    public static function updateStatus($id, $status)
    {
        $sql = "UPDATE SRO_VT_PANEL.dbo._SliderImages SET Service=:status WHERE ID=:id";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':id' => $id, ':status' => $status]);
    }

    public static function add($data)
    {
        $sql = "INSERT INTO SRO_VT_PANEL.dbo._SliderImages (Service,Title,Description,ResimUrl,Url,Thumb) VALUES (:Service,:Title,:Description,:ResimUrl,:Url,:Thumb)";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([
            ':Service'=>$data['Service'],
            ':Title'=>$data['Title'],
            ':Description'=>$data['Description'],
            ':ResimUrl'=>$data['ResimUrl'],
            ':Url'=>$data['Url'],
            ':Thumb'=>$data['Thumb'],
        ]);
    }

}