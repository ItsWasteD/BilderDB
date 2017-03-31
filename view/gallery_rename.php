<?php

$form = new Form("/picture/doRename");

echo $form->text()->label("Name")->name("name")->value(htmlentities($pic->name));
echo $form->hidden()->name("pic_id")->value($pic->id);
echo $form->submit()->name("send")->label("Ändern");

$form->end();