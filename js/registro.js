const formulario = document.getElementById("formRegistro");
const password = document.getElementById("contrasena");
const barra = document.getElementById("nivelPassword");
const texto = document.getElementById("textoPassword");

password.addEventListener("input", function(){

    const valor = password.value;

    if(valor.length < 6){

        barra.style.width = "30%";
        barra.style.background = "red";
        texto.textContent = "Débil";

    }

    else if(valor.length < 10){

        barra.style.width = "65%";
        barra.style.background = "orange";
        texto.textContent = "Media";

    }

    else{

        barra.style.width = "100%";
        barra.style.background = "green";
        texto.textContent = "Fuerte";

    }

});
formulario.addEventListener("submit", function(e){

    const nombre = document.getElementById("nombre").value.trim();
    const apellido = document.getElementById("apellido").value.trim();
    const correo = document.getElementById("correo").value.trim();
    const usuario = document.getElementById("usuario").value.trim();
    const contrasena = document.getElementById("contrasena").value;
    const confirmar = document.getElementById("contrasena2").value;
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    if(!soloLetras.test(nombre)){
        alert("El nombre solo puede contener letras.");
        e.preventDefault();
        return;
    }

    if(!soloLetras.test(apellido)){
        alert("El apellido solo puede contener letras.");
        e.preventDefault();
        return;
    }

    if(!correo.includes("@")){
        alert("Ingrese un correo válido.");
        e.preventDefault();
        return;
    }

    if(usuario.includes(" ")){
        alert("El usuario no puede contener espacios.");
        e.preventDefault();
        return;
    }

    if(usuario.length < 4){
        alert("El usuario debe tener al menos 4 caracteres.");
        e.preventDefault();
        return;
    }

    if(contrasena.length < 8){
        alert("La contraseña debe tener mínimo 8 caracteres.");
        e.preventDefault();
        return;
    }

    if(!/[A-Z]/.test(contrasena)){
        alert("La contraseña debe tener una letra mayúscula.");
        e.preventDefault();
        return;
    }

    if(!/[a-z]/.test(contrasena)){
        alert("La contraseña debe tener una letra minúscula.");
        e.preventDefault();
        return;
    }

    if(!/[0-9]/.test(contrasena)){
        alert("La contraseña debe tener un número.");
        e.preventDefault();
        return;
    }

    if(contrasena!=confirmar){
        alert("Las contraseñas no coinciden.");
        e.preventDefault();
        return;
    }
});