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

    public function create($gallery_id, $path)
    {
        $query = "INSERT INTO $this->tableName (gallery_id, path) VALUES (?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('is', $gallery_id, $path);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        session_start();
        $_SESSION['isSuccess'] = true;

        return $statement->insert_id;
    }
}