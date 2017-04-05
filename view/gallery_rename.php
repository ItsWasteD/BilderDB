<?php


$form = new Form("/gallery/doRename");

echo $form->text()->label("Name")->name("name")->value(htmlentities($pic->name));
echo $form->hidden()->name("pic_id")->value(htmlentities($pic->id));
echo $form->submit()->name("send")->label("Change");

$form->end();

?>

