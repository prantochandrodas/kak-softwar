$(function () {
	$('#frmbutton').click(function () {

		$(".pd3").each(function () {
			if ($(this).val().trim() == '')
				$(this).css('border-color', 'red');
			else
				$(this).css('border-color', '');
		});
		var name = $("#senderName").val();
		var email = $("#senderMail").val();
		var subject = $("#form_subject").val();
		var message = $("#form_message").val();
		if (name == '') {
			$("#senderName").css('border-color', 'red');
			return false;
		}

		if (email == '') {
			$("#senderMail").css('border-color', 'red');
			return false;
		}
		if (IsEmail(email) == false) {
			$("#senderMail").css('border-color', 'red');
			return false;
		}
		if (subject == '') {
			$("#form_subject").css('border-color', 'red');
			return false;
		}
		if (message == '') {
			$("#form_message").css('border-color', 'red');
			return false;
		}
		var dataString = "name=" + name + "&email=" + email + "&subject=" + subject + '&message=' + message;

		$.ajax({
			type: "POST",
			url: "submitfromdata.php",
			data: dataString,
			success: function (data) {
				$("#senderName").val('');
				$("#senderMail").val('');
				$("#form_subject").val('');
				$("#form_message").val('');
				alert("Message sent successfully.");

			}
		});
	});

	function IsEmail(email) {
		var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!regex.test(email)) {
			return false;
		} else {
			return true;
		}
	}
});
