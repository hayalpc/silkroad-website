<?php
/**
 * Created by IntelliJ IDEA.
 * User: ekrmn60600
 * Date: 27.02.2019
 * Time: 01:24
 */

class Faq extends stdClass
{

    public static function getAll()
    {
        $sql = "";
        $sta = DB::getConnection()->prepare($sql);
        $sta->execute();
        return $sta->fetchAll(PDO::FETCH_ASSOC);
    }

}