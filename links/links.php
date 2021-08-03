<?php

    function onlineStylesFiles(){
        echo '  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
                <link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>';
    }

    function onlineJsFiles(){
        echo '  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
                <script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>';
    }

    function OfflineStylesFiles(){
        echo '  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
                <link rel="stylesheet" href="assets/DataTables/datatables.min.css">';
    }

    function OfflineJsFiles(){
        echo '  <script src="assets/jquery/jquery.js"></script>
                <script src="assets/bootstrap/js/bootstrap.min.js"></script>
                <script src="assets/DataTables/datatables.min.js"></script>';
    }
?>