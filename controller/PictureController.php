<?php

/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 31.03.2017
 * Time: 13:06
 */
require_once "../repository/GalleryRepository.php";
require_once "../repository/PictureRepository.php";

class PictureController
{
    public function index()
    {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $view = new View("picture_add");
        $view->title = "Bild hinzufügen";
        $view->gallery_id = $_GET['gallery_id'];
        $view->display();
    }

    public function doAdd()
    {
        $gallery_id = "";

        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        if (isset($_POST['send']) && isset($_FILES['file'])) {

            $name = $_POST['name'];
            $gallery_id = $_POST['gallery_id'];

            $unique_name = uniqid(true);

            $fileType = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            $unique_name .= "." . $fileType;

            $upload_dir = "images/";
            $db_dir = "/images/" . $unique_name;

            $upload_file = $upload_dir . $unique_name;

            $upload_ok = 1;

            $check = getimagesize($_FILES['file']['tmp_name']);
            if ($check === false) {
                $_SESSION['info'] = array('danger', 'Getimagesize');
                header("Location: /gallery");
            }

            if (file_exists($upload_file)) {
                $_SESSION['info'] = array('danger', 'Image already exists.');
                header("Location: /gallery");
            }

            if ($fileType !== "jpg" && $fileType !== "png" && $fileType !== "jpeg" && $fileType !== "gif") {
                $_SESSION['info'] = array('danger', 'Not an image file.');
                header("Location: /gallery");
            }

            $pictureRepository = new PictureRepository();

            $pictureRepository->create($gallery_id, $db_dir, $name);

            if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                $_SESSION['info'] = array("success", "Erfolgreich hochgeladen!");
            } else {
                $_SESSION['info'] = array("danger", "Fehler beim Dateiupload!");
            }

        } else {
            $_SESSION['info'] = array('danger', "File wasn't sent.");
        }

        header("Location: /gallery/edit?id=$gallery_id");
    }

    public function edit() {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $view = new View("picture_edit");
        $view->title = "Bild bearbeiten";
        $pictureRepository = new PictureRepository();
        $view->image = $pictureRepository->readById($_GET['pic_id']);
        $view->gid = $_GET['gid'];
        $view->display();
    }

    public function rename() {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $pic_id = $_GET['id'];

        $view = new View("gallery_rename");
        $view->title = "Name ändern";
        $pictureRepository = new PictureRepository();
        $view->pic = $pictureRepository->readById($pic_id);
        $view->display();


    }

    public function doRename() {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $name = $_POST['name'];
        $pic_id = $_POST['pic_id'];
        $user_id = $_SESSION['uid'];

        $hasPermition = $this->checkPermission($user_id,$pic_id);

        if($hasPermition) {
            $pictureRepository = new PictureRepository();
            $pictureRepository->updateNameById($pic_id, $name);
            $_SESSION['info'] = array('success','Der Name wurde erfolgreich geändert.');
        } else {
            $_SESSION['info'] = array('danger','Der Benutzer hat nicht genügend Rechte.');
        }

        header("Location: /picture/edit?pic_id=$pic_id");

    }

    public function delete() {
        session_start();
        if (!isset($_SESSION['logedIn']) && !$_SESSION['logedIn']) {
            header("Location: /?info=login");
        }

        $pic_id = $_GET['id'];
        $pictureRepository = new PictureRepository();
        $path = $pictureRepository->readById($pic_id)->path;

        if($this->checkPermission($_SESSION['uid'],$pic_id)) {
            $srv_path = substr($path,1);
            $pictureRepository->deleteById($pic_id);
            unlink($srv_path);
            $_SESSION['info'] = array('success','Das Bild wurde erfolgreich gelöscht.');
        } else {
            $_SESSION['info'] = array('danger','Der Benutzer hat nicht genügend Rechte.');
        }

        header("Location: /gallery");
    }

    private function checkPermission($user_id, $pic_id) {
        $galleryRepository = new GalleryRepository();
        $galleries = $galleryRepository->readByUserId($user_id);

        $hasPermission = false;

        $pictureRepository = new PictureRepository();
        foreach ($galleries as $gallery) {
            $pictures = $pictureRepository->readByGalleryId($gallery->id);
            foreach ($pictures as $picture) {
                $db_pic_id = $picture->id;
                if($db_pic_id == $pic_id) {
                    $hasPermission = true;
                }
            }
        }

        return $hasPermission;
    }
}