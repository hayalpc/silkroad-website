<?php
/**
 * Created by IntelliJ IDEA.
 * User: erdinc.karaman
 * Date: 7.02.2019
 * Time: 12:56
 */

class Downloads extends stdClass
{
    public static function getAll()
    {
        $sql = "SELECT * FROM SRO_VT_PANEL.dbo._Download ORDER BY ID DESC";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_CLASS, 'Downloads');
    }

    public static function delete($id)
    {
        $sql = "DELETE FROM SRO_VT_PANEL.dbo._Download WHERE ID=:id";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([':id' => $id]);
    }

    public static function add($data)
    {
        $sql = "INSERT INTO SRO_VT_PANEL.dbo._Download (Dosya_Host,Dosya_Type,Dosya_Url,Dosya_Boyut,Dosya_Tarih) VALUES (:Dosya_Host,:Dosya_Type,:Dosya_Url,:Dosya_Boyut,:Dosya_Tarih)";
        $con = DB::getConnection();
        $sta = $con->prepare($sql);
        $sta->execute([
            ':Dosya_Host'=>$data['Dosya_Host'],
            ':Dosya_Type'=>$data['Dosya_Type'],
            ':Dosya_Url'=>$data['Dosya_Url'],
            ':Dosya_Boyut'=>$data['Dosya_Boyut'],
            ':Dosya_Tarih'=>date('d/m/Y'),
        ]);
    }

}