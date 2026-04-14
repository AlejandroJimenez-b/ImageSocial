// Aqui implementare el sistema asincrono con AJAX para el sistema de likes/dislikes
var url = 'http://image-social.com'; // La url de mi proyecto para hacer peticiones http
window.addEventListener('load', () => {

    $('.btn-like').css('cursor', 'pointer'); // LLamo a esta class de la img (las de los likes) y le añado un cursor pointer
    $('.btn-dislike').css('cursor', 'pointer');

    // Boton de like
    function like() {
        $('.btn-like').unbind('click').click(function () { // unbind borra eventos antiguos ( unbind.('click') limpia el evento click, como si lo reanudara)
            console.log('like');
            var $btn = $(this);                          // ✅ Captura referencia antes del AJAX
            var imageId = $btn.data('id');
            $btn.addClass('btn-dislike').removeClass('btn-like');
            $btn.attr('src', url + '/img/heart-red.png');
            // Aqui le implemento ajax
            $.ajax({
                url: url + '/likes/' + imageId, // la construccion de la url entera es: url -> image-social.com + '/like/' + el id de la imagen: ($(this) representa al evento click en el contenedor btn dislike, o sea el click en la imagen y su id -> .data('id'))

                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        $('span.like-count[data-id="' + imageId + '"]').text(response.total);
                        console.log("Has dado like a esta publicacion");
                        
                    } else {
                        $btn.addClass('btn-like').removeClass('btn-dislike');
                        $btn.attr('src', url + '/img/heart-black.png');
                        console.log("Error al dar like");
                        
                    }
                }
            });
            dislike();
        });
    }
    like();

    // Boton de dislike
    function dislike() {
        $('.btn-dislike').unbind('click').click(function () {
            console.log('dislike');
            var $btn = $(this);                          // ✅ Ídem
            var imageId = $btn.data('id');
            $btn.addClass('btn-like').removeClass('btn-dislike');
            $btn.attr('src', url + '/img/heart-black.png');
            $.ajax({
                url: url + '/dislikes/' + imageId, // la construccion de la url entera es: url -> image-social.com + '/like/' + el id de la imagen: ($(this) representa al evento click en el contenedor btn dislike, o sea el click en la imagen y su id -> .data('id'))

                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        $('span.like-count[data-id="' + imageId + '"]').text(response.total);
                        console.log("Has dado dislike a esta publicacion");
                        
                    } else {
                        $btn.addClass('btn-dislike').removeClass('btn-like');
                        $btn.attr('src', url + '/img/heart-red.png');
                        console.log("Error al dar dislike");
                        
                    }
                }
            });
            like();
        });
    }
    dislike();
}); // Fin del evento load