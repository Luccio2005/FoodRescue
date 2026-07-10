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

    const contrasena = document.getElementById("contrasena").value;
    const confirmar = document.getElementById("contrasena2").value;
    const correo = document.getElementById("correo").value;

    if(!correo.includes("@")){
        alert("Ingrese un correo electrónico válido.");
        e.preventDefault();
        return;
    }
    if(contrasena.length < 6){
        alert("La contraseña debe tener al menos 6 caracteres.");
        e.preventDefault();
        return;
    }
    if(contrasena !== confirmar){
        alert("Las contraseñas no coinciden.");
        e.preventDefault();
    }

});