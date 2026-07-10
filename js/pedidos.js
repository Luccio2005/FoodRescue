const buscador = document.getElementById("buscarPedido");

const filtro = document.getElementById("filtroEstado");

const filas = document.querySelectorAll("tbody tr");

function filtrarTabla(){

    const texto = buscador.value.toLowerCase();

    const estado = filtro.value;

    filas.forEach(function(fila){

        const cliente = fila.cells[2].textContent.toLowerCase();

        const producto = fila.cells[3].textContent.toLowerCase();

        const estadoFila = fila.cells[6].textContent;

        const coincideTexto =
            cliente.includes(texto) ||
            producto.includes(texto);

        const coincideEstado =
            estado==="Todos" ||
            estadoFila===estado;

        if(coincideTexto && coincideEstado){

            fila.style.display="";

        }else{

            fila.style.display="none";

        }

    });

}

buscador.addEventListener("keyup", filtrarTabla);

filtro.addEventListener("change", filtrarTabla);