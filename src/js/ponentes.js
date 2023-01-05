(function () {
    const ponentesInput = document.querySelector('#ponentes');
    if (ponentesInput) {
        let ponentes = [];
        let ponentesFiltrados = [];

        const listadoPonentes = document.querySelector('#listado-ponentes');
        const ponenteHidden = document.querySelector('[name="ponente_id"]');

        obtenerPonentes()

        ponentesInput.addEventListener('input', buscarPonentes)
        if (ponenteHidden.value) {
            (async () => {
                const ponente = await obtenerPonente(ponenteHidden.value);
                
                const {nombre, apellido} = ponente;

                const ponenteLi = document.createElement('li');
                ponenteLi.classList.add('listado-ponentes__ponente', 'listado-ponentes__ponente--seleccionado');
                ponenteLi.textContent = `${nombre} ${apellido}`;

                listadoPonentes.appendChild(ponenteLi);
            })();
        }

        async function obtenerPonentes() {
            try {
                const url = `/api/ponentes`;
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
                
                formatearPonentes(resultado);
            } catch (error) {
                console.log(error);
            }
        }

        async function obtenerPonente(id) {
            try {
                const url = `/api/ponente?id=${id}`;
                const respuesta = await fetch(url);
                const resultado = await respuesta.json();
                
                return resultado;
            } catch (error) {
                console.log(error);
            }
        }

        function formatearPonentes(arrayPonentes) {
            ponentes = arrayPonentes.map(ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: `${ponente.id}`
                }
            });
        }

        function buscarPonentes(e) {
            const busqueda = e.target.value;
            if (busqueda.length > 2) {
                const expresion = new RegExp(busqueda, "i");
                ponentesFiltrados = ponentes.filter( ponente => {
                    if (ponente.nombre.toLowerCase().search( expresion ) !== -1) {
                        return ponente;
                    }
                })
            } else {
                ponentesFiltrados = [];
            }

            mostrarPonentes();
        }

        function mostrarPonentes() {
            while(listadoPonentes.firstChild){
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }

            if (ponentesFiltrados.length > 0) {

                ponentesFiltrados.forEach( ponente => {
                    const ponenteHtml = document.createElement('li');
                    ponenteHtml.classList.add('listado-ponentes__ponente');
                    ponenteHtml.textContent = ponente.nombre;
                    ponenteHtml.dataset.ponenteId = ponente.id;
                    ponenteHtml.onclick = seleccionarPonente;
    
                    listadoPonentes.appendChild(ponenteHtml);
                })
                return;
            }

            const noResultados = document.createElement('p');
            noResultados.classList.add('listado-ponentes__ponente');
            noResultados.textContent = 'Ponente no Encontrado';

            listadoPonentes.appendChild(noResultados);
        }

        function seleccionarPonente(e) {
            const ponentePrevio = document.querySelector('.listado-ponentes__ponente--seleccionado')
            if ( ponentePrevio) ponentePrevio.classList.remove('listado-ponentes__ponente--seleccionado');

            const ponente = e.target;
            ponente.classList.add('listado-ponentes__ponente--seleccionado');

            ponenteHidden.value = ponente.dataset.ponenteId;
        }

    }
})();