@extends('layouts.appUser')
@section('content')
    <br>

    <div class="row">
        <div class="col-12">
            <label for="inputCodigo">Buscar por codigo del alumno:</label>
            <input class="form-control" id="inputCodigo" type="text" placeholder="Buscar..." value="1952051338">
            <br>
            <button class="btn btn-primary" id="btnBuscar" onclick="buscarAlumno()">Buscar</button>
        </div>

        <div class="col-12" id="informacionAlumno" style="display: none">

            <div class="card mt-3">
                <div class="card-body">
                    <h5 id="idNombre" class="card-title"></h5>
                    <h6 id="idGradoGrupo" class="card-subtitle mb-2 text-muted"></h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha y Hora</th>
                                    <th>Asistencias</th>
                                    <th>Retardo</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyConsulta"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function buscarAlumno() {
            codigo = $("#inputCodigo").val();

            $("#tbodyConsulta").empty();
            $.ajax({
                type: "get",
                url: "{{ route('consulta-informacion-alumno.buscar') }}",
                data: {
                    codigo: codigo
                },
                success: function(response) {

                    $("#informacionAlumno").show();
                    $("#idNombre").text(response?.alumno?.nombre_apellido);
                    $("#idGradoGrupo").text(response?.gradoGrupo);

                    if (response?.faltasRetardos.length > 0) {
                        response.faltasRetardos.forEach((item, index) => {

                            $("#tbodyConsulta").append(`
                                <tr>
                                    <td>${index+1}</td>
                                    <td>${item.fecha} ${item.hora}</td>
                                    <td>${item.asistencia == true ? '<i style="color: green"  data-feather="x"></i>' : ''}</td>
                                    <td>${item.retardo == true ? '<i style="color: red"  data-feather="x"></i>' : ''}</td>
                                    <td>
                                         ${Array.isArray(item.reglas) ? `<ul>${item.reglas.map(regla => `<li>${regla}</li>`).join('')}</ul>` : ''
                                        }
                                    </td>
                                </tr>
                            `)
                        })

                    }

                    feather.replace();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }

            })
        }
    </script>
@endsection
