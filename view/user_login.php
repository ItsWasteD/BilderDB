<?php
if(isset($info) && !$info) {
    echo "<br><div class='alert alert-danger'>Login fehlgeschlagen!</div>";
}

$form = new Form("/user/doLogin");

echo $form->text()->label('Username')->name('username');
echo $form->password()->label('Passwort')->name('password');
echo $form->submit()->label('Login')->name('send');

$form->end();