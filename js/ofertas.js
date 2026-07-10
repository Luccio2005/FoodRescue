const etiquetas = document.querySelectorAll(".etiqueta");

const textos = [

    "🔥 Popular",

    "⭐ Más vendido",

    "💚 Recomendado",

    "🔥 Últimas unidades",

    "⭐ Oferta del día"

];

const colores = [

    "#ff5722",

    "#ff9800",

    "#2E8B57",

    "#d32f2f",

    "#1976d2"

];

etiquetas.forEach(function(etiqueta, indice){

    etiqueta.textContent = textos[indice];

    etiqueta.style.background = colores[indice];

});
const contadores = document.querySelectorAll(".contador");

contadores.forEach(function(contador){

    let tiempo = 2*3600 + 15*60 + 30;

    actualizar();

    const intervalo = setInterval(function(){

        tiempo--;

        actualizar();

        if(tiempo<=0){

            clearInterval(intervalo);

            contador.textContent="Oferta finalizada";

        }

    },1000);

    function actualizar(){

        const horas=Math.floor(tiempo/3600);

        const minutos=Math.floor((tiempo%3600)/60);

        const segundos=tiempo%60;

        contador.textContent=

        String(horas).padStart(2,"0")+":"+

        String(minutos).padStart(2,"0")+":"+

        String(segundos).padStart(2,"0");

    }

});
const tarjetas=document.querySelectorAll(
".oferta1,.oferta2,.oferta3,.oferta4,.oferta5"
);

tarjetas[0].style.border="4px solid gold";

tarjetas[0].style.transform="scale(1.03)";