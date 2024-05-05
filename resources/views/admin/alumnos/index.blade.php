@extends('layouts.app')
@section('content')
    <div class="table-responsive">
        <table class="table table-hover" id="tablas">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Grado y Grupo</th>
                    <th>Nombre Completo</th>
                    <th>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearAlumno">
                            <i data-feather="plus"></i>
                        </button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alumnos as $item)
                    <tr id="tr_alumno_{{ $item->id }}">
                        <td> {{ $loop->iteration }} </td>
                        <td> {{ $item->codigo }} </td>
                        <td> {{ $item->getGradoGrupo->grado_grupo ?? 'Grado y grupo eliminado' }} </td>
                        <td> {{ $item->nombre_apellido }} </td>
                        <td>
                            <button type="button" class="btn btn-danger" onclick="alumnoEliminar({{ $item->id }})"><i
                                    data-feather="trash-2"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>




    <div class="modal fade" id="crearAlumno" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('alumnos.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar nuevo alumno</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label>Codigo</label>
                        <input type="text" class="form-control" name="codigo" required>
                        <br>
                        <label>Nombre y Apellido</label>
                        <input type="text" class="form-control" name="nombre_apellido" required>
                        <br>
                        <label>Grado y grupo</label>
                        <select class="form-select" name="grado_grupo_id" required>
                            <option disabled value="">Seleccionar grado y grupo</option>
                            @foreach ($grados_grupos as $item)
                                <option value="{{ $item->id }}">{{ $item->grado_grupo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        let table = new DataTable('#tablas');
    });


    function alumnoEliminar(id) {
        Swal.fire({
            title: "Seguro de eliminar el alumno?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Si, eliminarlo",
            denyButtonText: `No, cancelar`,
            icon: "question"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "GET",
                    url: "{{ route('alumnos.delete') }}",
                    data: {
                        id: id
                    },
                    // dataType: "dataType",
                    success: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Ciclo escolar eliminado",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $(`#tr_alumno_${id}`).remove();
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });



            } else if (result.isDenied) {

                Swal.fire({
                    position: "top-end",
                    icon: "error",
                    title: "Cancelado",
                    showConfirmButton: false,
                    timer: 1500
                });

            }
        });
    }
</script>
