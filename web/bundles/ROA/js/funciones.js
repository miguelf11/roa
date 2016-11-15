// JavaScript Document
//form: nombre del formulario, before_send: funcion a ejecutar antes de hacer la llamada, 
//ubicacion: elemento del DOM donde se cargará la respuesta del servidor
function enviarForm(form, before_send, ubicacion){
	/*$.ajax({
		type: 'POST',
		url: $('#'+form).attr('action'),
		data: $('#'+form).serialize(),
		beforeSend: function(){
			 eval(before_send);
			 var aux = "{{ asset('bundles/ROA/images/cargando.gif') }}";
			 $('#'+ubicacion).html('<div id="cargando"> <img src="<img src="'+aux+'"/> width="50" height="50"/><br><p>Cargando...</p></div>');
		},
		success: function(datos) {
			$('#'+ubicacion).html(datos);
		},
	});*/
	return false;
  alert("probando");
}


function enviarForm2(form, ubicacion, beforeSend, success){
  $.ajax({
    type: 'POST',
    url: $('#'+form).attr('action'),
    data: $('#'+form).serialize(),
    beforeSend: function(){
       //eval(beforeSend);
        var aux = "/roa/web/bundles/ROA/images/cargando3.gif";
        $('#'+ubicacion).html('<div class="cargando" style=""><img src="'+aux+'"/><p>Cargando...</p></div>');
    },
    success: function(datos) {
      $('.cargando').remove();
      $('#'+ubicacion).html(datos);
    },
  });
  return false;
}



function ajax(url, ubicacion, beforeSend, success){
    $.ajax({
            type: 'GET',
            url: url,
            data: '',
            beforeSend: function(){
                eval(beforeSend);
                var aux = "/roa/web/bundles/ROA/images/cargando3.gif";
                $('#'+ubicacion).html('<center><div class="cargando" style=""><img src="'+aux+'"/><p>Cargando...</p></div></center>');
  
            },
            success: function(datos) {
                $('#'+ubicacion).html(datos);
            },
        });
        return false;
}


function ajax2(url, ubicacion, beforeSend, success){
    $.ajax({
            type: 'POST',
            url: url,
            data: '',
            beforeSend: function(){
                eval(beforeSend);
            },
            success: function(datos) {
                openMessage();
                $('#'+ubicacion).html(datos);

            },
        });
        return false;
}

