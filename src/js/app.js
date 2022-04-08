let paso = 1;

document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
    
});


function iniciarApp(){
    //Cambia la seccion cuando se presionen los tabs
    tabs();

}

function mostrarSeccion(){
    console.log('hola zZzzzZz');
}

function tabs(){
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton=>{
        boton.addEventListener('click',function(e) {
            paso = parseInt(e.target.dataset.paso);

            mostrarSeccion();
        });
    });
}