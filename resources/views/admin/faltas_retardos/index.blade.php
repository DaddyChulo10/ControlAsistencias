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
            </tr>
        </thead>
        <tbody id="tbodyRegistros"></tbody>
    </table>







    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>









    <script>
        $(function() {
            cargarTabla()
        });


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
                                        
                                        ${ data[i]['asistencia'] === 1 ? '<i style="color: green" data-feather="thumbs-up"></i>' : '<i style="color: red" data-feather="thumbs-down"></i>' }
                                    </td>
                                    <td>
                                        ${data[i]['retardo'] !== 1 ? '<i style="color: red"  data-feather="thumbs-down"></i>' : '<i  style="color: green" data-feather="thumbs-up"></i>'}
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
        const canvas = document.getElementById('canvas');
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
                    scanFrame();
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

            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height);

            if (code && !requestSent) {
                sendAjaxRequest(code.data);
                requestSent = true;
                stopScanning();
            }
            requestAnimationFrame(scanFrame);
        }


        function sendAjaxRequest(data) {
            console.log(data);
            $.ajax({
                type: "GET",
                url: "{{ route('faltas_retardos.validarCodigoQr') }}",
                data: {
                    codigo: data
                },
                // dataType: "dataType",
                success: function(response) {
                    console.log('Respuesta del servidor:', response);

                    if(response) {
                        alert('Existe el codigo QR');
                        startScanning();
                        scanning = false;
                        requestSent = false;
                    }else {
                        alert('No existe el codigo QR');
                        startScanning();
                        scanning = false;
                        requestSent = false;
                        
                    }


                },
                error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    </script>
@endsection