function openMessage(){
    $( "#dialog-message" ).dialog({
        position: { my: 'center', at: 'top' },
        height: 380,
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

function openMessage_metadatos(){
    $( "#dialog-message-metadatos" ).dialog({
        position: { my: 'center', at: 'top' },
        height: 'auto',
        width: 678,
        modal: true,
        buttons: {
        /*Ok: function() {
          $( this ).dialog( "cerrar" );
        }*/
        }
    }); 
    return false;  
}

function openWindow(id, width, height){
    $( "#"+id ).dialog({
        position: { my: 'center', at: 'center', of: window },
        height: height,
        width: width,
        modal: true,
        buttons: {
        }
    }); 
    return false;  
}


function validarForm(){
	/*alert("validacion aqui");*/
}

function sendForm(path, method){
	
	var action = $("#form").attr("action");
	$("#form").attr("action" , action+path);
	$("#method").attr("value", method);
	//alert(path);
	//alert(method);
	action = $("#form").attr("action");
	//alert(action);
	$("#form").submit();
}

function eliminar_objeto(path, method){
     $( "#dialog-confirm" ).dialog({
      resizable: false,
      height:160,
      modal: true,
      buttons: {
        "Si": function() {
          sendForm(path, method);
        },
        "No": function() {
          $( this ).dialog( "close" );
        }
      }
    });
    /*if(confirm("\u00bfSeguro que desea eliminar este objeto?")){
        sendForm(path, method);
    }*/
}


function eliminar(form){
  $( "#dialog-confirm" ).dialog({
      resizable: false,
      height:160,
      modal: true,
      buttons: {
        "Si": function() {
          $('#'+form).submit();
        },
        "No": function() {
          $( this ).dialog( "close" );
        }
      }
    });
}

function submit_form(form){
  $("#"+form).submit();
}















//Contribuciones
function agregar_contribuciones(){

	// Obtiene el div que contiene la colección de etiquetas
	//var collectionHolder = $('div#MetaMetadata_form_contribuciones');
	var collectionHolder = $('ul.contribuciones');

	// configura una enlace "Agregar una etiqueta"
	var $addContribucionLink = $('<a href="#" class="add_contribucion_link">Agregar contribucion</a>');
	var $newLinkLi = $('<li class="li_add_contribucion"></li>').append($addContribucionLink);

	//jQuery(document).ready(function() {
	    // Añade el ancla "Agregar una etiqueta" y las etiquetas li y ul
	    collectionHolder.append($newLinkLi);

	    $addContribucionLink.on('click', function(e) {
	        // evita crear el enlace con una "#" en la URL
	        e.preventDefault();

	        // añade una nueva etiqueta form (ve el siguiente bloque de código)
	        addContribucionForm(collectionHolder, $newLinkLi);
	    });

      collectionHolder.find('.contribucion').each(function() {
        addContribucionFormDeleteLink($(this));
      });
}

function addContribucionForm(collectionHolder, $newLinkLi) {
    // Obtiene el data-prototype explicado anteriormente
    var prototype = collectionHolder.attr('data-prototype');

    // cuenta las entradas actuales en el formulario (p. ej. 2),
    // lo usa como el nuevo índice (p. ej. 2)
    var newIndex = collectionHolder.find(':input').length;
    
    //alert(newIndex);

    // Reemplaza el '__name__' en el prototipo HTML para que
    // en su lugar sea un número basado en cuántos elementos hay
    var newForm = prototype.replace(/__name__/g, newIndex);

   // newIndex = 0;

    // Muestra el formulario en la página en un elemento li,
    // antes del enlace 'Agregar una etiqueta'
  	//var $newFormLi = $('<li><p class="titulo_modulo" style="margin-bottom:20px">Contribuci&oacute;n</p></li>').append(newForm);
  	var $newFormLi = $('<fieldset class=subform><legend>Contribucion</legend></fieldset>').append(newForm);


    $newLinkLi.before($newFormLi);

    $(".fecha").datepicker({ dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ], monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ], changeYear: true, nextText: "Siguiente", prevText: "Anterior", dateFormat: "dd-mm-yy" });

   addContribucionFormDeleteLink($newFormLi);

    var entidad = $('div#OA_form_metametadata_contribuciones_'+newIndex+'_entidades');
    //var aux = newForm.attr('id');
   // alert(aux);
   //var entidad = $('#'+aux+'_entidades');


   agregar_entidades(entidad);

  /*Para los mensajes de ayuda en los formularios embebidos*/

  var id = 'OA_form_metametadata_contribuciones_'+newIndex+'_rol';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_metametadata_contribuciones_x_rol_help');

  id = 'OA_form_metametadata_contribuciones_'+newIndex+'_fecha';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_metametadata_contribuciones_x_fecha_help');


    //$newLinkLi.before($newFormLi);
}


function addContribucionFormDeleteLink($contribucionFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $contribucionFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // evita crear el enlace con una "#" en la URL
        e.preventDefault();

        $( "#dialog-confirm" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
              $contribucionFormLi.remove(); 
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });

        //if(confirm("\u00bfSeguro que desea eliminar esta contribucion?")){
          // quita el li de la etiqueta del formulario
            //$contribucionFormLi.remove();  
       // }

        
    });
    return false;
}

//Entidades
function agregar_entidades(entidad){


	// Obtiene el div que contiene la colección de etiquetas
	//var collectionHolder = $('ul.entidades');
	var collectionHolder2 = entidad;

	// configura una enlace "Agregar una etiqueta"
  var image = '/roa/web/bundles/ROA/images/help.svg';
  var link_ayuda = '<a class="help_entidad" id=""><img src="'+image+'"></a>';

	var $addEntidadLink = $('<a href="#" class="add_entidad_link">Agregrar entidad</a>');
	var $newLinkLi2 = $('<li class="li_entidad"></li>').append($addEntidadLink);

  $newLinkLi2.append(link_ayuda);

	//jQuery(document).ready(function() {
	    // Añade el ancla "Agregar una etiqueta" y las etiquetas li y ul
	    collectionHolder2.append($newLinkLi2);

      agregar_ayuda_entidad();

	    $addEntidadLink.on('click', function(e) {
	        // evita crear el enlace con una "#" en la URL
	        e.preventDefault();

	        // añade una nueva etiqueta form (ve el siguiente bloque de código)
	        addEntidadForm(collectionHolder2, $newLinkLi2);
	    });
}

