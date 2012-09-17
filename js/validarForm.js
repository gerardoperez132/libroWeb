 $(document).ready(function(){
                $.validator.addMethod("regex",function(value,element,regexp){
                    var re= new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },"Ingrese su Nombre Correctamente");
                $.validator.addMethod("rcorr",function(value,element,regexp){
                    var re= new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },"Ingrese su correo correctamente");
                 $.validator.addMethod("mensa",function(value,element,regexp){
                    var re= new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },"Ingrese su Mensaje Correctamente");

                $("#registro").validate({
                   
                    rules:{
                            nombre:{
                                required:true,
                                regex:"^[A-Za-z ñÑçÇáéíóúüÁÉÍÓÚÜ]+$" //Patron de Validadion Numero
                               //remote:"comprobar.php"
                            },
                            correo:{
                                required:true,
                                rcorr:"[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})"
                                //email:true
                                //email:true 77ojo exite funcion que valida correo
                            },
                            captcha:{
                                required:true
                               
                            }
                    },
                    messages:{
                        nombre:{
                            required:"Ingrese su Nombre Correctamente",
                        },
                        correo:{
                            required:"Ingrese su Correo Correctamente"
                        },
                        captcha:{
                            required:"Ingrese su código de confirmación",
                        }
    
                    },
          //submitHandler:function(){
            //            alert("Los datos han sido enviados");
      //return true;
        //            }
                });
})
