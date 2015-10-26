$(function(){
	//evento que se produce al hacer clic en el boton cerrar de la ventana
	$('.clsVentanaCerrar').live('click',function(eEvento){
	
		eEvento.preventDefault();
	
		var $objVentana=$($(this).parents().get(1));
		
		$objVentana.fadeOut(300,function(){
			
			$(this).remove();
			
			$('#divOverlay').fadeOut(500,function(){
				
				$(this).remove();
			});
		});
	});


  


	
	$('.clsVentanaIFrame').on('click',function(eEvento){
		
		eEvento.preventDefault();
		var strPagina=$(this).attr('href'), strTitulo=$(this).attr('rel');
		var $objVentana=$('<div class="clsVentana">'), $objVentanaTitulo=$('<div class="clsVentanaTitulo">');
		
		$objVentanaTitulo.append('<strong>'+strTitulo+'</strong>');
		$objVentanaTitulo.append('<a href="" class="clsVentanaCerrar">Cerrar</a>');
		$objVentana.append($objVentanaTitulo);
	
		var $objVentanaContenido=$('<div class="clsVentanaContenido">');
		
		$objVentanaContenido.append('<iframe src="'+strPagina+'">')
	
		$objVentana.append($objVentanaContenido);
		
		var $objOverlay=$('<div id="divOverlay">').css({
			opacity: .5,
			display: 'none'
		});
		$('body').append($objOverlay);
		$objOverlay.fadeIn(function(){
		
			$('body').append($objVentana);
		
			$objVentana.fadeIn();
		})
	});



});