function addEntidadForm(collectionHolder2, $newLinkLi2) {
    // Obtiene el data-prototype explicado anteriormente
    var prototype2 = collectionHolder2.attr('data-prototype');

    // cuenta las entradas actuales en el formulario (p. ej. 2),
    // lo usa como el nuevo índice (p. ej. 2)
    var newIndex2 = collectionHolder2.find(':input').length;

   // newIndex2 = 3;

    // Reemplaza el '__name__' en el prototipo HTML para que
    // en su lugar sea un número basado en cuántos elementos hay

    //var newForm2 = prototype2.replace(/__name2__label__/g, 'enti');
  	var newForm1 = prototype2.replace(/__name2__/g, newIndex2);
    newForm2 = newForm1.replace(newIndex2+'label__', '');

    // Muestra el formulario en la página en un elemento li,
    // antes del enlace 'Agregar una etiqueta'
    //var $newFormLi2 = $('<li class="li_entidad" ></li>').append(newForm2);
    var $newFormLi2 = $('<fieldset class=subform2><legend>Entidad</legend></fieldset>').append(newForm2);
    $newLinkLi2.before($newFormLi2);

    addEntidadFormDeleteLink($newFormLi2);

}

function addEntidadFormDeleteLink($entidadFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $entidadFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm2" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
              $entidadFormLi.remove();
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });
        /*if(confirm("\u00bfSeguro que desea eliminar esta entidad?")){
            $entidadFormLi.remove();
        }*/
    });
    return false;
}


//Anotaciones
function agregar_anotaciones(){

	var collectionHolder = $('ul.anotaciones');
	var $addAnotacionLink = $('<a href="#" class="add_anotacion_link">Agregar anotacion</a>');
	var $newLinkLi = $('<li class="li_add_anotacion"></li>').append($addAnotacionLink);
	collectionHolder.append($newLinkLi);
	$addAnotacionLink.on('click', function(e) {
	        e.preventDefault();
	        addAnotacionForm(collectionHolder, $newLinkLi);
	    });

  collectionHolder.find('.anotacion').each(function() {
        addAnotacionFormDeleteLink($(this));
  });
}

function addAnotacionForm(collectionHolder, $newLinkLi) {

    var prototype = collectionHolder.attr('data-prototype');
    var newIndex = collectionHolder.find(':input').length;
    var newForm = prototype.replace(/__name__/g, newIndex);
  	var $newFormLi = $('<fieldset class=subform><legend>Anotacion</legend></fieldset>').append(newForm);
    $newLinkLi.before($newFormLi);

   $(".fecha").datepicker({ dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ], monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ], changeYear: true, nextText: "Siguiente", prevText: "Anterior", dateFormat: "dd-mm-yy" });

    addAnotacionFormDeleteLink($newFormLi);

    var entidad = $('div#OA_form_anotaciones_'+newIndex+'_entidades');

   agregar_entidades(entidad);

   /*Para los mensajes de ayuda en los formularios embebidos*/
   var image = "/roa/web/bundles/ROA/images/help.svg";

   var id = 'OA_form_anotaciones_'+newIndex+'_fecha';
   agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_anotaciones_x_fecha_help');

   id = 'OA_form_anotaciones_'+newIndex+'_descripcion';
   agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_anotaciones_x_descripcion_help');

}

function addAnotacionFormDeleteLink($anotacionFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $anotacionFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm3" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
               $anotacionFormLi.remove(); 
               $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });
        /*if(confirm("\u00bfSeguro que desea eliminar esta anotacion?")){
            $anotacionFormLi.remove();
        }*/
    });
    return false;
}

