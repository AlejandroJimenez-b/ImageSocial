var url = 'http://image-social.com';

window.addEventListener('load', () => {

    const overlay = $('#modal-overlay');
    const modal = $('#comments-modal');
    const modalComments = $('#modal-comments');
    const modalImage = $('#modal-image');
    const modalForm = $('#modal-form');

    // Funcion reutilizable para cargar comentarios
    function cargarComentarios(imageId) {
        $.ajax({
            url: url + '/comments/' + imageId + '/json',
            type: 'GET',
            success: function(response) {
                modalComments.empty();

                if (response.comments.length === 0) {
                    modalComments.append(`
                        <p class="text-sm text-gray-400 text-center">
                            Sé el primero en comentar
                        </p>
                    `);
                } else {
                    response.comments.forEach(function(comment) {
                        const deleteBtn = comment.is_owner ? `
                            <form action="${url}/comments/${comment.id}" method="POST" class="delete-comment-form inline">
                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="text-xs text-red-400 hover:text-red-600 transition">
                                    Eliminar
                                </button>
                            </form>
                        ` : '';

                        modalComments.append(`
                            <div class="comment-item flex items-start gap-3">
                                <img src="${comment.avatar}" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                                <div class="flex-1 bg-gray-50 rounded-2xl px-4 py-2.5">
                                    <div class="flex items-center justify-between mb-0.5">
                                        <span class="text-sm font-semibold text-gray-800">
                                            ${comment.nick}
                                        </span>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-gray-400">${comment.created_at}</span>
                                            ${deleteBtn}
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-700 leading-snug">${comment.content}</p>
                                </div>
                            </div>
                        `);
                    });
                }
            },
            error: function() {
                console.log('Error al cargar los comentarios');
            }
        });
    }

    // Abrir modal al pulsar "Comentarios"
    $('.btn-comments').click(function() {
        const imageId = $(this).data('id');
        const imageSrc = $(this).data('image');
        const storeUrl = $(this).data('store');

        modalImage.attr('src', imageSrc);
        modalForm.attr('action', storeUrl);
        modalForm.data('image-id', imageId); // ✅ Guardamos el imageId en el formulario

        cargarComentarios(imageId);

        overlay.removeClass('hidden');
        modal.removeClass('hidden');
    });

    // ✅ Enviar comentario por AJAX sin cerrar el modal
    modalForm.on('submit', function(e) {
        e.preventDefault();

        const formData = $(this).serialize();
        const actionUrl = $(this).attr('action');
        const imageId = $(this).data('image-id'); // ✅ Recuperamos el imageId guardado

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function() {
                modalForm.find('textarea').val(''); // Limpiar textarea
                cargarComentarios(imageId);         // Recargar comentarios
            },
            error: function() {
                console.log('Error al enviar el comentario');
            }
        });
    });

    // Eliminar comentario por AJAX sin cerrar el modal
    // #modal-comments form
    $(document).off('submit', '.delete-comment-form')
    .on('submit', '.delete-comment-form', function(e) {
        e.preventDefault();

        let form = $(this);
        let actionUrl = form.attr('action');
        let formData = form.serialize();
        let imageId = modalForm.data('image-id');
         // 🔥 animación
        let commentDiv = form.closest('.comment-item');
        // const formData = $(this).serialize();
        // const actionUrl = $(this).attr('action');
        // const imageId = modalForm.data('image-id');
        commentDiv.fadeOut(200, function() {

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                if (response.success) {
                    cargarComentarios(imageId);
                }
            }
        });
    });

        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            success: function() {
                cargarComentarios(imageId); // ✅ Recarga comentarios sin cerrar modal


            },
            error: function() {
                console.log('Error al eliminar el comentario');
            }
        });
    });

    // Cerrar modal con botón X
    $('#modal-close').click(function() {
        cerrarModal();
    });

    // Cerrar modal al pulsar el overlay
    overlay.click(function() {
        cerrarModal();
    });

    function cerrarModal() {
        overlay.addClass('hidden');
        modal.addClass('hidden');
        modalComments.empty();
        modalImage.attr('src', '');
    }

    // Reabrir modal si venimos de un submit tradicional (destroy)
    if (window.openCommentsOnLoad) {
        $('.btn-comments[data-id="' + window.openCommentsOnLoad + '"]').trigger('click');
    }

});