<?php
echo "<script>
function checkPW() {
	var pwField = document.getElementsByName('password')[0];
	var pwrField = document.getElementsByName('password_repeat')[0];
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

if (isset($_SESSION['info'])) {
    $info = $_SESSION['info'];
    echo "<br><div class='alert alert-$info[0]'>$info[1]</div>";
    unset($_SESSION['info']);
}

$form = new Form('/user/doCreate');

echo $form->text()->label('Email')->name('email')->pattern('^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$')->placeholder("example@domain.tld");
echo $form->password()->label('Passwort')->name('password')->onkeyup('checkPW()');
echo $form->password()->label('Passwort wiederholen')->name('password_repeat')->onkeyup('checkPW()')->placeholder("");
echo $form->submit()->label('Benutzer erstellen')->name('send');

$form->end();