//Clasificaciones
function agregar_clasificaciones(){

	var collectionHolder = $('ul.clasificaciones');
	var $addClasificacionLink = $('<a href="#" class="add_clasificacion_link">Agregar clasificacion</a>');
	var $newLinkLi = $('<li class="li_add_clasificacion"></li>').append($addClasificacionLink);


	collectionHolder.append($newLinkLi);
	$addClasificacionLink.on('click', function(e) {
	        e.preventDefault();
	        addClasificacionForm(collectionHolder, $newLinkLi);
	    });

	collectionHolder.find('.clasificacion').each(function() {
       addClasificacionFormDeleteLink($(this));
    });
}

function addClasificacionForm(collectionHolder, $newLinkLi) {

    var prototype = collectionHolder.attr('data-prototype');
    var newIndex = collectionHolder.find(':input').length;
    var newForm = prototype.replace(/__name__/g, newIndex);
  	var $newFormLi = $('<fieldset class=subform><legend>Clasificacion</legend></fieldset>').append(newForm);
    $newLinkLi.before($newFormLi);



    addClasificacionFormDeleteLink($newFormLi);


  /*Para los mensajes de ayuda en los formularios embebidos */
  var id = 'OA_form_clasificaciones_'+newIndex+'_proposito';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_clasificaciones_x_proposito_help');

  id = 'OA_form_clasificaciones_'+newIndex+'_descripcion';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_clasificaciones_x_descripcion_help');

  id = 'OA_form_clasificaciones_'+newIndex+'_clave';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_clasificaciones_x_clave_help');

}


function addClasificacionFormDeleteLink($clasificacionFormLi) {
    var image = "{{ asset('bundles/ROA/images/flecha_abajo.png') }}";
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $clasificacionFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm4" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
              $clasificacionFormLi.remove();
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });
        /*if(confirm("\u00bfSeguro que desea eliminar esta clasificacion?")){
            $clasificacionFormLi.remove();
        }*/
    });
    return false;
}



//Requerimientos
function agregar_requerimientos(){

	var collectionHolder = $('ul.requerimientos');
	var $addRequerimientoLink = $('<a href="#" class="add_requerimiento_link">Agregar requerimiento</a>');
	var $newLinkLi = $('<li class="li_add_requerimiento"></li>').append($addRequerimientoLink);
	collectionHolder.append($newLinkLi);
	$addRequerimientoLink.on('click', function(e) {
	        e.preventDefault();
	        addRequerimientoForm(collectionHolder, $newLinkLi);
	    });

  collectionHolder.find('.requerimiento').each(function() {
        addRequerimientoFormDeleteLink($(this));
  });
}

function addRequerimientoForm(collectionHolder, $newLinkLi) {

    var prototype = collectionHolder.attr('data-prototype');
    var newIndex = collectionHolder.find(':input').length;
    var newForm = prototype.replace(/__name__/g, newIndex);
  	var $newFormLi = $('<fieldset class=subform><legend>Requerimiento</legend></fieldset>').append(newForm);
    $newLinkLi.before($newFormLi);

    addRequerimientoFormDeleteLink($newFormLi);


  /*Para los mensajes de ayuda en los formularios embebidos*/

  var id = 'OA_form_tecnico_requerimientos_'+newIndex+'_tipo';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_tecnico_requerimientos_x_tipo_help');

  id = 'OA_form_tecnico_requerimientos_'+newIndex+'_nombre';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_tecnico_requerimientos_x_nombre_help');

  id = 'OA_form_tecnico_requerimientos_'+newIndex+'_version_minima';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_tecnico_requerimientos_x_version_minima_help');

  id = 'OA_form_tecnico_requerimientos_'+newIndex+'_version_maxima';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_tecnico_requerimientos_x_version_maxima_help');



}

function addRequerimientoFormDeleteLink($requerimientoFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $requerimientoFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm5" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
              $requerimientoFormLi.remove(); 
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });
        /*if(confirm("\u00bfSeguro que desea eliminar este requerimiento?")){
            $requerimientoFormLi.remove();
        }*/
    });
    return false;
}


