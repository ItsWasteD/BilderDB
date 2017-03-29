<br>
<?php

$form = new Form("/gallery/doAdd");

echo $form->text()->label("Galleryname")->name("galleryname");
echo $form->file()->label("Bilder")->name("file");
echo $form->submit()->label("Upload")->name("send");

$form->end();