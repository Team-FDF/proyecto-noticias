@extends('layouts.app-blade')

@section('content')
    <div class="container">
        <h1>Editar Noticia</h1>

        <form method="POST" action="{{ url('/noticias/' . $noticia->id) }}" id="formEditar" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" value="{{ $noticia->titulo }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Banner Actual</label>
                @if ($noticia->banner)
                    @if (str_starts_with($noticia->banner, 'http'))
                        <img src="{{ $noticia->banner }}" class="d-block mb-2" style="max-width: 200px;">
                    @else
                        <img src="{{ asset('storage/' . $noticia->banner) }}" class="d-block mb-2"
                            style="max-width: 200px;">
                    @endif
                @endif
                <input type="file" name="banner" class="form-control" accept="image/*">
                <small class="text-muted">Deja vacío si no quieres cambiar la imagen</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" required>{{ $noticia->descripcion }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="1" {{ $noticia->estado == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $noticia->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="confirmarEdit()">Guardar cambios</button>
            <a href="{{ url('/noticias') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>


    <script>
        function confirmarEdit() {
            Swal.fire({
                title: 'Guardar Cambios',
                text: '¿Estás seguro que quieres guardar los cambios?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#198754',
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData($('#formEditar')[0]);
                    formData.append('_method', 'PUT');
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: '{{ url('/noticias/' . $noticia->id) }}',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function() {
                            window.location.href = '{{ url('/noticias') }}';
                        }
                    });
                }
            });
        }
    </script>
@endsection
