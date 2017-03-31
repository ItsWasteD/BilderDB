<h1><b><?= $gallery->name ?></b></h1>
<?php if(empty($images)) { ?>
<h2 class="well well-bg">Keine Bilder gefunden.</h2>
<?php } else {
    if(isset($_SESSION['info'])) {
        $info = $_SESSION['info'];
        echo "<br><div class='alert alert-$info[0]'>$info[1]</div>";
        unset($_SESSION['info']);
    }
    echo "<div class='row'>";
    foreach ($images as $key => $value) {
        if($key % 3 == 0) {
            echo "</div><div class='row'>";
        }
        echo "<div class='col-md-4' ><a href='/picture/edit?pic_id=$value->id'><div class='thumbnail'>";
        echo "<img class='img-thumbnail img-responsive' src='$value->path' alt='" . htmlentities($value->name) . "' >";
        echo "<div class='caption'><p>" . htmlentities($value->name) . "</p></div>";
        echo "</div></a></div>";
    }
    echo "</div>";
} ?>
<a href="/picture?gallery_id=<?= $gallery->id ?>"><button type="button" id="add" class="btn btn-primary btn-lg">Add picture</button></a>