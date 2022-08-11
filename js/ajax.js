//seleccionara todos los documentos que tengan la clase "formulario ajax"//
const formularios_ajax=document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e)
{
    //No se van a redirigir automaticamente los formularios
    e.preventDefault();

    //devuelve true si aceptamos y false si cancelamos//
    let enviar=confirm("¿Quieres enviar el formulario?");

    if(enviar==true){
        //Crear un nuevo array de datos a partir del formulario//
        let data= new FormData(this);
        //Agarra el atributo que hayamos definido en formularios//
        let method=this.getAttribute("method");
        //Agarra el atributo que hayamos definido en formularios//
        let action=this.getAttribute("action");

        let encabezados= new Headers();
        //Arrays//
        let config={
            method: method,
            headers: encabezados,
            //Su finalidad es dificultar la posibilidad de añadir recursos ajenos en un sitio determinado.//
            mode: 'cors',
            //No se usara la cache//
            cache: 'no-cache',
            //datos del formulario en la variable data//
            body: data
        };
        //llevara el atributo action y las confiiguraciones anteriormente programadas//
        fetch(action,config)
        //La promesa que recibamos lo transformara en texto plano//
        .then(respuesta => respuesta.text())
        .then(respuesta =>{ 
            let contenedor=document.querySelector(".form-rest");
            contenedor.innerHTML = respuesta;
        });
    }

}

//Estara al tanto de cada formulario//
formularios_ajax.forEach(formularios => {
    //cuando se envie la funcion se ejecutara la funcion//
    formularios.addEventListener("submit",enviar_formulario_ajax);
});