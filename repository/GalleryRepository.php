<?php

require_once '../lib/Repository.php';
require_once 'PictureRepository.php';

/**
 * Created by PhpStorm.
 * User: David
 * Date: 23.03.2017
 * Time: 20:34
 */
class GalleryRepository extends Repository {

    protected $tableName = 'galleries';

    public function create($name, $user_id)
    {
        session_start();
        if(count($this->readByName($name)) < 1) {
            $query = "INSERT INTO $this->tableName (user_id, name) VALUES (?, ?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('is', $user_id, $name);

            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }

            $_SESSION['isSuccess'] = true;

            return $statement->insert_id;
        } else {
            $_SESSION['isSuccess'] = false;
        }
    }

    public function readByName($name) {
        $query = "SELECT * FROM $this->tableName WHERE name = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $name);
        $statement->execute();

        $result = $statement->get_result();
        if(!$result) {
            throw new Exception($statement->error);
        }

        $rows = array();
        while($row = $result->fetch_object()) {
            $rows[] = $row;
        }

        return $rows;
    }

}