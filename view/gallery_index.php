<?php
if(isset($info)) {
    echo "<br><div class='alert alert-$info[0]'>$info[1]</div>";
}

if(empty($galleries)) { ?>
    <h2 class="well">Hoopla! Keine Gallerie gefunden.</h2>
<?php } else {
    foreach ($galleries as $key => $gallery) {
        $path = $pictureRepo->readById($gallery->preview_id)->path;
        if($key % 4 == 0) {
            echo "<br>";
        }
        echo "<img src='$path' class='img-thumbnail' width='300' height='300' ><br>";
    }
}
?>
<a href="/gallery/add"><button type="button" class="btn btn-primary btn-lg">Add gallery</button></a>