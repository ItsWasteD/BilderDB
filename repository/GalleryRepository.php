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

            $con = ConnectionHandler::getConnection();

            $name = mysqli_real_escape_string($con, $name);
            $user_id = mysqli_real_escape_string($con, $user_id);

            $statement = $con->prepare($query);
            $statement->bind_param('is', $user_id, $name);

            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }

            $_SESSION['info'] = array('success',"Gallerie wurde erfolgreich erstellt!");

            return $statement->insert_id;
        } else {
            $_SESSION['info'] = array('danger',"Gallerie konnte nicht erstellt werden.");
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

        $row = $result->fetch_object();

        return $row;
    }

    public function readByUserId($uid)
    {
        $query = "SELECT * FROM $this->tableName WHERE user_id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $uid);
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

    public function updatePrevById($prev_id,$id) {
        $query = "UPDATE $this->tableName SET preview_id = ? WHERE id = ?";

        $con = ConnectionHandler::getConnection();

        $prev_id = mysqli_real_escape_string($con, $prev_id);
        $id = mysqli_real_escape_string($con, $id);

        $statement = $con->prepare($query);
        $statement->bind_param('ii',$prev_id,$id);
        $status = $statement->execute();

        if(!$status) {
            throw new Exception($statement->error);
        }

    }

}