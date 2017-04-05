<?php


require_once '../lib/Repository.php';

/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 24.03.2017
 * Time: 15:32
 */
class PictureRepository extends Repository
{

    protected $tableName = 'pictures';

    public function create($gallery_id, $path, $name)
    {
        $query = "INSERT INTO $this->tableName (gallery_id, path, name) VALUES (?, ?, ?)";

        $con = ConnectionHandler::getConnection();

        $gallery_id = mysqli_real_escape_string($con, $gallery_id);
        $path = mysqli_real_escape_string($con, $path);
        $name = mysqli_real_escape_string($con, $name);

        $statement = $con->prepare($query);
        $statement->bind_param('iss', $gallery_id, $path, $name);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }


        return $statement->insert_id;
    }

    public function readByGalleryId($gallery_id) {
        $query = "SELECT * FROM $this->tableName WHERE gallery_id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $gallery_id);

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

    public function updateNameById($pic_id, $name) {
        $query = "UPDATE $this->tableName SET name = ? WHERE id = ?";

        $con = ConnectionHandler::getConnection();

        $pic_id = mysqli_real_escape_string($con, $pic_id);
        $name = mysqli_real_escape_string($con, $name);

        $statement = $con->prepare($query);
        $statement->bind_param('si',$name,$pic_id);

        $status = $statement->execute();

        if(!$status) {
            throw new Exception($statement->error);
        }
    }

    public function countByGalleryId($id) {
        $query = "SELECT COUNT(*) AS 'anzahl' FROM $this->tableName WHERE gallery_id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i',$id);

        $statement->execute();

        $result = $statement->get_result();
        if(!$result) {
            throw new Exception($statement->error);
        }

        $row = $result->fetch_object();

        return $row;
    }
}