const formulario = document.getElementById("formPedido");

formulario.addEventListener("submit", function(e){

    const telefono = document.getElementById("telefono").value;
    const cantidad = document.getElementById("cantidad").value;

    if(telefono.length != 9){
        alert("El teléfono debe tener 9 dígitos.");
        e.preventDefault();
        return;
    }

    if(cantidad <= 0){
        alert("Ingrese una cantidad válida.");
        e.preventDefault();
        return;
    }

    const confirmar = confirm("¿Desea registrar este pedido?");

    if(!confirmar){
        e.preventDefault();
    }
});
const producto = document.getElementById("producto");

const cantidadInput = document.getElementById("cantidad");

const precio = document.getElementById("precio");

const total = document.getElementById("total");

function calcularTotal(){

    const opcion = producto.options[producto.selectedIndex];

    const precioProducto = Number(opcion.dataset.precio);

    const cantidad = Number(cantidadInput.value);

    precio.value = "S/. " + precioProducto.toFixed(2);

    if(cantidad > 0){

        total.value = "S/. " + (precioProducto*cantidad).toFixed(2);

    }else{

        total.value="S/. 0.00";

    }

}

producto.addEventListener("change", calcularTotal);

cantidadInput.addEventListener("input", calcularTotal);

calcularTotal();