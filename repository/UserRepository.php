<?php

require_once '../lib/Repository.php';

/**
 * Das UserRepository ist zuständig für alle Zugriffe auf die Tabelle "user".
 *
 * Die Ausführliche Dokumentation zu Repositories findest du in der Repository Klasse.
 */
class UserRepository extends Repository
{
    /**
     * Diese Variable wird von der Klasse Repository verwendet, um generische
     * Funktionen zur Verfügung zu stellen.
     */
    protected $tableName = 'users';

    /**
     * Erstellt einen neuen benutzer mit den gegebenen Werten.
     *
     * Das Passwort wird vor dem ausführen des Queries noch mit dem SHA1
     *  Algorythmus gehashed.
     *
     * @param $firstName Wert für die Spalte firstName
     * @param $lastName Wert für die Spalte lastName
     * @param $email Wert für die Spalte email
     * @param $password Wert für die Spalte password
     *
     * @throws Exception falls das Ausführen des Statements fehlschlägt
     */
    public function create($email, $password)
    {
        session_start();
        if(count($this->readByEmail($email)) < 1) {
            $query = "INSERT INTO $this->tableName (email, password) VALUES (?, ?)";

            $con = ConnectionHandler::getConnection();

            $email = mysqli_real_escape_string($con, $email);
            $password = mysqli_real_escape_string($con, $password);

            $statement = $con->prepare($query);
            $statement->bind_param('ss', $email, $password);

            if (!$statement->execute()) {
                throw new Exception($statement->error);
            }

            $_SESSION['isSuccess'] = true;

            return $statement->insert_id;
        } else {
            $_SESSION['isSuccess'] = false;
        }
    }

    public function readByEmail($email)
    {
        $query = "SELECT * FROM $this->tableName WHERE email = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $email);
        $statement->execute();

        $result = $statement->get_result();
        if(!$result) {
            throw new Exception($statement->error);
        }


        $row = $result->fetch_object();

        return $row;
    }

    public function login($email, $password)
    {
        $query = "SELECT password FROM $this->tableName WHERE email = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $email);
        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $userPW = "";
        while ($row = $result->fetch_object()) {
            $userPW = $row->password;
        }

        return password_verify($password, $userPW);
    }

    public function updatePasswordById($passHash, $uid) {
        $query = "UPDATE $this->tableName SET password = ? WHERE id = ?";

        $con = ConnectionHandler::getConnection();

        $passHash = mysqli_real_escape_string($con, $passHash);
        $uid = mysqli_real_escape_string($con, $uid);

        $statement = $con->prepare($query);
        $statement->bind_param('si',$passHash,$uid);
        $status = $statement->execute();

        if(!$status) {
            throw new Exception($statement->error);
        }

    }
}