//Contribuciones2
function agregar_contribuciones2(){

	// Obtiene el div que contiene la colección de etiquetas
	//var collectionHolder = $('div#MetaMetadata_form_contribuciones');
	var collectionHolder = $('ul.contribuciones2');

	// configura una enlace "Agregar una etiqueta"
	var $addContribucionLink = $('<a href="#" class="add_contribucion_link">Agregar contribucion</a>');
	var $newLinkLi = $('<li class="li_add_contribucion"></li>').append($addContribucionLink);

	//jQuery(document).ready(function() {
	    // Añade el ancla "Agregar una etiqueta" y las etiquetas li y ul
	    collectionHolder.append($newLinkLi);

	    $addContribucionLink.on('click', function(e) {
	        // evita crear el enlace con una "#" en la URL
	        e.preventDefault();

	        // añade una nueva etiqueta form (ve el siguiente bloque de código)
	        addContribucion2Form(collectionHolder, $newLinkLi);
	    });

      collectionHolder.find('.contribucion2').each(function() {
        addContribucion2FormDeleteLink($(this));
      });
}

function addContribucion2Form(collectionHolder, $newLinkLi) {
    // Obtiene el data-prototype explicado anteriormente
    var prototype = collectionHolder.attr('data-prototype');

    // cuenta las entradas actuales en el formulario (p. ej. 2),
    // lo usa como el nuevo índice (p. ej. 2)
    var newIndex = collectionHolder.find(':input').length;
    
    //alert(newIndex);

    // Reemplaza el '__name__' en el prototipo HTML para que
    // en su lugar sea un número basado en cuántos elementos hay
    var newForm = prototype.replace(/__name__/g, newIndex);

   // newIndex = 0;

    // Muestra el formulario en la página en un elemento li,
    // antes del enlace 'Agregar una etiqueta'
  	//var $newFormLi = $('<li><p class="titulo_modulo" style="margin-bottom:20px">Contribuci&oacute;n</p></li>').append(newForm);
  	var $newFormLi = $('<fieldset class=subform><legend>Contribucion</legend></fieldset>').append(newForm);


    $newLinkLi.before($newFormLi);

    addContribucion2FormDeleteLink($newFormLi);

   $(".fecha").datepicker({ dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ], monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ], changeYear: true, nextText: "Siguiente", prevText: "Anterior", dateFormat: "dd-mm-yy" });

    var entidad = $('div#OA_form_ciclovida_contribuciones_'+newIndex+'_entidades');
    //var aux = newForm.attr('id');
   // alert(aux);
   //var entidad = $('#'+aux+'_entidades');


   agregar_entidades(entidad);

   /*Para los mensajes de ayuda en los formularios embebidos */
  var id = 'OA_form_ciclovida_contribuciones_'+newIndex+'_rol';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_ciclovida_contribuciones_x_rol_help');

  id = 'OA_form_ciclovida_contribuciones_'+newIndex+'_fecha';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_ciclovida_contribuciones_x_fecha_help');

    //$newLinkLi.before($newFormLi);
}

function addContribucion2FormDeleteLink($contribucion2FormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $contribucion2FormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
              $contribucion2FormLi.remove();
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });
        /*if(confirm("\u00bfSeguro que desea eliminar esta contribucion?")){
            $contribucion2FormLi.remove();
        }*/
    });
    return false;
}


//Identificadores
function agregar_identificadores(){

  var collectionHolder = $('ul.identificadores');
  var $addIdentificadorLink = $('<a href="#" class="add_identificador_link">Agregar identificador</a>');
  var $newLinkLi = $('<li class="li_add_identificador"></li>').append($addIdentificadorLink);
  collectionHolder.append($newLinkLi);
  $addIdentificadorLink.on('click', function(e) {
          e.preventDefault();
          addIdentificadorForm(collectionHolder, $newLinkLi);
      });

  collectionHolder.find('.identificador').each(function() {
        addIdentificadorFormDeleteLink($(this));
  });
}

function addIdentificadorForm(collectionHolder, $newLinkLi) {

    var prototype = collectionHolder.attr('data-prototype');
    var newIndex = collectionHolder.find(':input').length;
    var newForm = prototype.replace(/__name__/g, newIndex);
    var $newFormLi = $('<fieldset class=subform><legend>Identificador</legend></fieldset>').append(newForm);
    $newLinkLi.before($newFormLi);

    addIdentificadorFormDeleteLink($newFormLi);


  /*Para los mensajes de ayuda en los formularios embebidos*/

  var id = 'OA_form_general_identificadores_'+newIndex+'_entrada';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_general_identificadores_x_entrada_help');

  var id = 'OA_form_general_identificadores_'+newIndex+'_catalogo';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_general_identificadores_x_catalogo_help');

}


