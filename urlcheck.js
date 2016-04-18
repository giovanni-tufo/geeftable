$(document).ready(function(){
$('#username').keyup(username_check);
});

function username_check(){

var username = $('#username').val();

if(username == ""){
$('#tick').hide();
}else{

jQuery.ajax({
   type: "POST",
   url: "check.php",
   data: 'username='+ username,
   cache: false,
   success: function(response){
if(response == 1){
	$('#username').css('border', '1px #C33 solid');
        $('#username').css('-moz-box-shadow','0 0 8px rgba(204,51,51,0.8)');
        $('#username').css('-webkit-box-shadow','0 0 8px rgba(204,51,51,0.8)');
        $('#username').css('box-shadow','0 0 8px rgba(204,51,51,0.8)');
	$('#tick').hide();
	$('#cross').fadeIn();
	}else{
	$('#username').css('border', '1px #090 solid');
        $('#username').css('-moz-box-shadow', '0 0 8px rgba(0,153,0,0.8)');
        $('#username').css('-webkit-box-shadow', '0 0 8px rgba(0,153,0,0.8)');
        $('#username').css('box-shadow', '0 0 8px rgba(0,153,0,0.8)');
	$('#cross').hide();
	$('#tick').fadeIn();
	     }

}
});
}

}
