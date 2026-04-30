// Aqui implementare el sistema asincrono con AJAX para el sistema de likes/dislikes
var url = 'http://image-social.com'; // La url de mi proyecto para hacer peticiones http
window.addEventListener('load', () => {

    $('.btn-favorite').css('cursor', 'pointer'); // LLamo a esta class de la img (las de los likes) y le añado un cursor pointer
    $('.btn-disfavorite').css('cursor', 'pointer');

    // Boton de favorite
    function favorite() {
        $('.btn-favorite').unbind('click').click(function () { // unbind borra eventos antiguos ( unbind.('click') limpia el evento click, como si lo reanudara)
            console.log('favorite');
            var $btn = $(this);                          // ✅ Captura referencia antes del AJAX
            var imageId = $btn.data('id');
            $btn.addClass('btn-disfavorite').removeClass('btn-favorite');
            $btn.attr('src', url + '/img/favorite-yellow.png');
            // Aqui le implemento ajax
            $.ajax({
                url: url + '/favorites/' + imageId, // la construccion de la url entera es: url -> image-social.com + '/like/' + el id de la imagen: ($(this) representa al evento click en el contenedor btn dislike, o sea el click en la imagen y su id -> .data('id'))

                type: 'GET',
                success: function (response) {
                    if (response.favorite) {
                        $('span.favorite-count[data-id="' + imageId + '"]').text(response.total);
                        console.log("Has dado favorito a esta publicacion");
                        
                    } else {
                        $btn.addClass('btn-favorite').removeClass('btn-disfavorite');
                        $btn.attr('src', url + '/img/favorite-black.png');
                        console.log("Error al dar favorite");
                        
                    }
                }
            });
            disfavorite();
        });
    }
    favorite();

    // Boton de dislike
    function disfavorite() {
        $('.btn-disfavorite').unbind('click').click(function () {
            console.log('disfavorite');
            var $btn = $(this);                          // ✅ Ídem
            var imageId = $btn.data('id');
            $btn.addClass('btn-favorite').removeClass('btn-disfavorite');
            $btn.attr('src', url + '/img/favorite-black.png');
            $.ajax({
                url: url + '/nonfavorites/' + imageId, // la construccion de la url entera es: url -> image-social.com + '/like/' + el id de la imagen: ($(this) representa al evento click en el contenedor btn dislike, o sea el click en la imagen y su id -> .data('id'))

                type: 'GET',
                success: function (response) {
                    if (response.like) {
                        $('span.favorite-count[data-id="' + imageId + '"]').text(response.total);
                        console.log("Has dado disfavorite a esta publicacion");
                        
                    } else {
                        $btn.addClass('btn-disfavorite').removeClass('btn-favorite');
                        $btn.attr('src', url + '/img/favorite-yellow.png');
                        console.log("Error al dar disfavorite");
                        
                    }
                }
            });
            favorite();
        });
    }
    disfavorite();
}); // Fin del evento load