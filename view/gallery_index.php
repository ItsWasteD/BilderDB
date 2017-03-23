<div class="row">

<?php if(empty($galleries)) { ?>
    <div class="dhd">
		<h2 class="item title">Hoopla! Keine User gefunden.</h2>
	</div>
<?php } else {
    foreach ($galleries as $gallery) {
        echo "<img src='$gallery->path' class='img-thumbnail' width='300' height='300' >";
    }
}
?>

</div>