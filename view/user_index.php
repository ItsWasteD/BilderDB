<br>
<article class="hreview open special">
	<?php if (empty($users)): ?>
		<div class="dhd">
			<h2 class="item title">Hoopla! Keine User gefunden.</h2>
		</div>
	<?php else:
        if (isset($info) && $info) {
            echo "<div class='alert alert-success'>Der Benutzer wurde erfolgreich erstellt!</div>";
        } else if (isset($info) && $info != true) {
	        echo "<div class='alert alert-danger'>Der Benutzer existiert bereits!</div>";
        }

		?>
		<?php foreach ($users as $user): ?>

			<div class="panel panel-default">
				<div class="panel-heading"><?= $user->username;?></div>
				<div class="panel-body">
					<p class="description">In der Datenbank existiert ein User mit dem Namen <?= $user->username;?>. Dieser hat die EMail-Adresse: <a href="mailto:<?= $user->email;?>"><?= $user->email;?></a></p>
					<p>
						<a title="Löschen" href="/user/delete?id=<?= $user->id ?>">Löschen</a>
					</p>
				</div>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</article>
