function agregar_ayuda(){

	//var image="";
	var image = "/roa/web/bundles/ROA/images/help.svg";

	//var image2 = "/ROA/web/bundles/ROA/images/button1small.png";

	/*$('.help, .help2').each(function(){
		$(this).remove();
	});*/


	$('input.input_form, input.fecha, select.select_form').each(function(){

		
		/*le pongo al div contenedor del label y el input la
		propiedad relative para que luego el mensaje de error (del servidor)
		se posicione con respecto al div contenedor*/
		$(this).parent().attr('style', 'position:relative');


		var id = $(this).attr('id');

		elem = $(this).prev();
		/*Si el elemento es un ul significa que se imprimio el mensaje
		de error de la validacion del servidor, por lo tanto la estructura
		del formulario cambia*/
		if (elem[0].tagName == 'UL'){

			aux = $(this).prev().prev().html();
			aux = '<a class="help" id="'+id+'_help"><img src="'+image+'"></a>'+aux;
			$(this).prev().prev().html(aux);
			
		}else{
			aux = $(this).prev().html();
			aux = '<a class="help" id="'+id+'_help"><img src="'+image+'"></a>'+aux;
			$(this).prev().html(aux);
		}

		tipo = $(this).attr('tipo');
		switch (tipo){
			case 'requerido':
				image2 = "/roa/web/bundles/ROA/images/button1small.png";
				$(this).parent().append('<a class="leyenda_icono" id="'+id+'_help"><img src="'+image2+'" class="asterisco"></a>');
				break;
			case 'opcional':
				//image2 = "/ROA/web/bundles/ROA/images/button2small.png";
				break;
			case 'recomendado':
				image2 = "/roa/web/bundles/ROA/images/button3small.png";
				$(this).parent().append('<a class="leyenda_icono" id="'+id+'_help"><img src="'+image2+'" class="asterisco"></a>');
				break;
		}
		//$(this).parent().append('<a class="leyenda_icono" id="'+id+'_help"><img src="'+image2+'"></a>');
	});

	$('textarea.textarea_form').each(function(){

		/*le pongo al div contenedor del label y el input la
		propiedad relative para que luego el mensaje de error
		se posicione con respecto al div contenedor*/
		$(this).parent().attr('style', 'position:relative');

		var id = $(this).attr('id');

		elem = $(this).prev();
		/*Si el elemento es un ul significa que se imprimio el mensaje
		de error de la validacion del servidor, por lo tanto la estructura
		del formulario cambia*/
		if (elem[0].tagName == 'UL'){

			aux = $(this).prev().prev().html();
			aux = '<a class="help" id="'+id+'_help"><img src="'+image+'"></a>'+aux;
			$(this).prev().prev().html(aux);
			
		}else{
			aux = $(this).prev().html();
			aux = '<a class="help" id="'+id+'_help"><img src="'+image+'"></a>'+aux;
			$(this).prev().html(aux);
		}

		tipo = $(this).attr('tipo');
		switch (tipo){
			case 'requerido':
				image2 = "/roa/web/bundles/ROA/images/button1small.png";
				$(this).parent().append('<a class="leyenda_icono2" id="'+id+'_help"><img src="'+image2+'"  class="asterisco"></a>');
				break;
			case 'opcional':
				//image2 = "/roa/web/bundles/ROA/images/button2small.png";
				break;
			case 'recomendado':
				image2 = "/roa/web/bundles/ROA/images/button3small.png";
				$(this).parent().append('<a class="leyenda_icono2" id="'+id+'_help"><img src="'+image2+'" class="asterisco"></a>');
				break;
		}
		//$(this).parent().append('<a class="leyenda_icono2" id="'+id+'_help"><img src="'+image2+'"></a>');
	});

	$('.help, .help2').each(function(){
		$(this).click(function(){
			id = $(this).attr('id');
			openHelp('dialog-message-'+id);

		});
	});
	
}

function openHelp(id){
	//$('[id ^='+id+']').dialog({
    $( "#"+id ).dialog({
        position: { my: 'center', at: 'center', of: window },
        height: 'auto',
        width: 600,
        modal: true,
        buttons: {
        /*Ok: function() {
          $( this ).dialog( "cerrar" );
        }*/
        }
    }); 
    return false;  
}


function agregar_ayuda_FormEmbebido(id, id_dialog_message){

  	var image = "/roa/web/bundles/ROA/images/help.svg";

  	label = $('#'+id).parent().find('label');
  	aux = label.html();
	aux = '<a class="help" id="'+id+'_help"><img src="'+image+'"></a>'+aux;
	label.html(aux);
	$('#'+id+'_help').click(function(){
      openHelp(id_dialog_message);
    });
    /*$('#'+id).parent().prepend('<a class="help" id="'+id+'_help"><img src="'+image+'"></a>');
    $('#'+id+'_help').click(function(){
      openHelp(id_dialog_message);
    });*/

	tipo = $('#'+id).attr('tipo');
		switch (tipo){
			case 'requerido':
				image2 = "/roa/web/bundles/ROA/images/button1small.png";
				$('#'+id).parent().append('<a class="leyenda_icono" id="'+id+'_help"><img src="'+image2+'"></a>');
				break;
			case 'opcional':
				//image2 = "/roa/web/bundles/ROA/images/button2small.png";
				break;
			case 'recomendado':
				image2 = "/roa/web/bundles/ROA/images/button3small.png";
				$('#'+id).parent().append('<a class="leyenda_icono" id="'+id+'_help"><img src="'+image2+'"></a>');
				break;
		}
	//$('#'+id).parent().append('<a class="leyenda_icono" id="'+id+'_help"><img src="'+image2+'"></a>');
}

function agregar_ayuda_entidad(){
	$('.help_entidad').click(function(){
		openHelp('dialog-message-OA_form_x_entidades_x');
	});
}



