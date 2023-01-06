import Swal from 'sweetalert2'

{
    let eventos = [];

    const registro = document.querySelector('#registro-resumen');

    if (registro) {
        const eventosBoton = document.querySelectorAll('.evento__agregar');
        eventosBoton.forEach( boton => boton.addEventListener('click', seleccionarEvento));

        const formularioSubmit = document.querySelector('#registro');
        formularioSubmit.addEventListener('submit', enviarRegistro);
        
        function seleccionarEvento(e) {
            if (eventos.length < 5) {
                eventos = [...eventos, {
                    id: e.target.dataset.id,
                    titulo: e.target.parentElement.querySelector('.evento__nombre').textContent.trim()
                }]
        
                //Deshabilitar el evento
                e.target.disabled = true;
        
                mostrarEventos();
            } else {
                Swal.fire({
                    title: 'Error',
                    text: 'Solo se Puede Seleccionar un maximo de 5 eventos',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            }
        }
        mostrarEventos();
        function mostrarEventos() {
            limpiarHTML(registro);

            if (eventos.length > 0) {

                eventos.forEach( evento => {
                    const {id, titulo} = evento
                    const eventoDom = document.createElement('div');
                    eventoDom.classList.add('registro__evento')

                    const tituloEvento = document.createElement('h3');
                    tituloEvento.classList.add('registro__nombre');
                    tituloEvento.textContent = titulo

                    const btnEliminar = document.createElement('button');
                    btnEliminar.classList.add('registro__eliminar');
                    btnEliminar.innerHTML = '<i class="fa-solid fa-trash"></i>'
                    btnEliminar.onclick = () => {
                        eliminarEvento(id)
                    };

                    eventoDom.appendChild(tituloEvento);
                    eventoDom.appendChild(btnEliminar);
                    registro.appendChild(eventoDom);

                })
            } else {
                const noRegistro = document.createElement('p');
                noRegistro.textContent = 'Sin Eventos Seleccionados';
                noRegistro.classList.add('registro__texto');

                registro.appendChild(noRegistro);
            }
        }

        function limpiarHTML(elemento) {
            while(elemento.firstChild){
                elemento.removeChild(elemento.firstChild);
            }
        }

        function eliminarEvento(id) {
            eventos = eventos.filter( evento => evento.id !== id);
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled = false;
            mostrarEventos();
        }

        async function enviarRegistro(e) {
            e.preventDefault();
            
            const regaloId = document.querySelector('#regalo').value;
            const eventoId = eventos.map( evento => evento.id);

            if (eventoId.length === 0 || regaloId === ''){
                Swal.fire({
                    title: 'Error',
                    text: 'Elige al menos 1 evento y 1 regalo',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
            } else {
                const datos = new FormData();
                datos.append('eventos', eventoId);
                datos.append('regalo_id', regaloId);

                try {
                    const url = '/finalizar-registro/conferencias';
                    const respuesta = fetch(url, {
                        method: 'POST',
                        body: datos
                    })
                    const resultado = (await respuesta).json();

                    console.log(resultado.respuesta);
                    if (resultado) {
                        Swal.fire({
                            title: 'Exitoso',
                            text: 'Tu Registro fue Exitoso',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then( () => location.href = `/boleto?id=${resultado.token}` );
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'Hubo un Error en tu registro',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then( () => location.reload() );
                    }
                } catch (e) {
                    console.log(e);
                }
            }
        }
    }
}