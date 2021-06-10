<?php
    $data = $_POST['data'];
    $count = $_POST['count'];
    foreach($data as $d){
        $date = date('d/m/Y h:i:s a ', strtotime($d['date_time']));
        echo '<div class="btn-group mt-4 mr-3" role="group">
                <button class="btn btn-primary" id="'.$d['class_id'].'">'.$date.'</button>
                <a href="attendance_taken_list.php?class_id='.$d['class_id'].'&datetime='.$d['date_time'].'" class="btn btn-success"><i class="far fa-edit"></i></a>
                <button id="'.$d['class_id'].'" data-time="'.$d['date_time'].'" class="btn btn-danger del-attend"><i class="far fa-trash-alt"></i></button>
            </div>
            ';
    }
?>