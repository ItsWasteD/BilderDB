<?php

require_once '../repository/UserRepository.php';
require_once '../repository/GalleryRepository.php';

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
            session_start();
            $salt = "gibb.ch";
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!preg_match('@^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$@',$email)) {
                $_SESSION['info'] = array('danger','Not a valid email!');
                header("Location: /user/create");
            }

            if(!(strlen($password) >= 8)) {
                $_SESSION['info'] = array('danger','Password isn\'t long enough.');
                header("Location: /user/create");
            }

            if($password != $_POST['password_repeat']) {
                $_SESSION['info'] = array('danger','The passwords don\'t match!');
                header("Location: /user/create");
            }

            if(preg_match('@[A-Z]+@',$password) && preg_match('@[a-z]*@',$password) && preg_match('@\d+@',$password) && preg_match('@[_\.\-\$\&]+@',$password)) {
                $password = password_hash($password.$salt, PASSWORD_DEFAULT);

                $userRepository = new UserRepository();
                echo "REG MATCH";
                $uid = $userRepository->create($email, $password);

                session_start();

                if($_SESSION['isSuccess']) {
                    $_SESSION['logedIn'] = true;
                    $_SESSION['uid'] = $uid;
                    $_SESSION['email'] = $email;
                }

                unset($_SESSION['isSuccess']);
            } else {
                $_SESSION['info'] = array('danger','Password has to contain at least 1 uppercase, 1 lowercase, 1 number, 1 specialchar(_.-$&) and a has to have a length of 8 chars.');
                header("Location: /user/create");
            }

            header('Location: /user/create');

        }


    }

    public function delete()
    {
        session_start();
        if(!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        if($_GET['id'] == $_SESSION['uid']) {

            $userRepository = new UserRepository();
            $galleryRepository = new GalleryRepository();

            $galleries = $galleryRepository->readByUserId($_GET['id']);

            $picRepo = new PictureRepository();

            foreach($galleries as $gallery) {
                $pics = $picRepo->countByGalleryId($gallery->id);
                foreach ($pics as $pic) {
                    $srv_path = substr($pic->path,1);
                    unlink($srv_path);
                }
            }
            $userRepository->deleteById($_GET['id']);

        } else {
            $_SESSION['info'] = array('danger','You can\'t delete this user!');
        }
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
            $salt = "gibb.ch";
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userRepository = new UserRepository();
            $loginState = $userRepository->login($email,$password.$salt);

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

    public function profil() {
        session_start();
        if(!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $view = new View("user_profil");
        $view->title = "Profil";
        $userRepository = new UserRepository();
        $galleryRepository = new GalleryRepository();
        $view->galleries = $galleryRepository->readByUserId($_SESSION['uid']);
        $view->user = $userRepository->readById($_SESSION['uid']);
        $view->display();
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /");
    }

    public function changePassword() {
        session_start();
        if(!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $view = new View("user_changepw");
        $view->title = "Change password";
        $view->display();
    }

    public function doChangePassword() {
        session_start();
        if(!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $userRepository = new UserRepository();
        $user = $userRepository->readById($_SESSION['uid']);

        $salt = "gibb.ch";
        $newPass = $_POST['password'];
        $passRepeat = $_POST['password_repeat'];

        if(!password_verify($_POST['old_pw'], $user->password)) {
            $_SESSION['info'] = array('danger','Old password doesn\'t match');
            header("Location: /user/changePassword");
        }

        if(!(strlen($newPass) >= 8)) {
            $_SESSION['info'] = array('danger','New password isn\'t long enough!');
            header("Location: /user/changePassword");
        }

        if($newPass != $passRepeat) {
            $_SESSION['info'] = array('danger','New password doesn\'t match the repeated one!');
            header("Location: /user/changePassword");
        }

        if(preg_match('@[A-Z]+@',$newPass) && preg_match('@[a-z]*@',$newPass) && preg_match('@\d+@',$newPass) && preg_match('@[_\.\-\$\&]+@',$newPass)) {
            $userRepository->updatePasswordById(password_hash($newPass.$salt , PASSWORD_DEFAULT), $user->id);
        } else {
            $_SESSION['info'] = array('danger','Password has to contain at least 1 uppercase, 1 lowercase, 1 number, 1 specialchar(_.-$&) and a has to have a length of 8 chars.');
            header("Location: /user/changePassword");
        }

        $_SESSION['info'] = array('success','Password was changed successfully');
        header("Location: /user/profil");

    }
}
