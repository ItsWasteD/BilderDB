<?php

$form = new Form("/picture/doAdd");

echo $form->text()->label("Name")->name("name");
echo $form->file()->label("Bild")->name("file");
echo $form->hidden()->name("gallery_id")->value(htmlentities($gallery_id));
echo $form->submit()->label("Hinzufügen")->name("send");

$form->end();