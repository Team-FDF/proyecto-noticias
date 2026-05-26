@extends('layouts.app-blade')

@section('content')
    <div class=" container mb-5 mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Noticias</h1>
            <a href="{{ url('/noticias/create') }}" class="btn btn-success">
                <i class="bi bi-plus"> </i>Crear Noticia
            </a>
        </div>

        <table class="table table-bordered table-striped" id="tablaNoticias">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($noticias as $noticia)
                    <tr>
                        <td>{{ $noticia->id }}</td>
                        <td class="text-truncate" style="max-width: 150px;">{{ $noticia->titulo }}</td>
                        <td class="text-truncate" style="max-width: 250px;">{{ $noticia->descripcion }}</td>
                        <td>
                            @if ($noticia->estado == 1)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('/noticias/' . $noticia->id . '/edit') }}" class="btn btn-black btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <button type="button" class="btn btn-black btn-sm"
                                onclick="confirmarEliminar({{ $noticia->id }})">
                                <i class="bi bi-x-square-fill"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#tablaNoticias').DataTable({
                lengthChange: false,
                pageLength: 100,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    search: 'Buscar:'

                }
            });
        });



        function confirmarEliminar(id) {
            Swal.fire({
                title: "Eliminar Noticia",
                text: "¿Estás seguro de eliminar esta noticia?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, Eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#d33',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/noticias/' + id,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function() {
                            window.location.reload();
                        }
                    });
                }
            });
        }
    </script>
@endsection
