@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>

    <video id="video" width="640" height="480" autoplay></video>
    <button type="button" class="btn btn-info" id="startButton">Activar Cámara</button>

    <script>
        const video = document.getElementById('video');

        document.getElementById('startButton').addEventListener('click', () => {
            // Solicitar acceso a la cámara
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    // Mostrar el flujo de la cámara en el elemento de video
                    video.srcObject = stream;
                })
                .catch(error => {
                    console.error('Error al acceder a la cámara:', error);
                });
        });
    </script>
@endsection
