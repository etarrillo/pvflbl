

var frm = $("#formcursos");

    frm.submit(function(Event){  

	  Event.preventDefault();  

	  var url = $(this).attr('action');  
	  var datos = $(this).serialize();  
	  $.post(url, datos, function(resultado) {  
	    $('#form-ini').html(resultado);  
  	}); 

});  