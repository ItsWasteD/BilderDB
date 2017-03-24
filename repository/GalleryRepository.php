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

    public function readThumbnailByAlbumId($id)
    {
        $pictureRepository = new PictureRepository();
        $path = $pictureRepository->readById($id)->path;
        return $path;
    }

}