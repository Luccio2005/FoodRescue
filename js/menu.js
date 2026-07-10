const buscador = document.getElementById("buscarProducto");

const filas = document.querySelectorAll("tbody tr");

buscador.addEventListener("keyup", function(){

    const texto = buscador.value.toLowerCase();

    filas.forEach(function(fila){

        const producto = fila.cells[0].textContent.toLowerCase();

        if(producto.includes(texto)){

            fila.style.display = "";

        }else{

            fila.style.display = "none";

        }

    });

});