<?php
namespace MicroEmail\Models;

use MicroEmail\Database\PdoConnection;

class EmailsModel {
    /** @var null|\PDO  */
    public $connection;

    public function __construct ()
    {
        $model = new PdoConnection();
        $this->connection = $model->connect();
    }

    /**
     * @return array
     */
    public function getAllEmails(){
        $stmt = $this->connection->prepare("select * from email_sent");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $email
     * @param $name
     * @param $subject
     * @param $body
     * @param $service
     * @param $type
     * @param $status
     */
    public function save($email, $name, $subject, $body, $service, $type, $status){
        $dateCreated = date('Y-m-d H:i:s');
        $sql = "INSERT INTO email_sent (`email` ,`name` ,`subject`, `body`, `service`, `type`, `status`, `date_created`) VALUES (?,?,?,?,?,?,?,?)";
        $this->connection->prepare($sql)->execute([$email, $name, $subject, $body, $service, $type, $status, $dateCreated]);
    }
}