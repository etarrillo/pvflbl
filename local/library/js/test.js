$(function(){
    $("#remove").click(function(){
        $("#mform1").submit();
    });
    $("#add").click(function(){
        $("#mform2").submit();
    }); 
       
});
function eliminar(id){
	if (confirm('Realmente deseas eliminarlo')) {
            $.ajax({
                    url: "delete.php",
                    contentType: "application/x-www-form-urlencoded",
                    dataType: "html",
            	    data:"idCurso="+id,
                    error: function(objeto, quepaso, otroobj){
                        alert("Estas viendo esto por que fallé");
                        alert("Pasó lo siguiente: "+quepaso);
                    },
                    success: function(respuesta){
            		//redireccionar
            		window.location.href = respuesta
                    },
                    type: "POST"
            });
		}
}