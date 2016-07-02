jQuery(document).ready(function($)) {
	var $form_modal = $('.modal'),
	    $form_login = $form_modal.find('#login-form'),
	    $form_signup = $form_modal.find('#signup-form'),
	    $btn_signup = $('#signup-btn'),
	    $pwd_forget = $('#forget'),
//$form_modal.on('shown.bs.modal', function () {
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    $btn_signup.on('click', signup_selected());
    $pwd_forget.on('click', signup_selected());
//}

	function signup_selected() {
		$form_login.removeClass('.visible');
		$form_login.addClass('.invisible');
		$form_signup.addClass('.visible');
		$form_signup.removeClass('.invisible');
	}
}