<br>
<div class="jumbotron">
    <h1>Bilder Datenbank</h1>
    <p>Die ist ein GIBB Projekt von David Roth welches wir im Rahmen vom 9.3 bis zum 31.4 machen mussten.</p>
    <?= isset($_SESSION['logedIn']) && $_SESSION['logedIn'] ? "" : '<p class="bg-info">Um Gallerien zu erstellen musst du dich zuerst Registrieren klicke oben auf Gallery</p>' ?>
    <?= isset($_GET['info']) ? "<div class='alert alert-warning'>Du musst dich zuerst einloggen!</div>" : "" ?>
</div>