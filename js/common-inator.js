/* Users */
	function fncTogglePSN(img){
		var sUserKey = $(img).attr('data-user-key');
		$('#psn_' + sUserKey).slideToggle('slow');
	}

	function fncToggleSteam(img){
		var sUserKey = $(img).attr('data-user-key');
		$('#steam_' + sUserKey).slideToggle('slow');
	}

	function fncToggleXBL(img){
		var sUserKey = $(img).attr('data-user-key');
		$('#xbl_' + sUserKey).slideToggle('slow');
	}

	function fncHandleMissing(img){
		$(img).attr('src', '/img/missing.png');
	}

	function fncToggleCompare(){
		var iChecked = $('input[type=checkbox]:checked').length;
		if (iChecked >= 2){
			// Enable Compare
			$('#compare_btn').removeAttr('disabled');
			$('#compare_btn').addClass('btn-success');
		} else {
			// Disable compare
			$('#compare_btn').attr('disabled', 'disabled');
			$('#compare_btn').removeClass('btn-success');
		}
	}

/* Login */
	function fncLoginReady(){
		try{
			var sEmail = $('#email').val().trim();
			var sPass = $('#pw').val().trim();

			if (sEmail!='' && sPass!=''){
				$('#login_submit_btn').removeAttr('disabled');
				$('#login_submit_btn').addClass('btn-primary');
			} else {
				$('#login_submit_btn').attr('disabled', 'disabled');
				$('#login_submit_btn').removeClass('btn-primary');
			}
		} catch (err){
			//alert(err.message);
		}
	}

/* AJAX */
	function fncUpdateMyPSN(){
	}

	function fncUpdateMyXBL(){
	}

/* Default page load actions */
$(document).ready(function() {
	// Bind detail toggles
	$('.psn_toggle').bind('click', function() { fncTogglePSN(this); });
	$('.steam_toggle').bind('click', function() { fncToggleSteam(this); });
	$('.xbl_toggle').bind('click', function() { fncToggleXBL(this); });

	// Bind compare features
	$('input[type=checkbox]').bind('click', function () { fncToggleCompare(); });

	fncLoginReady();
});