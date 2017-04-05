<br>
<?php
if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    echo "<br><div class='alert alert-$info[0]'>$info[1]</div>";
    unset($_SESSION['info']);
} ?>
<h1>Profil</h1>
<div class="panel-group">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3>Email</h3>
        </div>
        <div class="panel-body">
            <?= $user->email ?>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3>Your galleries</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <?php foreach ($galleries as $key => $gallery) {
                    $picRepo = new PictureRepository();
                    $prev = $picRepo->readById($gallery->preview_id);
                    if (empty($prev)) {
                        $prev = new stdClass();
                        $prev->path = "/images/noprev.jpg";
                        $prev->name = "No preview selected";
                    }

                    if ($key % 4 == 0) {
                        echo "</div><div class='row'>";
                    } ?>

                    <div class="col-md-3">
                        <a href="/gallery/edit?id=<?= htmlentities($gallery->id) ?>">
                            <div class="thumbnail">
                                <img class="img-thumbnail img-responsive" src="<?= htmlentities($prev->path) ?>"
                                     alt="<?= htmlentities($prev->name) ?>">
                                <div class="caption">
                                    <p><?= htmlentities($gallery->name) ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <a href="/user/changePassword"><button class="btn btn-info btn-lg" style="margin-top: 10px">Change password</button></a>
</div>