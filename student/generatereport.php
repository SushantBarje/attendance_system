<?php
    namespace app\student;
    require_once __DIR__ . '\..\vendor\autoload.php';
    use app\controller\StudentController;
    $user = new StudentController();
    if(!isset($_SESSION['prn_no'])){
        header('Location:../index.php');
    }
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html>

<head>   
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script type="text/javascript"  src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <style>
        td.details-control {
            background: url('../assets/images/details_open.png') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('../assets/images/details_close.png') no-repeat center center;
        }
    </style>

</head>

<body>

<body>
<?php   include "studentHeader.php" ?>
    <main>
        <h2 class="head">View Attendance</h2>
        <div class="table-section" class="mt-5">
            <table id="student-report" class="display" >
                <thead>
                    <tr>
                        <th></th>
                        <th>Class :</th>
                        <th>Present</th>
                        <th>Absent</th>
                        <th>Total Lectures</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $result = $user->showGrandReport();
                        foreach($result['data'] as $r){
                            echo '<tr>
                                    <td class="details-control" id="'.$r['class_id'].'"></td>
                                    <th>'.$r['course_name'].'</th>
                                    <td>'.$r['present'].'</td>
                                    <td>'.$r['absent'].'</td>
                                    <td>'.$r['total_lectures'].'</td>
                                    <td>'.$r['percent'].'</td>
                                </tr>
                                ';
                        }
                    ?> 
                    
                </tbody>
            </table>
        </div>
        

    </main>

    <script>
        $(document).ready(function() {
            var table = $("#student-report").DataTable();

            function formatDates(date){
                var date = new Date(date);
                var dd = date.getDate();

                var mm = date.getMonth()+1; 
                var yyyy = date.getFullYear();
                var hour    = date.getHours();
                var minute  = date.getMinutes();
                var second  = date.getSeconds(); 
                if(dd<10) 
                {
                    dd='0'+dd;
                } 

                if(mm<10) 
                {
                    mm='0'+mm;
                } 
                if(hour.toString().length == 1) {
                    hour = '0'+hour;
                }
                if(minute.toString().length == 1) {
                        minute = '0'+minute;
                }
                if(second.toString().length == 1) {
                        second = '0'+second;
                } 
                    date = dd+'/'+mm+'/'+yyyy;
                    time = hour+':'+minute+':'+second;
                    const ampm = hour >= 12 ? 'pm' : 'am';

                    hour %= 12;
                    hour = hour || 12;    
                    minute = minute < 10 ? `${minute}` : minute;
                    const strTime = `${hour}:${minute} ${ampm}`;
                    var formated_date_time = "<th>"+date+" "+strTime+" : </th>";
                    return formated_date_time;
                  
            }
        
            $('#student-report tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );
                var data = $(this).attr('id');
                if ( tr.hasClass("shown") ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    $.ajax({
                        url: "../controller/studentajaxController.php?action=get_student_class_report",
                        type: "post",
                        data : {"data" : data},
                        dataType : "json",
                        success :  function(res){
                            console.log(res);
                            function format ( d ) {
                             
                                html = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'
                                for(var i = 0; i < d.length; i++){
                                    html += '<tr><td>&nbsp;</td><td></td>'+
                                                '<td>'+formatDates(d[i].date_time)+'</td>'
                                                if(d[i].status == 1){
                                                   html += '<td>P</td>'
                                                }else{
                                                    html += '<td style="color:red">A</td>'
                                                }
                                                
                                            '</tr>'
                                }
                                    
                                html += '</table>';
                                return html;
                            }
                            
                            row.child(format(res.data)).show();
                            tr.addClass('shown');
                        }
                    })
                }
            } );
        } );
</script>
</body>
</html>