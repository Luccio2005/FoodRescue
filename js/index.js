const mensajes = [
    "🌱 Rescatando alimentos y reduciendo el desperdicio.",
    "💚 Cuidando el planeta un plato a la vez.",
    "💰 Ahorra comprando comida de calidad.",
    "🍽 Juntos evitamos el desperdicio de alimentos."
];

let posicion = 0;

const mensaje = document.getElementById("mensajePrincipal");

setInterval(function(){

    posicion++;

    if(posicion >= mensajes.length){
        posicion = 0;
    }

    mensaje.textContent = mensajes[posicion];

},3000);
function actualizarFecha(){

    const ahora = new Date();

    document.getElementById("fechaHora").innerHTML =
    "📅 " + ahora.toLocaleDateString() +
    " | 🕒 " + ahora.toLocaleTimeString();

}

actualizarFecha();

setInterval(actualizarFecha,1000);
let numero = 0;

const contador = document.getElementById("contador");

const intervalo = setInterval(function(){

    numero += 25;

    contador.textContent = numero;

    if(numero >= 2500){

        clearInterval(intervalo);

    }

},20);
const boton = document.getElementById("btnSubir");

window.addEventListener("scroll",function(){

    if(window.scrollY > 250){

        boton.style.display="block";

    }else{

        boton.style.display="none";

    }

});

boton.addEventListener("click",function(){

    window.scrollTo({

        top:0,

        behavior:"smooth"

    });

});