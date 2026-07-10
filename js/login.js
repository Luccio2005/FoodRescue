document.addEventListener("DOMContentLoaded", function(){

    const formulario = document.getElementById("formLogin");

    formulario.addEventListener("submit", function(e){

        const usuario = document.getElementById("usuario").value.trim();
        const contrasena = document.getElementById("contrasena").value.trim();

        if(usuario===""){
            alert("Ingrese su usuario.");
            e.preventDefault();
            return;
        }

        if(contrasena===""){
            alert("Ingrese su contraseña.");
            e.preventDefault();
            return;
        }

    });

    const botonPassword = document.getElementById("mostrarPassword");

    const campoPassword = document.getElementById("contrasena");

    botonPassword.addEventListener("click",function(){

        if(campoPassword.type==="password"){

            campoPassword.type="text";

            botonPassword.textContent="🙈";

        }else{

            campoPassword.type="password";

            botonPassword.textContent="👁";

        }

    });

});