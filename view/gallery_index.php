<?php
if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    echo "<br><div class='alert alert-$info[0]'>$info[1]</div>";
    unset($_SESSION['info']);
}
echo "<h1>Gallerien</h1>";
if (empty($galleries)) { ?>
    <h2 class="well">Hoopla! Keine Gallerie gefunden.</h2>
<?php } else {
    echo "<br>";
    foreach ($galleries as $key => $gallery) { ?>
        <div class='well'>
            <a href='/gallery/edit?id=<?= htmlentities($gallery->id) ?>'><?= htmlentities($gallery->name) ?> <span
                        class="badge"><?= htmlentities($picRepo->countByGalleryId($gallery->id)->anzahl) ?></span></a>
            <a><span onclick='deleteAlert(<?= htmlentities($gallery->id) ?>)' class='glyphicon glyphicon-trash'
                  style="float:right"></span></a>
            <a href="/gallery/rename?id=<?= htmlentities($gallery->id) ?>"><span class="glyphicon glyphicon-pencil" style="float: right; margin-right: 10px"></span></a>
        </div>
        <?php
    }
}
?>
<a href="/gallery/add">
    <button type="button" class="btn btn-primary btn-lg">Add gallery</button>
</a>
<script>
    function deleteAlert(id) {
        var res = confirm("Willst du die Gallerie wirklich löschen?");
        if (res) {
            window.location.href = "/gallery/delete?id=" + id;
        }
    }
</script>