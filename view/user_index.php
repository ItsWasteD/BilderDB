
<?php if (empty($users)): ?>
    <h2 class="well well-bg">Hoopla! Keine User gefunden.</h2>
<?php else:
    if (isset($_SESSION['info'])) {
        $info = $_SESSION['info'];
        echo "<br><div class='alert alert-$info[0]'>$info[1]</div>";
        unset($_SESSION['info']);
    }

    ?>
    <h1>Benutzer</h1>
    <div class="panel-group">
    <?php foreach ($users as $user): ?>

    <div class="panel panel-default">
        <div class="panel-heading"><?= htmlentities($user->email); ?></div>
        <div class="panel-body">
            <p>In der Datenbank existiert ein User mit der Email: <a href="mailto:<?= htmlentities($user->email); ?>"><?= htmlentities($user->email); ?></a></p>
            <p><a title="Löschen" href="/user/delete?id=<?= htmlentities($user->id) ?>">Löschen</a></p>
        </div>
    </div>

    <?php endforeach ?>
    </div>
<?php endif ?>
