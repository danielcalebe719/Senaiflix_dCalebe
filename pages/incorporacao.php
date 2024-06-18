<?php
include("./conexao.php");

// Verifica se o parâmetro "video" foi passado
if (isset($_GET['video'])) {
    $video = $_GET['video']; // O link direto para o vídeo
    $titulo = $_GET['titulo']; // O link direto para o vídeo
    $video = htmlspecialchars($video, ENT_NOQUOTES, 'UTF-8'); 
  }
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistir Filme</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">   

  


<!-- Bootstrap JS (Optional, for certain features like validation) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">   
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="manifest" href="https://mkv-player.netlify.app/manifest.json">
  <script src="MKV%20Player_arquivos/subtitles-octopus.js"></script>
  <link href="MKV%20Player_arquivos/2.dee2d631.chunk.css" rel="stylesheet">
  <link href="MKV%20Player_arquivos/main.3702bc6f.chunk.css" rel="stylesheet">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .video-container {
      position: relative;
      width: 100%;
      padding-top: 56.25%;
    }

    .iframe-video-top {
            width: 100%;
            height: 500px; /* Define uma altura para o iframe */
            border: none; /* Remove bordas do iframe */
        }
    .video-container video {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    .input-group {
      margin-bottom: 20px;
    }

    .container {
      max-width: 600px;
      margin-top: 50px;
    }
  </style>
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar navbar-dark bg-dark">
        <a class="navbar-brand text-danger" href="home.php">SenaiFlix Administração</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNav">
        <ul class="navbar-nav ms-auto">
    <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
    </li>   
</ul>
</header>

<body class="bg-dark text-white">


  <div class="container">
    <div class="text-center mb-4">
      <h1> Você está assistindo <h1 class="text-info"><?php echo $titulo?></h1></h1>
    </div>
    <div class="input-group">
      <input type="text" class="form-control" id="link-input" value="<?php echo $video; ?>">
      <div class="input-group-append">
        <button class="btn btn-primary" id="play-button">Play</button>
      </div>
    </div>
    <div id="video-container" class="video-container border rounded"></div>
  </div>
  <script>
    const linkInput = document.getElementById('link-input');
    const playButton = document.getElementById('play-button');
    const videoContainer = document.getElementById('video-container');

    document.addEventListener('DOMContentLoaded', () => {
      const link = linkInput.value.trim();
      if (link) {
        // Clear any previous video
        videoContainer.innerHTML = '';

        // Create a new video element and set the source to the link
        const video = document.createElement('video');
        video.src = link;
        video.type = 'video/mkv';
        video.controls = true;

        // Add the video element to the page
        videoContainer.appendChild(video);

        // Play the video
        video.play();
      } else {
        alert('Please enter a valid link');
      }
    });
  </script>
  <script src="MKV%20Player_arquivos/2.e265fef1.chunk.js"></script>
  <script src="MKV%20Player_arquivos/main.deb6d9a4.chunk.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

