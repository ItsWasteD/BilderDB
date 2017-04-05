<?php
if(isset($info) && !$info) {
    echo "<br><div class='alert alert-danger'>Login fehlgeschlagen!</div>";
}

$form = new Form("/user/doLogin");

echo $form->text()->label('Email')->name('email');
echo $form->password()->label('Passwort')->name('password')->placeholder("");
echo $form->submit()->label('Login')->name('send');

$form->end();