<br>
<?php if (empty($users)): ?>
    <h2 class="well well-bg">Hoopla! Keine User gefunden.</h2>
<?php else:
    if (isset($info) && $info) {
        echo "<div class='alert alert-success'>Der Benutzer wurde erfolgreich erstellt!</div>";
    } else if (isset($info) && $info != true) {
        echo "<div class='alert alert-danger'>Der Benutzer existiert bereits!</div>";
    }

    ?>
    <div class="panel-group">
    <?php foreach ($users as $user): ?>

    <div class="panel panel-default">
        <div class="panel-heading"><?= htmlentities($user->username); ?></div>
        <div class="panel-body">
            <p>In der Datenbank existiert ein User mit dem Namen <?= htmlentities($user->username); ?>. Dieser hat
                die EMail-Adresse: <a href="mailto:<?= htmlentities($user->email); ?>"><?= htmlentities($user->email); ?></a></p>
            <p><a title="Löschen" href="/user/delete?id=<?= $user->id ?>">Löschen</a></p>
        </div>
    </div>

    <?php endforeach ?>
    </div>
<?php endif ?>
