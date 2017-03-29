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

    public function create($username, $email, $password)
    {
        session_start();
        if(count($this->readByUsername($username)) < 1) {
            $query = "INSERT INTO $this->tableName (username, email, password) VALUES (?, ?, ?)";

            $statement = ConnectionHandler::getConnection()->prepare($query);
            $statement->bind_param('sss', $username, $email, $password);

            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }

            $_SESSION['isSuccess'] = true;

            return $statement->insert_id;
        } else {
            $_SESSION['isSuccess'] = false;
        }
    }

}