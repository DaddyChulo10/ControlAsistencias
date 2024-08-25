@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>

    <button type="button" class="btn btn-info" id="startButton">Activar Cámara</button>
    <br>

    <video id="video" width="300" height="200" autoplay></video>
    <canvas id="canvas" style="display: none;"></canvas>



    <br><br>


    <table id="tablas" class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Alumno</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Asistencia</th>
                <th>Retardo</th>
                <th>Reglas</th>

            </tr>
        </thead>
        <tbody id="tbodyRegistros"></tbody>
    </table>







    <div class="modal fade" id="idAlumno" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1"aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="idNombreDelAlumno"></h5>
                </div>
                <div class="modal-body">
                    <p id="idGradoyGrupo"></p>
                    <button type="button" class="btn btn-success" id="btnAsistencia"
                        onclick="agregarValores('asistencia')">Asistencia</button>
                    <button type="button" class="btn btn-danger" id="btnRetardo"
                        onclick="agregarValores('retardo')">Retardo</button>
                    <button type="button" class="btn btn-warning" id="btnReglas" onclick="verReglas()">Reglas</button>

                    <div id="informacion" style="font-size: 10px" class="mt-2"> </div>

                    <div id="reglasAlumnos" style="display:none">
                        <table class="table table-hover mt-5">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Reglas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbodyReglas"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="saveModal()">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>









    <script>
        


        let valores = {
            asistencia: false,
            retardo: false,
            reglas: false
        }
        let codigoAlumno = null;

        let arrayRegla = []


        $(function() {
            let jsonString = JSON.stringify(valores, null, 2)
            $('#informacion').html(jsonString)
            cargarTabla()
        });

        function closeModal() {
            $('#tbodyReglas').children('tr').remove();
            arrayRegla = []
            valores = {
                asistencia: false,
                retardo: false,
                reglas: false
            }
            let jsonString = JSON.stringify(valores, null, 2)
            $('#informacion').html(jsonString)

            codigoAlumno = null;
            $("#reglasAlumnos").hide();
        }

        function saveModal() {

            $.ajax({
                type: "GET",
                url: "{{ route('faltas_retardos.registrar') }}",
                data: {
                    codigoAlumno: codigoAlumno,
                    valores: valores
                },
                success: function(data) {

                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Asistencia registrada con exito",
                        showConfirmButton: false,
                        timer: 1500
                    });

                    cargarTabla()

                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            })


            /**********/


            $('#tbodyReglas').children('tr').remove();
            arrayRegla = []
            valores = {
                asistencia: false,
                retardo: false,
                reglas: false
            }


            codigoAlumno = null;
            let jsonString = JSON.stringify(valores, null, 2)
            $('#informacion').html(jsonString)
            $("#reglasAlumnos").hide();

        }


        function verReglas() {
            $("#reglasAlumnos").show();
        }

        function agregarValores(informacion) {
            if (informacion == 'asistencia') {
                valores = {
                    ...valores,
                    asistencia: true,
                    retardo: false
                };
            } else if (informacion == 'retardo') {
                valores = {
                    ...valores,
                    asistencia: false,
                    retardo: true
                };
            }

            let jsonString = JSON.stringify(valores, null, 2)
            $('#informacion').html(jsonString)

            console.log(valores)


        }

        function cargarTabla() {
            $.ajax({
                type: "GET",
                url: "{{ route('faltas_retardos.cargarRegistros') }}",
                success: function(data) {
                    $(`#tbodyRegistros`).children('tr').remove();

                    console.log()
                    for (let i = 0; i < data.length; i++) {
                        $(`#tbodyRegistros`).append(
                            `
                                <tr>
                                    <td>${i +1}</td>
                                    <td>${data[i]['nombre_apellido']}</td>
                                    <td>${data[i]['fecha']}</td>
                                    <td>${data[i]['hora']}</td>
                                    <td>
                                        
                                        ${ data[i]['asistencia'] === 1 ? '<i style="color: green" data-feather="x"></i>' : '' }
                                    </td>
                                    <td>
                                        ${data[i]['retardo'] !== 1 ? '' : '<i  style="color: red" data-feather="x"></i>'}
                                    </td>
                                    <td>
                                        ${data[i]['reglas'] !== null ? '<i style="color: red"  data-feather="alert-triangle"></i>' : ''}
                                    </td>
                                </tr>
                            `
                        )
                    }
                    feather.replace();
                    let table = new DataTable('#tablas');


                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            })
        }
        const video = document.getElementById('video');
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        let scanning = false;
        let requestSent = false;

        document.getElementById('startButton').addEventListener('click', () => {
            if (!scanning) {
                startScanning();
            } else {
                stopScanning();
            }
        });

        function startScanning() {
            navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                })
                .then(stream => {
                    video.srcObject = stream;
                    video.play();
                    scanning = true;

                    video.addEventListener('loadedmetadata', () => {
                        scanFrame();
                    });
                })
                .catch(err => console.error('Error al acceder a la cámara: ', err));
        }

        function stopScanning() {
            video.pause();
            video.srcObject.getTracks()[0].stop();
            scanning = false;
            requestSent = false;
        }

        function scanFrame() {
            if (!scanning) return;

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;


            if (canvas.width > 0 && canvas.height > 0) {
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height);

                if (code && !requestSent) {
                    sendAjaxRequest(code.data);
                    requestSent = true;
                }
            }

            requestAnimationFrame(scanFrame);
        }



        function addRegla(id, regla) {

            let estaSeleccionado = $(`#checkboxRegla${id}`).is(':checked');

            if (estaSeleccionado) {
                console.log('seleccionado')
                arrayRegla.push({
                    id: id,
                    regla: regla
                })
            } else {
                console.log('no seleccionado')
                arrayRegla = arrayRegla.filter(item => item.id !== id);
            }

            if (arrayRegla.length > 0) {
                valores = {
                    ...valores,
                    reglas: arrayRegla
                };
            } else {
                valores = {
                    ...valores,
                    reglas: false
                };
            }
            let jsonString = JSON.stringify(valores, null, 2)
            $('#informacion').html(jsonString)


            console.log(arrayRegla)
        }

        function sendAjaxRequest(data) {
            $.ajax({
                url: "{{ route('faltas_retardos.validarCodigoQr') }}",
                type: "GET",
                data: {
                    codigo: data
                },
                success: function(response) {
                    $('#idNombreDelAlumno').text('Nombre: ' + response?.alumno?.nombre_apellido)
                    $('#idGradoyGrupo').text('Grado y grupo: ' + response?.grado)
                    $(`#tbodyReglas`).children('tr').remove();

                    codigoAlumno = response?.alumno?.codigo;

                    if (response?.reglas.length > 0) {
                        response.reglas.forEach(element => {
                            $('#tbodyReglas').append(
                                `
                                <tr>
                                    <td>
                                        ${element.id}
                                    </td>
                                    <td>
                                        ${element.reglas}
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-check-input" onclick="addRegla(${element.id}, '${element.reglas}')" id="checkboxRegla${element.id}">
                                    </td>   
                                </tr>`
                            )
                        });
                    }

                    $('#idAlumno').modal('show')


                    setTimeout(() => {
                        requestSent = false;
                    }, 1500);
                },
                error: function(error) {
                    console.error('Error en la petición AJAX:', error);
                    requestSent = false;
                }
            });
        }
    </script>
@endsection
