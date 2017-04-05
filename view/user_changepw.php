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

$form = new Form("/user/doChangePassword");

echo $form->password()->label("Old Password")->name("old_pw");
echo $form->password()->label('New passwort')->name('password')->onkeyup('checkPW()');
echo $form->password()->label('Repeat password')->name('password_repeat')->onkeyup('checkPW()')->placeholder("");
echo $form->submit()->label('Change password')->name('send');

$form->end();