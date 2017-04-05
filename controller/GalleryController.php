<?php

/**
 * Created by PhpStorm.
 * User: David
 * Date: 23.03.2017
 * Time: 20:02
 */
require_once '../repository/GalleryRepository.php';
require_once '../repository/PictureRepository.php';

class GalleryController
{

    public function index()
    {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $galleryRepository = new GalleryRepository();
        $pictureRepository = new PictureRepository();

        $view = new View("gallery_index");
        $view->title = "Gallerien";
        $view->style = "/css/gallery.css";
        $view->galleries = $galleryRepository->readByUserId($_SESSION['uid']);
        $view->picRepo = $pictureRepository;
        $view->display();
    }

    public function add()
    {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $view = new View("gallery_add");
        $view->title = "Add";
        $view->display();
    }

    public function doAdd()
    {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        if ($_POST['send']) {
            $galleryRepository = new GalleryRepository();

            $name = $_POST['galleriename'];
            $user_id = $_SESSION['uid'];

            $galleryRepository->create($name, $user_id);
        }

        header("Location: /gallery");

    }

    public function edit()
    {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        if(!$this->checkPermission($_SESSION['uid'],$_GET['id'])) {
            $_SESSION['info'] = array('danger','You are not allowed to view this gallery!');
            header("Location: /gallery");
        }

        $view = new View("gallery_edit");
        $galleryRepository = new GalleryRepository();
        $view->gallery = $galleryRepository->readById($_GET['id']);
        $pictureRepository = new PictureRepository();
        $view->images = $pictureRepository->readByGalleryId($_GET['id']);
        $view->title = "Gallerie";
        $view->display();
    }

    public function delete()
    {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $gallery_id = $_GET['id'];
        $user_id = $_SESSION['uid'];

        $pictureRepository = new PictureRepository();
        $pics = $pictureRepository->readByGalleryId($gallery_id);

        if ($this->checkPermission($user_id, $gallery_id)) {
            foreach ($pics as $pic) {
                $path = $pic->path;
                $filepath = substr($path, 1);
                unlink($filepath);
            }

            $galleryRepository = new GalleryRepository();
            $galleryRepository->deleteById($gallery_id);

            $_SESSION['info'] = array('success', 'Die Gallerie wurde erfolgreich gelöscht.');

        } else {
            $_SESSION['info'] = array('danger', 'Der Benutzer hat nicht genügend Rechte.');
        }

        header("Location: /gallery");
    }

    public function setBg() {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $galleryRepository = new GalleryRepository();

        if($this->checkPermission($_SESSION['uid'], $_GET['gid'])) {
            $galleryRepository->updatePrevById($_GET['id'], $_GET['gid']);
        } else {
            $_SESSION['info'] = array('danger','Not allowed to change the preview of this gallery!');
        }
        header("Location: /gallery");
    }

    private function checkPermission($user_id, $gallery_id)
    {
        $galleryRepository = new GalleryRepository();
        $gallery = $galleryRepository->readById($gallery_id);

        $hasPermition = false;

        if ($gallery->user_id == $user_id) {
            $hasPermition = true;
        }

        return $hasPermition;
    }

    public function rename() {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }



    }

}