function addIdentificadorFormDeleteLink($identificadorFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $identificadorFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm5" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
              $identificadorFormLi.remove(); 
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });
        /*if(confirm("\u00bfSeguro que desea eliminar este requerimiento?")){
            $requerimientoFormLi.remove();
        }*/
    });
    return false;
}




//Relaciones
/*function agregar_relaciones(){

  var collectionHolder = $('ul.relaciones');
  var $addRelacionLink = $('<a href="#" class="add_relacion_link">Agregar relaci&oacute;n</a>');
  var $newLinkLi = $('<li class="li_add_relacion"></li>').append($addRelacionLink);
  collectionHolder.append($newLinkLi);
  $addRelacionLink.on('click', function(e) {
          e.preventDefault();
          addRelacionForm(collectionHolder, $newLinkLi);
      });

  collectionHolder.find('.relacion').each(function() {
        addRelacionFormDeleteLink($(this));
  });
}

function addRelacionForm(collectionHolder, $newLinkLi) {

    var prototype = collectionHolder.attr('data-prototype');
    var newIndex = collectionHolder.find(':input').length;
    var newForm = prototype.replace(/__name__/g, newIndex);
    var $newFormLi = $('<fieldset class=subform><legend>Relaci&oacute;n</legend></fieldset>').append(newForm);
    $newLinkLi.before($newFormLi);

    addRelacionFormDeleteLink($newFormLi);


  //Para los mensajes de ayuda en los formularios embebidos

  var id = 'OA_form_relaciones_'+newIndex+'_tipo';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_relaciones_x_tipo_help');
}


function addRelacionFormDeleteLink($relacionFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $relacionFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm5" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
              $relacionFormLi.remove(); 
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });
    });
    return false;
}*/







//relaciones
function agregar_relaciones(){

  // Obtiene el div que contiene la colección de etiquetas
  //var collectionHolder = $('div#MetaMetadata_form_contribuciones');
  var collectionHolder = $('ul.relaciones');

  // configura una enlace "Agregar una etiqueta"
  var $addRelacionLink = $('<a href="#" class="add_relacion_link">Agregar Relacion</a>');
  var $newLinkLi = $('<li class="li_add_relacion"></li>').append($addRelacionLink);

  //jQuery(document).ready(function() {
      // Añade el ancla "Agregar una etiqueta" y las etiquetas li y ul
      collectionHolder.append($newLinkLi);

      $addRelacionLink.on('click', function(e) {
          // evita crear el enlace con una "#" en la URL
          e.preventDefault();

          // añade una nueva etiqueta form (ve el siguiente bloque de código)
          addRelacionForm(collectionHolder, $newLinkLi);
      });

      collectionHolder.find('.relacion').each(function() {
        addRelacionFormDeleteLink($(this));
      });
}

function addRelacionForm(collectionHolder, $newLinkLi) {
    // Obtiene el data-prototype explicado anteriormente
    var prototype = collectionHolder.attr('data-prototype');

    // cuenta las entradas actuales en el formulario (p. ej. 2),
    // lo usa como el nuevo índice (p. ej. 2)
    var newIndex = collectionHolder.find(':input').length;
    
    //alert(newIndex);

    // Reemplaza el '__name__' en el prototipo HTML para que
    // en su lugar sea un número basado en cuántos elementos hay
    var newForm = prototype.replace(/__name__/g, newIndex);

   // newIndex = 0;

    // Muestra el formulario en la página en un elemento li,
    // antes del enlace 'Agregar una etiqueta'
    //var $newFormLi = $('<li><p class="titulo_modulo" style="margin-bottom:20px">Contribuci&oacute;n</p></li>').append(newForm);
    var $newFormLi = $('<fieldset class=subform><legend>Relacion</legend></fieldset>').append(newForm);

    $newLinkLi.before($newFormLi);
    addRelacionFormDeleteLink($newFormLi);

    /*para que aparezca el fieldset en recurso*/
    var recurso = $('div#OA_form_relaciones_'+newIndex+'_recurso').html();
    $('div#OA_form_relaciones_'+newIndex+'_recurso').find('div').remove();
    $('div#OA_form_relaciones_'+newIndex+'_recurso').append('<fieldset class="subform"><legend>Recurso</legend>'+recurso+'</fieldset>');

    //$(".fecha").datepicker({ dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ], monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ], changeYear: true, nextText: "Siguiente", prevText: "Anterior", dateFormat: "dd-mm-yy" });

   //addRelacionFormDeleteLink($newFormLi);

    var identificador = $('div#OA_form_relaciones_'+newIndex+'_recurso_identificadores');
    //var aux = newForm.attr('id');
   // alert(aux);
   //var entidad = $('#'+aux+'_entidades');


   agregar_identificadores2(identificador);

  /*Para los mensajes de ayuda en los formularios embebidos*/

  var id = 'OA_form_relaciones_'+newIndex+'_tipo';
  agregar_ayuda_FormEmbebido(id, 'dialog-message-OA_form_relaciones_x_tipo_help');

    //$newLinkLi.before($newFormLi);
}


