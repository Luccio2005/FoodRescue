const formulario = document.getElementById("formPedido");

formulario.addEventListener("submit", function(e){
    const nombre = document.getElementById("nombre").value.trim();
    const direccion = document.getElementById("direccion").value.trim();
    const telefono = document.getElementById("telefono").value.trim();
    const cantidad = Number(document.getElementById("cantidad").value);
    const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;
    if(nombre==""){
        alert("Ingrese su nombre.");
        e.preventDefault();
        return;
    }
    if(!soloLetras.test(nombre)){
        alert("El nombre solo puede contener letras.");
        e.preventDefault();
        return;
    }
    if(nombre.length<3){
        alert("El nombre es demasiado corto.");
        e.preventDefault();
        return;
    }
    if(direccion.length<5){
        alert("Ingrese una dirección válida.");
        e.preventDefault();
        return;
    }
    if(!/^[0-9]{9}$/.test(telefono)){
        alert("El teléfono debe contener exactamente 9 números.");
        e.preventDefault();
        return;
    }
    if(cantidad<1 || cantidad>20){
        alert("La cantidad debe estar entre 1 y 20.");
        e.preventDefault();
        return;
    }
    const confirmar = confirm("¿Desea guardar este pedido?");
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