<?php
if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    echo "<br><div class='alert alert-$info[0]'>$info[1]</div>";
    unset($_SESSION['info']);
}
?>
<h1><?= htmlentities($image->name) ?></h1>
<div class="row">
    <div class="col-md-12">
        <img class="img-thumbnail img-responsive" src="<?= $image->path ?>" alt="<?= htmlentities($image->name) ?>"><br>
        <a href="/picture/delete?id=<?= $image->id ?>">
            <button type="button" class="btn btn-danger btn-lg" style="margin-top: 10px">Delete</button>
        </a>
        <a href="/picture/rename?id=<?= $image->id ?>">
            <button type="button" class="btn btn-warning btn-lg" style="margin-top: 10px">Rename</button>
        </a>
    </div>
</div>