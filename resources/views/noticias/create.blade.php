@extends('layouts.app-blade')

@section('content')
    <div class="container">
        <h1>Crear Noticia</h1>

        <form method="POST" action="{{ url('/noticias') }}" id="formCrear" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Título</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Lead</label>
                <textarea name="lead" class="form-control" rows="2" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Banner</label>
                <input type="file" name="banner" class="form-control" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="confirmarCrear()">Guardar</button>
            <a href="{{ url('/noticias') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>


    <script>
        function confirmarCrear() {
            Swal.fire({
                title: 'Crear noticia',
                text: '¿Estás seguro que quieres crear esta noticia?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, Crear',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#198754',
            }).then((result) => {
                if (result.isConfirmed) {
                    var formData = new FormData($('#formCrear')[0]);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        url: '{{ url('/noticias') }}',
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
