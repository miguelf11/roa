//VALIDACIONES FORMULARIO GENERAL

var lenguaje = new LiveValidation('OA_form_general_lenguaje',  { validMessage: " "});  
lenguaje.add(Validate.Format, { pattern: /[(A-Za-z)]/, failureMessage: "Lenguaje inválido"});
lenguaje.add( Validate.Presence , { failureMessage: "Campo requerido"});

var clave = new LiveValidation('OA_form_general_clave',  { validMessage: " "});  
clave.add(Validate.Format, { pattern: /[(A-Za-z)]/, failureMessage: "Clave inválida"});

var entrada_catalogo = new LiveValidation('OA_form_general_entrada_catalogo',  { validMessage: " "});  
entrada_catalogo.add(Validate.Format, { pattern: /[(A-Za-z)]/, failureMessage: "Entrada de catálogo inválida"});

var cobertura = new LiveValidation('OA_form_general_cobertura',  { validMessage: " "});  
cobertura.add(Validate.Format, { pattern: /[(A-Za-z)]/, failureMessage: "Cobertura inválida"});