function addRelacionFormDeleteLink($relacionFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $relacionFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // evita crear el enlace con una "#" en la URL
        e.preventDefault();

        $( "#dialog-confirm" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
              $relacionFormLi.remove(); 
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });      
    });
    return false;
}




//Identificadores2
function agregar_identificadores2(identificador){


  // Obtiene el div que contiene la colección de etiquetas
  //var collectionHolder = $('ul.entidades');
  var collectionHolder2 = identificador;

  // configura una enlace "Agregar una etiqueta"
  var image = '/roa/web/bundles/ROA/images/help.svg';
  var link_ayuda = '<a class="help_identificador" id=""><img src="'+image+'"></a>';

  var $addIdentificadorLink = $('<a href="#" class="add_identificador_link">Agregrar identificador</a>');
  var $newLinkLi2 = $('<li class="li_identificador"></li>').append($addIdentificadorLink);

  $newLinkLi2.append(link_ayuda);

  //jQuery(document).ready(function() {
      // Añade el ancla "Agregar una etiqueta" y las etiquetas li y ul
      collectionHolder2.append($newLinkLi2);

      //agregar_ayuda_identificador();

      $addIdentificadorLink.on('click', function(e) {
          // evita crear el enlace con una "#" en la URL
          e.preventDefault();

          // añade una nueva etiqueta form (ve el siguiente bloque de código)
          addIdentificadorForm2(collectionHolder2, $newLinkLi2);
      });
}

function addIdentificadorForm2(collectionHolder2, $newLinkLi2) {
    // Obtiene el data-prototype explicado anteriormente
    var prototype2 = collectionHolder2.attr('data-prototype');

    // cuenta las entradas actuales en el formulario (p. ej. 2),
    // lo usa como el nuevo índice (p. ej. 2)
    var newIndex2 = collectionHolder2.find(':input').length;

   // newIndex2 = 3;

    // Reemplaza el '__name__' en el prototipo HTML para que
    // en su lugar sea un número basado en cuántos elementos hay

    //var newForm2 = prototype2.replace(/__name2__label__/g, 'enti');
    var newForm1 = prototype2.replace(/__name2__/g, newIndex2);
    newForm2 = newForm1.replace(newIndex2+'label__', '');

    // Muestra el formulario en la página en un elemento li,
    // antes del enlace 'Agregar una etiqueta'
    //var $newFormLi2 = $('<li class="li_entidad" ></li>').append(newForm2);
    var $newFormLi2 = $('<fieldset class=subform2><legend>Identificador</legend></fieldset>').append(newForm2);
    $newLinkLi2.before($newFormLi2);

    addIdentificadorFormDeleteLink2($newFormLi2);

}

function addIdentificadorFormDeleteLink2($identificadorFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $identificadorFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm2" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
              $identificadorFormLi.remove();
              $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        });
        /*if(confirm("\u00bfSeguro que desea eliminar esta entidad?")){
            $entidadFormLi.remove();
        }*/
    });
    return false;
}



