<?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        echo "<script>alert('Utente non registrato');</script>";
        header("Location: ../logout.php");
        exit();
    }
?>
<html>

<head>
    <title>Aggiungi Stazione</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        $(document).ready(function(){
            $("#creaStazioneForm").submit(function(e){ 
                e.preventDefault();
                aggiungiStazione(); 
            });
        });
        function aggiungiStazione(){
            let numSlot = $('#numSlot').val();
            let numBiciclette = $('#numBiciclette').val();
            let via = $('#via').val();
            let citta = $('#citta').val();
            let provincia = $('#provincia').val();
            let regione = $('#regione').val();
            $.ajax({
                url: '../ajax/stazioni/aggiungiStazione.php',
                type: 'POST',
                data: {
                    numSlot: numSlot,
                    numBiciclette: numBiciclette,
                    via: via,
                    citta: citta,
                    provincia: provincia,
                    regione: regione,
                },
                dataType: 'json',
                success: function (response) {
                    alert(response.message);
                    window.location.href = "../mappa.php";
                },
                error: function () {
                    alert('Si e verificato un errore durante la creazione della stazione.');
                }
            });
        };
    </script>
</head>

<body>
    <h1>Aggiungi stazione</h1>

    <form id="creaStazioneForm">
        <input type="number" id="numSlot" name="numSlot" placeholder="Numero slot"><br>
        <input type="number" id="numBiciclette" name="numBiciclette" placeholder="Numero biciclette"><br>
        <input type="text" id="via" name="via" placeholder="Via"><br>

        <label for="citta">Citta</label><br>
        <input type="text" id="citta" placeholder="Milano" name="citta" value="Milano" disabled><br>

        <label for="provincia">Provincia</label><br>
        <input type="text" id="provincia" placeholder="Milano" name="provincia" value="Milano" disabled><br>

        <label for="regione">Regione</label><br>
        <input type="text" id="regione" placeholder="Lombardia" name="regione" value="Lombardia" disabled><br>

        <input type="submit" id="submit" value="Aggiungi Stazione">
    </form>

</body>

</html>