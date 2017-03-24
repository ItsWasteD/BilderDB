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
        $view->heading = "Gallery";
        $view->style = "/css/gallery.css";
        $view->galleries = $galleryRepository->readAll();
        $view->db = $galleryRepository;
        $view->display();
    }
}