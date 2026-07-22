const buscador = document.getElementById("buscarPedido");
const filtro = document.getElementById("filtroEstado");
const filas = document.querySelectorAll("tbody tr");

function filtrarTabla(){

    const texto = buscador.value.trim().toLowerCase();
    const estado = filtro.value;

    filas.forEach(function(fila){

        const numeroPedido = fila.cells[0].textContent.toLowerCase();
        const cliente = fila.cells[2].textContent.toLowerCase();
        const producto = fila.cells[3].textContent.toLowerCase();
        const estadoFila = fila.cells[6].textContent.trim();
        const coincideTexto =
            numeroPedido.includes(texto) ||
            cliente.includes(texto) ||
            producto.includes(texto);

        const coincideEstado =
            estado === "Todos" ||
            estadoFila.includes(estado);

        if(coincideTexto && coincideEstado){
            fila.style.display = "";
        }else{
            fila.style.display = "none";
        }
    });
}
if(buscador && filtro){
    buscador.addEventListener("input", filtrarTabla);
    filtro.addEventListener("change", filtrarTabla);
}