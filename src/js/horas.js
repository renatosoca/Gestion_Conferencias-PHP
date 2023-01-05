(function() {
    const horas = document.querySelector('#horas');

    if (horas) {
        const dias = document.querySelectorAll('[name="dia"]');
        const categoria = document.querySelector('[name="categoria_id"]');
        const inputHiddenDia = document.querySelector('[name="dia_id"]');
        const inputHiddenHora = document.querySelector('[name="hora_id"]');
        
        categoria.addEventListener( 'change', terminoBusqueda );
        dias.forEach( dia =>  dia.addEventListener('change', terminoBusqueda ) );

        let busqueda = {
            categoria_id: +categoria.value || '',
            dia: +inputHiddenDia.value || ''
        }

        //Para seleccionar la hora cuando esté venga de editar
        if (!Object.values(busqueda).includes('')) {
            (async () => {
                await buscarEventos();

                //Resaltar la hora actual
                const horaSeleccionada = document.querySelector(`[data-hora-id= "${inputHiddenHora.value}"]`)
                horaSeleccionada.classList.remove('horas__hora--deshabilitada');
                horaSeleccionada.classList.add('horas__hora--seleccionada');

                horaSeleccionada.onclick = seleccionarHora;
            })();
        }

        function terminoBusqueda(e) {
            busqueda[e.target.name] = e.target.value;

            //Reinciar los campos ocultos y el selector de horas
            inputHiddenDia.value = '';
            inputHiddenHora.value = '';

            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if (horaPrevia) horaPrevia.classList.remove('horas__hora--seleccionada');

            if (Object.values(busqueda).includes('')) return;

            buscarEventos();
        }

        async function buscarEventos() {
            const { categoria_id, dia } = busqueda;

            try {
                const url = `http://localhost:3000/api/eventos-horarios?dia_id=${dia}&categoria_id=${categoria_id}`;
                const resultado = await fetch(url);
                const eventos = await resultado.json();
                
                obtenerHorasDisponibles(eventos);

            } catch (error) {
                console.log(error);
            }
        }

        function obtenerHorasDisponibles(eventos) {
            //Reiniciar las horas
            const listadoHoras = document.querySelectorAll('#horas li');
            listadoHoras.forEach( li => li.classList.add('horas__hora--deshabilitada'));

            //Comprobar eventos ya tomados y quitar la variable de deshabilitado
            const horasTomadas = eventos.map(evento => evento.hora_id);const listadoHorasArray = Array.from(listadoHoras);

            const resultado = listadoHorasArray.filter(li => !horasTomadas.includes(li.dataset.horaId));
            resultado.forEach( li => li.classList.remove('horas__hora--deshabilitada'));

            const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');
            horasDisponibles.forEach( hora => hora.addEventListener('click', seleccionarHora));

            //Para que no se pueda seleccionar la hora deshabilitada al momento de cambiar de dia o categoria
            const horasDeshabilitadas = document.querySelectorAll('.horas__hora--deshabilitada');
            horasDeshabilitadas.forEach(hora => hora.removeEventListener('click', seleccionarHora));
        }

        function seleccionarHora(e) {
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if (horaPrevia) horaPrevia.classList.remove('horas__hora--seleccionada');
            
            //Agregar clase de seleccionado
            e.target.classList.add('horas__hora--seleccionada');

            inputHiddenHora.value = e.target.dataset.horaId;

            //Llenar el campo oculto de dia
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
        }
    }
})();