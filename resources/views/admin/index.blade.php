@extends('layouts.app')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/jsqr/dist/jsQR.min.js"></script>

    <button type="button" class="btn btn-info" id="startButton">Activar Cámara</button>
    <br>

    <video id="video" width="300" height="200" autoplay></video>
    <canvas id="canvas" style="display: none;"></canvas>
    <script>
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
                alert('Mensaje del código QR: ' + code.data);
            }

            requestAnimationFrame(scanFrame);
        }
    </script>
@endsection
