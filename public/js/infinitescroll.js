let page = 2;
let loading = false;
let hasMore = true;

window.addEventListener('DOMContentLoaded', () => {
    const trigger = document.getElementById('infinite-scroll-trigger');
    const loader = $('#loader');

    if (!trigger) {
        console.error('Trigger no encontrado');
        return;
    }

    const observer = new IntersectionObserver((entries) => {
    
    const entry = entries[0];

    if (!entry.isIntersecting || loading || !hasMore) return;

    loading = true;
    loader.removeClass('hidden');

    $.ajax({
        url: '?page=' + page,
        type: 'GET',
        success: function (response) {

            if (response.html) {
                $('#feed-container').append(response.html);
            }

            hasMore = response.hasMore;
            page++;
            loading = false;

            loader.addClass('hidden');

            // 🔥 Si ya no hay más, dejamos de observar
            if (!hasMore) {
                observer.unobserve(trigger);
                loader.text('No hay más imágenes');
            }
        },
        error: function (xhr) {
            loading = false;
            console.error('Error:', xhr.responseText);
        }
    });

}, {
    root: null,          // viewport
    rootMargin: '200px', // precarga antes de llegar abajo
    threshold: 0
});

// Activar observer
observer.observe(trigger);

});