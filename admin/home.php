<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Home</h1>
</div>

<h1 class="display-2 title">WELCOME TO<br>Jurusan Teknologi Informasi</h1>
<p class="subtitle">
    "The Stepping Stone to International Journey"
</p>

<!-- CSS Styles -->
<style>
    .title {
        color: #3498db; /* Warna biru */
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Efek bayangan */
        animation: fadeIn 2s ease-in-out, glow 2s infinite alternate; /* Animasi masuk dan bercahaya */
    }
    
    .subtitle {
        font-size: 1.5rem;
        color: #e74c3c; /* Warna merah */
        text-shadow: 2px 2px 8px rgba(255, 255, 255, 0.8); /* Efek bercahaya */
        animation: fadeIn 4s ease-in-out 1s, glowSubtitle 3s infinite alternate; /* Animasi masuk dan bercahaya */
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(-20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes glow {
        0% {
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5), 0 0 10px #3498db, 0 0 20px #3498db;
        }
        100% {
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5), 0 0 20px #2980b9, 0 0 30px #2980b9;
        }
    }

    @keyframes glowSubtitle {
        0% {
            text-shadow: 2px 2px 8px rgba(255, 255, 255, 0.8), 0 0 10px #e74c3c;
        }
        100% {
            text-shadow: 2px 2px 8px rgba(255, 255, 255, 0.8), 0 0 20px #c0392b;
        }
    }
</style>
