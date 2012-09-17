function soloNumeros(evt)
{
    //Validar la existencia del objeto event
    evt = (evt) ? evt : event;
 
    //Extraer el codigo del caracter de uno de los diferentes grupos de codigos
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
 
    //Predefinir como valido
    var respuesta = true;
 
    //Validar si el codigo corresponde a los NO aceptables
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
        //Asignar FALSE a la respuesta si es de los NO aceptables
        respuesta = false;
    }
 
    //Regresar la respuesta
    return respuesta;
}