(function(){
    const tagsinput = document.querySelector('#tags_input');

    if (tagsinput) {
        const tagsdiv = document.querySelector('#tags');
        const tagsHidden = document.querySelector('[name="tags"]');
        let tags = [];

        //escuchar los cambios en el input
        tagsinput.addEventListener('keypress', guardarTag);

        function guardarTag(e) {
            if (e.keyCode === 44) {

                if(e.target.value.trim() === '' || e.target.value.length < 1) return;
                e.preventDefault();
                tags = [...tags, e.target.value.trim()]
                tagsinput.value = "";
                mostrarTags();
            }
        }

        function mostrarTags () {
            tagsdiv.textContent = '';
            tags.forEach( tag => {
                const etiqueta = document.createElement('li');
                etiqueta.classList.add('formulario__tag');
                etiqueta.textContent = tag;
                etiqueta.ondblclick = eliminarTag;
                tagsdiv.appendChild(etiqueta);
            })

            actualizarInputHidden();
        }

        function actualizarInputHidden() {
            tagsHidden.value = tags.toString();
        }

        function eliminarTag (e) {
            e.target.remove();
            tags = tags.filter( tag => tag !== e.target.textContent);
            actualizarInputHidden();
        }
    };
})();