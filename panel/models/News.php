<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 7.02.2019
 * Time: 12:56
 */

class News extends stdClass
{
    public static function getAll()
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._News ORDER BY ID DESC";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_CLASS, 'News');
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM SRO_VT_PANEL.dbo._News WHERE ID=:id";
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
        $sql = "UPDATE SRO_VT_PANEL.dbo._News SET Service=:status WHERE ID=:id";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':id' => $id, ':status' => $status]);
    }

    public static function add($data)
    {
        $sql = "INSERT INTO SRO_VT_PANEL.dbo._News (Service,Baslik,Tanim,Metin,Resim,Tarih) VALUES (:Service,:Baslik,:Tanim,:Metin,:Resim,:Tarih)";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([
            ':Service'=>$data['Service'],
            ':Baslik'=>$data['Baslik'],
            ':Tanim'=>$data['Tanim'],
            ':Metin'=>$data['Metin'],
            ':Resim'=>$data['Resim'],
            ':Tarih'=>date('d/m/Y')
        ]);
    }

}