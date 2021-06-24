<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
$dotenv->load();

use PHPUnit\Framework\TestCase;
use MicroEmail\Database\PdoConnection;

final class Tests extends TestCase
{

    protected $connection;

    public function testPdoDbConnection(){
        $this->connection = PdoConnection::connect();
        $stmt = $this->connection->query("SHOW DATABASES");
        $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $this->assertEquals(getenv('PDO_DBNAME'),$result[1]);
    }

    public function testCheckTableEmailsSent(){
        $this->connection = PdoConnection::connect();
        $stmt = $this->connection->query("SHOW TABLES");
        $result = $stmt->fetchAll(\PDO::FETCH_COLUMN);
        $this->assertEquals('email_sent',$result[0]);
    }

}