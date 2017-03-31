<?php

require_once '../repository/UserRepository.php';

/**
 * Siehe Dokumentation im DefaultController.
 */
class UserController
{
    public function index()
    {
        session_start();
        if(!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $userRepository = new UserRepository();

        $view = new View('user_index');
        $view->title = 'Benutzer';
        $view->heading = 'Benutzer';
        if (isset($_SESSION['isSuccess'])) {
            $view->info = $_SESSION['isSuccess'];
            unset($_SESSION['isSuccess']);
        }
        $view->users = $userRepository->readAll();
        $view->display();
    }

    public function create()
    {
        $view = new View('user_create');
        $view->title = 'Benutzer erstellen';
        $view->heading = 'Benutzer erstellen';
        $view->display();
    }

    public function doCreate()
    {
        if ($_POST['send']) {
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $userRepository = new UserRepository();
            $userRepository->create($email, $password);
        }

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        header('Location: /user');
    }

    public function delete()
    {
        session_start();
        if(!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $userRepository = new UserRepository();
        $userRepository->deleteById($_GET['id']);

        // Anfrage an die URI /user weiterleiten (HTTP 302)
        header('Location: /user');
    }

    public function login() {
        $view = new View("user_login");
        $view->title = "Anmelden";
        $view->heading = "Login";
        session_start();
        if(isset($_SESSION['info'])) {
            $view->info = $_SESSION['info'];
            unset($_SESSION['info']);
        }
        $view->display();
    }

    public function doLogin() {
        if ($_POST['send']) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userRepository = new UserRepository();
            $loginState = $userRepository->login($email,$password);

            session_start();

            if($loginState) {
                $_SESSION['logedIn'] = true;
                $_SESSION['email'] = $email;
                $_SESSION['uid'] = $userRepository->readByEmail($email)->id;
                header("Location: /user");
            } else {
                $_SESSION['info'] = false;
                header("Location: /user/login");
            }
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /");
    }
}
