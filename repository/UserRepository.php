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

    public function readByUsername($username)
    {
        $query = "SELECT * FROM $this->tableName WHERE username = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $username);
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

    public function login($username, $password)
    {
        $query = "SELECT password FROM $this->tableName WHERE username = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $username);
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
}
