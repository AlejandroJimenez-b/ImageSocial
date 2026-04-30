    <!-- Overlay -->
    <div id="modal-overlay" class="fixed inset-0 bg-black bg-opacity-60 hidden z-40 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div id="comments-modal" class="fixed inset-0 flex max-w-sm items-center justify-center hidden z-50 p-4">
        <div class="bg-gray-50 rounded-2xl shadow-2xl w-full mx-4 max-h-[90vh] flex flex-col border border-gray-200" style="max-width: 500px;">

            <!-- Cabecera -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 bg-white rounded-t-2xl">
                <h3 class="font-semibold text-gray-800 text-base">Comentarios</h3>
                <button id="modal-close"
                        class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition text-lg">✕</button>
            </div>

            <!-- Imagen -->
            <div class="px-5 pt-4 flex justify-center bg-white border-b border-gray-200 pb-4">
                <div class="w-full max-h-96 overflow-hidden rounded-lg bg-gray-100">
                    <img id="modal-image" src="" class="w-48 h-32 object-cover mx-auto">
                </div>
            </div>

            <!-- Comentarios -->
            <div id="modal-comments" class="flex-1 overflow-y-auto px-5 py-4 space-y-3 bg-white"></div>

            <!-- Formulario -->
            <div class="px-5 py-4 border-t border-gray-200 bg-white rounded-b-2xl">
                <form id="modal-form" action="" method="POST">
                    @csrf
                    @method('POST')

                    <div class="flex items-start gap-3">
                        <img src="{{ route('user.avatar', ['filename' => auth()->user()->image]) }}"
                            class="w-8 h-8 rounded-full object-cover flex-shrink-0 border-2 border-gray-200">

                        <div class="flex-1">
                            <textarea name="comments" rows="2"
                                    class="w-full border-2 border-gray-200 rounded-xl p-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-blue-400 bg-gray-50 placeholder-gray-400"
                                    placeholder="Escribe un comentario..."></textarea>

                            <div class="flex justify-end mt-2">
                                <button type="submit"
                                        class="bg-blue-100 text-dark px-5 py-1.5 rounded-full text-sm font-medium hover:bg-blue-600 transition">
                                    Comentar
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

    @if(session('open_comments'))
        <script>
            window.openCommentsOnLoad = {{ session('open_comments') }};
        </script>
    @endif