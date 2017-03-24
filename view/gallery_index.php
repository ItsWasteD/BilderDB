<div class="row">

<?php if(empty($galleries)) { ?>
    <div class="dhd">
		<h2 class="item title">Hoopla! Keine Gallerie gefunden.</h2>
	</div>
<?php } else {
    foreach ($galleries as $key => $gallery) {
        if($key % 4 == 0) {
            echo "<br>";
        }
        echo "<img src='$gallery->path' class='img-thumbnail' width='300' height='300' >";
    }
}
?>
<a href="/gallery/add"><button type="button" class="btn btn-primary btn-lg">Add gallery</button></a>
</div>