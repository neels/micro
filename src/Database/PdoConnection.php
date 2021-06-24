<?php
namespace MicroEmail\Database;

class PdoConnection
{
    /**
     * @param string $dbType
     * @return null|\PDO
     */
    public function connect ($dbType = 'mysql')
    {
        $dbconnection = null;
        $host = getenv('PDO_HOST');
        $dbname = getenv('PDO_DBNAME');
        $username = getenv('PDO_USERNAME');
        $password = getenv('PDO_PASSWORD');
        $dbType = trim($dbType);

        try {
            $dbconnection = new \PDO("$dbType:host=$host;dbname=$dbname", $username, $password);
            $dbconnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {

            die(sprintf('Connection to DB failed: %s', $e->getMessage()));
        }

        return $dbconnection;
    }
}