function agregar_areas(){
  var collectionHolder = $('ul.areas');
  var $addAreaLink = $('<a href="#" class="add_subcategoria_link">Agregar Area</a>');
  var $newLinkLi = $('<li class="li_add_subcategoria"></li>').append($addAreaLink);
  collectionHolder.append($newLinkLi);
  $addAreaLink.on('click', function(e) {
          e.preventDefault();
          addAreaForm(collectionHolder, $newLinkLi);
      });

  collectionHolder.find('.area').each(function() {
       addAreaFormDeleteLink($(this));
  });
}

function addAreaForm(collectionHolder, $newLinkLi) {

    var prototype = collectionHolder.attr('data-prototype');
    var newIndex = collectionHolder.find(':input').length;
    var newForm = prototype.replace(/__name__/g, newIndex);
    var $newFormLi = $('<fieldset class=subform3><legend>Area</legend></fieldset>').append(newForm);
    $newLinkLi.before($newFormLi);

    addAreaFormDeleteLink($newFormLi);

}

function addAreaFormDeleteLink($areaFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $areaFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm-subcategoria" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
               $areaFormLi.remove(); 
               $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        })
    });
    return false;
}


//subcategorias
function agregar_subcategorias(){

  var collectionHolder = $('ul.subcategorias');
  var $addSubcategoriaLink = $('<a href="#" class="add_subcategoria_link">Agregar Subcategoria</a>');
  var $newLinkLi = $('<li class="li_add_subcategoria"></li>').append($addSubcategoriaLink);
  collectionHolder.append($newLinkLi);

  $addSubcategoriaLink.on('click', function(e) {
    e.preventDefault();
    addSubcategoriaForm(collectionHolder, $newLinkLi);
  });

  collectionHolder.find('.subcategoria').each(function() {
       addSubcategoriaFormDeleteLink($(this));
  });
}

function addSubcategoriaForm(collectionHolder, $newLinkLi) {

    var prototype = collectionHolder.attr('data-prototype');
    var newIndex = collectionHolder.find(':input').length;
    var newForm = prototype.replace(/__name__/g, newIndex);
    var $newFormLi = $('<fieldset class=subform3><legend>Subcategoria</legend></fieldset>').append(newForm);
    $newLinkLi.before($newFormLi);

    addSubcategoriaFormDeleteLink($newFormLi);
}

function addSubcategoriaFormDeleteLink($subcategoriaFormLi) {
    var $removeFormA = $('<a href="#" class="btn">Eliminar</a>');
    $subcategoriaFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        e.preventDefault();
        $( "#dialog-confirm-subcategoria" ).dialog({
          resizable: false,
          height:160,
          modal: true,
          buttons: {
            "Si": function() {
               $subcategoriaFormLi.remove(); 
               $( this ).dialog( "close" );
            },
            "No": function() {
              $( this ).dialog( "close" );
            }
          }
        })
    });
    return false;
}





//tags
function agregar_tags(){

	/*PARA AGREGAR TAGS NUEVOS*/

	// Obtiene el div que contiene la colección de etiquetas
	var collectionHolder = $('ul.tags');

	// configura una enlace "Agregar una etiqueta"
	var $addTagLink = $('<a href="#" class="add_tag_link">Add a tag</a>');
	var $newLinkLi = $('<li></li>').append($addTagLink);

	//jQuery(document).ready(function() {
	    // Añade el ancla "Agregar una etiqueta" y las etiquetas li y ul
	    collectionHolder.append($newLinkLi);

	    $addTagLink.on('click', function(e) {
	        // evita crear el enlace con una "#" en la URL
	        e.preventDefault();

	        // añade una nueva etiqueta form (ve el siguiente bloque de código)
	        addTagForm(collectionHolder, $newLinkLi);
	    });
	//});
}

function addTagForm(collectionHolder, $newLinkLi) {
    // Obtiene el data-prototype explicado anteriormente
    var prototype = collectionHolder.attr('data-prototype');

    // cuenta las entradas actuales en el formulario (p. ej. 2),
    // lo usa como el nuevo índice (p. ej. 2)
    var newIndex = collectionHolder.find(':input').length;

    // Reemplaza el '__name__' en el prototipo HTML para que
    // en su lugar sea un número basado en cuántos elementos hay
    var newForm = prototype.replace(/__name__/g, newIndex);

    // Muestra el formulario en la página en un elemento li,
    // antes del enlace 'Agregar una etiqueta'
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}

