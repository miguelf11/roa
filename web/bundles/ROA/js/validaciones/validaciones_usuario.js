//VALIDACIONES FORMULARIO USUARIO

var email = new LiveValidation('Usuario_form_email', { validMessage: " "});
email.add(Validate.Presence, { failureMessage: "Campo requerido"});
email.add(Validate.Email, { failureMessage: "Email inválido"});

var nombre = new LiveValidation('Usuario_form_nombre',  { validMessage: " "});  
nombre.add( Validate.Presence , { failureMessage: "Campo requerido"});
nombre.add(Validate.Format, { pattern: /^([A-Za-z]+\s*)+$/, failureMessage: "Nombre inválido"});

var apellido = new LiveValidation('Usuario_form_apellido',  { validMessage: " "});  
apellido.add( Validate.Presence , { failureMessage: "Campo requerido"}); 
apellido.add(Validate.Format, { pattern: /^([A-Za-z]+\s*)+$/, failureMessage: "Apellido inválido"}); 

var password = new LiveValidation('Usuario_form_password_Contrasena', { validMessage: " "});
password.add( Validate.Presence , { failureMessage: "Campo requerido"});
password.add( Validate.Length, { minimum: 4, tooShortMessage: "Contraseña muy corta"} );
password.add(Validate.Format, { pattern: /^(\w)+$/, failureMessage: "Contrasena inválida"});


var password2 = new LiveValidation('Usuario_form_password_Confirme_su_contrasena', { validMessage: " "});
password2.add( Validate.Confirmation, { match: 'Usuario_form_password_Contrasena', failureMessage: 'Contraseña no coincide'} );
password2.add( Validate.Presence , { failureMessage: "Campo requerido"});  
password2.add( Validate.Length, { minimum: 4, tooShortMessage: "Contraseña muy corta"} );
password2.add(Validate.Format, { pattern: /^(\w)+$/, failureMessage: "Contrasena inválida"});
