let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    nombre : '',
    fecha : '',
    hora : '',
    servicios : []
};


document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
    
});


function iniciarApp(){

    mostrarSeccion();

    //Cambia la seccion cuando se presionen los tabs
    tabs();

    //Agrega o Quita los botones del paginador
    botonesPaginador();

    paginaSiguiente();
    paginaAnterior();

    //Consulta la API en el backend de php
    consultarAPI();

    //Añade el nombre del cliente al obejto cita
    nombreCliente();

    //Añade la fecha de la cita al objeto de cita
    seleccionarFecha();

    //Añade la hora de la cita en el objeto cita
    seleccionarHora();

    //Muestra el resumen de la cita
    mostrarResumen();

}

function mostrarSeccion(){
   
    //Ocultar la seccion que tenga la clase de mostrar
   const seccionAnterior = document.querySelector('.mostrar');
   if(seccionAnterior){
       seccionAnterior.classList.remove('mostrar');
    }
   
   
   //Seleccionar la seccion con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);
    seccion.classList.add('mostrar');
    //Quita la clase de actual al tab anterior
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }
    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton=>{
        boton.addEventListener('click',function(e) {
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
            botonesPaginador();

            
        });
    });
}

function botonesPaginador(){
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if(paso === 1){
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }
    else if(paso===3){
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }else{
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    }

    mostrarSeccion();
}

function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click',function(){
        if(paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click',function(){
        if(paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    });
}

async function consultarAPI(){
    try {
        const url = 'http://localhost:3000/api/servicios';
        const resultado = await fetch(url);
        const servicios = await resultado.json();
       mostrarServicios(servicios);
        
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){
    servicios.forEach(servicio => {
        const {id,nombre,precio} = servicio;

        const nombreServicio = document.createElement('p');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('p');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;
        
        const servicioDiv = document.createElement('div');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function (){
            seleccionarServicio(servicio);
        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        
        document.querySelector('#servicios').appendChild(servicioDiv);
        
    });
}

function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;
    
    //Verificar a que servicio se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    
    //Comprobar si un servicio ya fue agregado o quitarlo
    if(servicios.some(agregado => agregado.id === id)){
        //Eliminar
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    }else{
        //Agregarlo
        cita.servicios = [...servicios,servicio];
        divServicio.classList.add('seleccionado');
        
    }


   
}

function nombreCliente(){
    cita.nombre = document.querySelector('#nombre').value;
    
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input',function (e){
        const dia = new Date(e.target.value).getUTCDay();
        if([6,0].includes(dia)){
            e.target.value = '';
            mostrarAlerta('Fines de semana no permitidos','error','.formulario');
        }else{
            cita.fecha = e.target.value;
        }
    });
}

function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input',function(e){
        const horaCita = e.target.value;
        const hora = horaCita.split(':')[0];
        if(hora < 10 || hora >20){
            e.target.value = " ";
            mostrarAlerta('Hora no válida','error','.formulario');

        }else{
            cita.hora = e.target.value;
            console.log(cita);
        }
    });
}

function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');

    //Limpiar el contenido de resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    
    
   if(Object.values(cita).includes("") || cita.servicios.length === 0){
       mostrarAlerta('Faltan datos de Serivicios, Fecha u Hora','error','.contenido-resumen',false);
        return;
    }

    const {nombre,fecha,hora,servicios} = cita;
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    //Formatear fecha
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate()+2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year,mes,dia));
    const opciones = {
        weekday: 'long',
        year : 'numeric',
        month: 'long',
        day : 'numeric'
    };

    const fechaFormateada = fechaUTC.toLocaleDateString('es',opciones);
    

    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    servicios.forEach(servicio => {
        const {id,nombre,precio} = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');
        
        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;


        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    const botonReservar = document.createElement('Button');
        botonReservar.classList.add('boton','contenedor');
        botonReservar.textContent = 'Reservar';
        botonReservar.onclick = reservarCita;

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const HoraCita = document.createElement('P');
    HoraCita.innerHTML = `<span>Hora:</span> ${hora}`;

    const headingDatos = document.createElement('H3');
    headingDatos.textContent = 'Resumen de Cita';
    resumen.appendChild(headingDatos);
   
    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(HoraCita);
    
    resumen.appendChild(botonReservar);
}

function mostrarAlerta(mensaje,tipo,elemento,desaparece = true){   
    //Previene que se generen mas de una alerta
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia){
        alertaPrevia.remove();
    }


    const alerta = document.createElement('DIV');
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);
   
    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

async function reservarCita(){
   const datos = new FormData();
   datos.append('nombre','Jorge');

   //Peticion a la APO
   const url = 'http://localhost:3000/api/citas';

   const respuesta = await fetch(url,{
       method: 'POST',
       body: datos
   });

   const resultado = await respuesta.json();
   console.log(resultado);

//    console.log([...datos]);
}