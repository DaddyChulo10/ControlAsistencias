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
        }

        function scanFrame() {
            if (!scanning) return;

            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height);

            if (code) {

                Swal.fire({
                    title: `Codigo: ${code.data}`,
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Reportar Asistencias",
                    denyButtonText: `Reportar Retardo`,
                    cancelButtonText: "Cancelar"
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('faltas_retardos.registrar') }}",
                            data: {
                                codigo: code.data,
                                asistencia: true,
                                retardo: false,
                            },
                            success: function(response) {
                                cargarTabla()
                                Swal.fire({
                                    title: `Detalles`,
                                    showDenyButton: true,
                                    showCancelButton: true,
                                    confirmButtonText: "Uniforme",
                                    denyButtonText: `Corte de cabello`,
                                    cancelButtonText: "Cancelar"
                                }).then((result) => {

                                    if (result.isConfirmed) {
                                       
                                    } else if (result.isDenied) {
                                       

                                    }
                                }); 
                            },
                            error: function(xhr, status, error) {
                                alert(xhr.responseText);
                            }
                        })
                    } else if (result.isDenied) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('faltas_retardos.registrar') }}",
                            data: {
                                codigo: code.data,
                                asistencia: false,
                                retardo: true,
                            },
                            success: function(response) {
                                cargarTabla()
                                Swal.fire("Changes are not saved", "", "info");
                            },
                            error: function(xhr, status, error) {
                                alert(xhr.responseText);
                            }
                        })

                    }
                });

                // alert('Mensaje del código QR: ' + code.data);
            }

            requestAnimationFrame(scanFrame);
        }
    </script>
@endsection
