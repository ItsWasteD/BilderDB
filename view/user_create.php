<?php
echo "<script>
function checkPW() {
	var pwField = document.getElementsByName('passwort')[0];
	var pwrField = document.getElementsByName('passwort_wiederholen')[0];
	var submit = document.getElementsByName('send')[0];
	if(pwField.value != pwrField.value) {
		pwrField.style.border = 'solid 1px red';
		submit.disabled = true;
	} else {
		pwrField.style.removeProperty('border');
		submit.disabled = false;
	}
	console.log(pwField.value + ' and ' + pwrField.value);
}</script>";

$form = new Form('/user/doCreate');

echo $form->text()->label('Username')->name('username');
echo $form->text()->label('Email')->name('email')->pattern('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$');
echo $form->password()->label('Passwort')->name('passwort')->onkeyup('checkPW()');
echo $form->password()->label('Passwort wiederholen')->name('passwort_wiederholen')->onkeyup('checkPW()');
echo $form->submit()->label('Benutzer erstellen')->name('send');

$form->end();
