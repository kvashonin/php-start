<?php

class Db
{
    public static function getConnection()
    {
        $paramsPath = ROOT.'/config/db_params.php';
        $params = include($paramsPath);

        $dbh = new PDO("mysql:host=".$params["host"].";dbname=".$params["dbname"], $params["user"], $params["pass"]);

        return $dbh;
    }
}