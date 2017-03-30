<br>
<?php

$form = new Form("/gallery/doAdd");

echo $form->text()->label("Galleriename")->name("galleriename");
echo $form->submit()->label("Erstellen")->name("send");

$form->end();