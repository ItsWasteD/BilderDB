<?php
if(isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    echo "<br><div class='alert alert-$info[0]'>$info[1]</div>";
    unset($_SESSION['info']);
}

if(empty($galleries)) { ?>
    <h2 class="well">Hoopla! Keine Gallerie gefunden.</h2>
<?php } else {
    echo "<br>";
    foreach ($galleries as $key => $gallery) {
        if ($gallery->user_id === $_SESSION['uid']) { ?>
            <div class='well'>
                <a href='/gallery/edit?id=<?= $gallery->id ?>'><?= htmlentities($gallery->name) ?> <span class="badge"><?= $picRepo->countByGalleryId($gallery->id)->anzahl ?></span></a>
                <span onclick='deleteAlert(<?= $gallery->id ?>)' class='glyphicon glyphicon-trash' style="float:right"></span>
            </div>
        <?php }
    }
}
?>
<a href="/gallery/add"><button type="button" id="add" class="btn btn-primary btn-lg">Add gallery</button></a>
<script>
    function deleteAlert(id) {
        var res = confirm("Willst du die Gallerie wirklich löschen?");
        if(res) {
            window.location.href = "/gallery/delete?id=" + id;
        }
    }
</script>