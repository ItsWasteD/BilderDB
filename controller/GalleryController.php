<?php

/**
 * Created by PhpStorm.
 * User: David
 * Date: 23.03.2017
 * Time: 20:02
 */
require_once '../repository/GalleryRepository.php';

class GalleryController
{
    public function index() {
        $galleryRepository = new GalleryRepository();

        $view = new View("gallery_index");
        $view->title = "Gallery";
        $view->style = "/css/gallery.css";
        session_start();
        if(isset($_SESSION['info'])) {
            $view->info = $_SESSION['info'];
            unset($_SESSION['info']);
        }
        $view->galleries = $galleryRepository->readAll();
        $view->pictureRepo = new PictureRepository();
        $view->display();
    }

    public function add() {
        $view = new View("gallery_add");
        $view->title = "Add";
        $view->display();
    }

    public function doAdd() {
        $upload_dir = "images/";
        $upload_file = $upload_dir . basename($_FILES['file']['name']);
        $upload_ok = 1;
        $fileType = pathinfo($upload_file, PATHINFO_EXTENSION);

        if(isset($_POST['send'])) {
            $check = getimagesize($_FILES['file']['tmp_name']);
            if($check !== false) {
                $upload_ok = 1;
            } else {
                $upload_ok = 0;
            }
        }

        if(file_exists($upload_file)) {
            $upload_ok = 0;
        }

        if($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
            $upload_ok = 0;
        }

        $pictureRepository = new PictureRepository();

        $pictureRepository->create(1,$upload_file);

        session_start();

        if(!isset($_SESSION['isSuccess'])) {
            $upload_ok = 0;
        }

        if($upload_ok == 0) {
            $_SESSION['info'] = array("danger","Fehler beim Upload!");
        } else {
            if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                $_SESSION['info'] = array("success","Erfolgreich hochgeladen!");
            } else {
                $_SESSION['info'] = array("danger","Fehler beim Upload!");
            }
        }

        header("Location: /gallery");
    }
}