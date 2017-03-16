<?php
echo "<script>
function checkPW() {
	var pwField = document.getElementsByName('passwort')[0];
	var pwrField = document.getElementsByName('passwort_wiederholen')[0];
	if(pwField.value != pwrField.value) {
		pwrField.style.border = 'solid 1px red';
	} else {
		pwrField.style.removeProperty('border');
	}
}</script>";

$form = new Form('/user/doCreate');

echo $form->text()->label('Username')->name('username');
echo $form->text()->label('Email')->name('email');
echo $form->password()->label('Passwort')->name('passwort')->onkeydown('checkPW()');
echo $form->password()->label('Passwort wiederholen')->name('passwort_wiederholen')->onkeydown('checkPW()');
echo $form->submit()->label('Benutzer erstellen')->name('send');

$form->end();
