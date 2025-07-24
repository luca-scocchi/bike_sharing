<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Index</title>
    <style>
        #map {
            height: 500px;
            width: 80%;
            margin-top: 25px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCfPK_iMhgxJMbmraGqBe_L6faknvXZXak&callback=initMap"
        async defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            initMap();
        });
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 12,
                center: { lat: 45.4627338, lng: 9.1777323 } //coordinate Milano
            });

            $.ajax({
                url: 'ajax/stazioni/getStazioni.php',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    response.forEach(function (stazione) {
                        var marker = new google.maps.Marker({
                            position: { lat: parseFloat(stazione.latitudine), lng: parseFloat(stazione.longitudine) },
                            map: map,
                            title: stazione.nome
                        });

                        var infoWindow = new google.maps.InfoWindow({
                            content: `
                                <div>
                                    <p>Numero di slot: ${stazione.numSlot}</p>
                                    <p>Numero di biciclette: ${stazione.numBiciclette}</p>
                                    <p>Numero posti liberi: ${stazione.numSlot - stazione.numBiciclette}</p>
                                </div>
                            `
                        });

                        marker.addListener('click', function () {
                            infoWindow.open(map, marker);
                        });
                    });
                },
                error: function () {
                    alert('Si è verificato un errore durante il recupero delle stazioni.');
                }
            });
        }
    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            Bike Sharing
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <?php
                            session_start();
                            if (isset($_SESSION['admin'])) {
                                // Utente loggato come admin
                                echo '<a class="btn btn-primary" href="views/adminDashboard.php">Dashboard Admin</a>';
                            } elseif (isset($_SESSION['user']) ) {
                                // Utente loggato come user
                                echo '<a class="btn btn-primary" href="views/userDashboard.php">Dashboard Utente</a>';
                            } else {
                                // Nessun utente loggato
                                echo '<a class="btn btn-primary" href="login.html">Accedi</a>';
                            }
                        ?>
                        
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div id="map"></div>
</body>


</html>