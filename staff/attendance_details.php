<?php
    $data = $_POST['data'];
    $count = $_POST['count'];
    foreach($data as $d){
        echo '<a href="#attend_taken_list_'.$d['class_id'].'_'.$d['date_time'].'" class="btn btn-primary m-4" id="'.$d['class_id'].'">'.$d['date_time'].'</a>';
    }
?>