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
        <img class="img-thumbnail img-responsive" src="<?= htmlentities($image->path) ?>" alt="<?= htmlentities($image->name) ?>"><br>
        <button type="button" onclick="history.back()" class="btn btn-primary btn-lg" style="margin-top: 10px">Back</button>
        <button type="button" onclick="deleteAlert(<?= htmlentities($image->id) ?>)" class="btn btn-danger btn-lg" style="margin-top: 10px">Delete</button>
        <a href="/picture/rename?id=<?= htmlentities($image->id) ?>">
            <button type="button" class="btn btn-warning btn-lg" style="margin-top: 10px">Rename</button>
        </a>
        <a href="/gallery/setBg?id=<?= htmlentities($image->id) ?>&gid=<?= htmlentities($gid) ?>">
            <button type="button" class="btn btn-info btn-lg" style="margin-top: 10px">Set as gallery preview</button>
        </a>
    </div>
</div>
<script>
    function deleteAlert(id) {
        var res = confirm("Willst du dieses Bild wirklich löschen?");
        if(res) {
            window.location.href = "/picture/delete?id=" + id;
        }
    }
</script>