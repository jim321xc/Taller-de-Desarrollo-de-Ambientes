function validar(formulario) {
  if (formulario.nombreUsuario.value.length < 4) {
    alert("Escriba por lo menos 4 caracteres en el campo \"Nombre\".");
    formulario.nombreUsuario.focus();
    return (false);
  }
  var checkOK = "ABCDEFGHIJKLMNÑOPQRSTUVWXYZÁÉÍÓÚ" + "abcdefghijklmnñopqrstuvwxyzáéíóú ";
  var checkStr = formulario.nombreUsuario.value;
  var allValid = true; 
  for (i = 0; i < checkStr.length; i++) {
    ch = checkStr.charAt(i); 
    for (j = 0; j < checkOK.length; j++)
      if (ch == checkOK.charAt(j))
        break;
    if (j == checkOK.length) { 
      allValid = false; 
      break; 
    }
  }
  if (!allValid) { 
    alert("Escriba sólo letras en el campo \"Nombre\"."); 
    formulario.nombreUsuario.focus(); 
    return (false); 
  } 
  
  if ((formulario.emailUsuario.value.indexOf ('@', 0) == -1)||(formulario.emailUsuario.value.length < 5)) { 
    alert("Escriba una dirección de correo válida en el campo \"Dirección de correo\"."); 
	formulario.emailUsuario.focus(); 
    return (false); 
  }
  if (formulario.cuentaUsuario.value.length < 4) {
    alert("Escriba por lo menos 4 caracteres en el campo \"Cuenta\".");
    formulario.cuentaUsuario.focus();
    return (false);
  }
  if (formulario.passwordUsuario.value.length < 4) {
    alert("Escriba por lo menos 4 caracteres en el campo \"Password\".");
    formulario.passwordUsuario.focus();
    return (false);
  }
  /*******************/
if ((formulario.buscar.value.indexOf ('@', 0) == -1)||(formulario.buscar.value.length < 5)) { 
    alert("Escriba una dirección de correo válida en el campo \"Dirección de correo\"."); 
	formulario.buscar.focus(); 
    return (false); 
  }
  
  return (true); 
}


