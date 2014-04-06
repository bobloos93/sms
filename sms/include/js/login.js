$(document).ready(function(){
	$('#login input[type=submit]').click(function(ev){
		ev.preventDefault();
		$.post("/sms/login.php", { name: $.trim($('#login input[type=text]').val()), password: $.trim($('#login input[type=password]').val())}, checkdata);
	});
	
	$('#logout').click(function(){
		$.post("/sms/logout.php", {}, logout);
	});
});

function checkdata(data){
	if(data.indexOf("succes") != -1){
		location.reload();
	} else {
		$('#login').append('<p><strong>Het is niet gelukt je in te loggen. Probeer het opnieuw.</strong></p>');
	}
}

function logout(data){
	if(data.indexOf("succes") != -1){
		location.reload();
	} else {
		$('#login').append('<p><strong>Het is niet gelukt je in te loggen. Probeer het opnieuw.</strong></p>');
	}
}
