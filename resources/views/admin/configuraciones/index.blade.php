@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-6">
            <h3>Ciclo Escolar</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ciclo</th>
                        <th>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cicloCrear">
                                <i data-feather="plus"></i>

                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ciclo as $item)
                        <tr id="tr_ciclo_{{ $item->id }}">
                            <td> {{ $loop->iteration }} </td>
                            <td> {{ $item->ciclo }} </td>
                            <td>
                                <button type="button" class="btn btn-danger" onclick="cicloEliminar({{ $item->id }})"><i
                                        data-feather="trash-2"></i> </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <h3>Grados y Grupos</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ciclo</th>
                        <th>Grado y grupo</th>
                        <th>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#gradoygrupocrear">
                                <i data-feather="plus"></i>
                            </button>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($grados_grupos as $item)
                        <tr id="tr_gradogrupo_{{ $item->id }}">
                            <td> {{ $loop->iteration }} </td>
                            <td> {{ $item->getcicloEscolar->ciclo ?? 'CICLO ELIMINADO' }} </td>
                            <td> {{ $item->grado_grupo }} </td>
                            <td>
                                <button type="button" class="btn btn-danger"
                                    onclick="gradogrupoEliminar({{ $item->id }})"><i data-feather="trash-2"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="modal fade" id="cicloCrear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('configuraciones.store.ciclo') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Cliclo escolar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label>Agregar Ciclo escolar</label>
                        <input type="text" class="form-control" name="ciclo" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="gradoygrupocrear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('configuraciones.store.grado_grupo') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Cliclo escolar</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <label>Agregar Grado y Grupo</label>
                        <input type="text" class="form-control" name="grados_grupos" required>
                        <br>
                        <label>Ciclo escolar</label>
                        <select class="form-select" name="ciclo_id" required>
                            <option disabled value="">Seleccionar Ciclo escolar</option>
                            @foreach ($ciclo as $item)
                                <option class="option_ciclo_{{ $item->id }}" value="{{ $item->id }}">
                                    {{ $item->ciclo }}</option>
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
    function gradogrupoEliminar(id) {
        Swal.fire({
            title: "Seguro de eliminar grado y grupo?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Si, eliminarlo",
            denyButtonText: `No, cancelar`,
            icon: "question"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "GET",
                    url: "{{ route('configuraciones.delete.grado_grupo') }}",
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
                        $(`#tr_gradogrupo_${id}`).remove();
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

    function cicloEliminar(id) {
        Swal.fire({
            title: "Seguro de eliminar el Ciclo escolar?",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Si, eliminarlo",
            denyButtonText: `No, cancelar`,
            icon: "question"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "GET",
                    url: "{{ route('configuraciones.delete.ciclo') }}",
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
                        $(`#tr_ciclo_${id}`).remove();
                        $(`.option_ciclo_${id}`).remove();
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
