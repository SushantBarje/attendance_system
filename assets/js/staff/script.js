$(document).ready(function(){
    // var now = new Date(),
    // maxDate = now.toISOString().substring(0,10);
    // $('#datetime').prop('max', maxDate);

    getClassAcademic();
    processAttendanceSheet();
    processMarkAttendance();
    generateStaffReport();
    //processSubmitAttendance();
});

function getClassAcademic(){
    $("#select-acd").on("change", function(){
        var id = $(this).val();
        console.log(id);
        $.ajax({
            url : "../controller/ajaxController.php?action=get_acd_class",
            type : "POST",
            data : {'data' : id},
            dataType : "JSON",
            success : function(res){
                console.log(res);
                switch(res.error){
                    case "notexist": 
                        $("#select-class").val(" ");
                        $("#select-class").prop("disabled",true);
                        alert("No Class Found");
                        break;
                    case "none":
                        if(res.data.length > 0){
                            $("#select-class").prop("disabled",false);
                            var html = '<option value=" "> </option>';
                            for(var i = 0; i < res.data.length; i++){
                                html += '<option value="'+res.data[i].class_id+'" data-class="'+res.data[i].s_class_id+'">'+res.data[i].course_name+'</option>';
                            }
                            $('#select-class').html(html);
                        }
                        break;
                }
            }
        })
    })
}

function processAttendanceSheet(){
        $(".sheet-input-field").on("change" ,function(){
            console.log($(this).val());
            if($("#check-attend #select-acd").val() != " " && $("#check-attend #select-class").val() != " " && $("#check-attend #date").val() != "" && $("#check-attend #time").val() != ""){
                var id = $("#check-attend #select-class").find(':selected').data('class');
                var name = $("#check-attend #select-class").text();
                var year = $("#check-attend #select-acd").val();
                var date = $('#check-attend #date').val();
                var time = $("#check-attend #time").val();
                console.log(name,year,date,time);
                ajaxAttendanceList(id,year,name,date,time);
                
            }else{
                console.log("empty");
            }
            //id = $(this).val();
            return false;
        });

    // $("#select-acd").on("change",function(){
    //     var data = {}
    //     id = $(this).find(":selected").data('class');
    //     var year = $("#select-acd").val();
    //     if(id == ' '){
    //         $("#attendance-table tbody").html(" ");
    //         alert("Select Class!");
    //         return;
    //     }
    //     if(year == ' '){
    //         $("#selec-class").val(" ");
    //         alert("Selec Academic Year");
    //         return;
    //     }
    // })


    // function ajaxAttendanceList(id,year){
    //     console.log(id);
    //     $.ajax({
    //         url : "../controller/ajaxController.php?action=attendanceSheet",
    //         type : "post",
    //         data : {data : id, year : year},
    //         dataType : 'json',
    //         success : function(res){
    //             console.log(res);
    //             $("#attendance-table").removeAttr("hidden");
    //             $("#save-btn").removeAttr("hidden");
    //             var html = "";
    //             for(var i = 0; i < res.length; i++){
    //                 var name = res[i].last_name +" "+ res[i].first_name+" "+res[i].middle_name;
    //                 var obj = '<label for="present">Present</label><input type="radio" class="form-control" name="attend['+res[i].prn_no+']" value="1" checked/><label for="absent">Absent</label> <input type="radio" name="attend['+res[i].prn_no+']" value="0"/>';
    //                 var prn = '<input type="text" name="prn['+res[i].prn_no+']" value="'+res[i].prn_no+'" hidden>';
    //                 html += '<tr><td>'+res[i].roll_no+'</td><td>'+name+'</td><td>'+obj+'</td><td hidden>'+prn+'</td></tr>';
    //             }
    //             $('#attendance-table tbody').html(html);
    //         }
    //     })
    // }

    function ajaxAttendanceList(id,year,name,date, time){
        console.log(id);
        $.ajax({
            url : "../controller/ajaxController.php?action=attendanceSheet",
            type : "post",
            data : {data : id, year : year, date : date, time : time},
            dataType : 'json',
            success : function(res){
                console.log(res);
                $("#attend-list").removeAttr("hidden");
                $("#save-btn").removeAttr("hidden");
                var html = "";
                if(res.length < 0) $('#attend-list').html('<div>Nothing Found<div>');
                for(var i = 0; i < res.length; i++){
                    html += '<div class="grid-item m-2 mark-attend">\
                                <input type="hidden" name="attend['+res[i].prn_no+']" value="1" data-id="'+res[i].prn_no+'"/>\
                                <p>'+res[i].roll_no+'</p>\
                                <button type="button" class="btn btn-success rounded-0 marker">P</button>\
                            </div>'
                }
                $('#attend-list').html(html);
                $('#class-header').html('<h5><b>Course:- </b>'+name+'</h5>');
                var d = new Date(date + 'T' + time);
                var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
                $('#date-header').html('<h6><b>Date:- </b>'+strDate+'</h6>')
            }
        })
    }
}


function processMarkAttendance(){
    $('#attend-list').on("click", '.marker', function(){
        if($(this).text() == "P"){
            $(this).text("A");
            $(this).removeClass("btn btn-success");
            $(this).addClass("btn btn-danger");
            $(this).attr("data-control",0);
            $(this).parent().find('input').val(0); 
        }else{
            $(this).text("P");
            $(this).removeClass("btn btn-danger");
            $(this).addClass("btn btn-success");
            $(this).attr("data-control",1);
            $(this).find('input').val(1);
            $(this).parent().find('input').val(1)
        }
    }); 
}

// function processSubmitAttendance(){
//     $("#check-attend").on("submit",function(e){
//         e.preventDefault();
//         var data = $(this).serialize();
//         $.ajax({
//             type: 'POST',
//             url: '../controller/ajaxController.php?action=save_attend',
//             data: {"data" : data},
//             dataType: 'json',
//             contentType: false,
//             processData: false,
//             success: function(res){
//                 console.log(res);
//                 switch(res.error){
//                     case "none":
//                         alert("Attendence Submitted");
//                         break;
//                 }
//             },
//             error : function(e){
//                 console.log(e);
//             }
//         })
    
//     })
// }


function generateStaffReport(){
    $("#get-report").on("click", function(){
        var data = {};
        $.when(
            data[$("#report #select-acd").attr("name")] = $("#report #select-acd").val(),
            data[$("#report #select-class").attr("name")] = $("#report #select-class").val(),
            data[$("#report #from-date").attr("name")] = $("#report #from-date").val(),
            data[$("#report #till-date").attr("name")] = $("#report #till-date").val(),
        ).then(
            getAjaxReport()
        )
        function getAjaxReport(){
            console.log(data)
            $.ajax({
                url : "../controller/ajaxController.php?action=staff_report",
                type : "post",
                data : data,
                dataType : "JSON",
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            alert("Enter all Details...");
                            break;
                        case "notexists":
                            if($.fn.dataTable.isDataTable("#staff-report")){
                                $("#staff-report").DataTable().destroy();
                                $("#staff-report thead tr").html(" ");
                                $("#staff-report tbody").html(" ");
                            }
                            alert("NO attendance Found")
                            break;
                        case "date":
                            alert("Please Enter Correct Date");
                            break;
                        case "none":
                            if($.fn.dataTable.isDataTable("#staff-report")){
                                $("#staff-report").DataTable().destroy();
                                $("#staff-report thead tr").html(" ");
                                $("#staff-report tbody").html(" ");
                            }  
                            var columns = Object.keys(res.data[0]);
                            var datecolumns = columns.slice(3);
                            var numCol = datecolumns.length;
                            var th = "";
                            th += "<th>Roll no.</th>";
                            th += "<th>Student Name.</th>";
                            for(var i = 0; i < numCol; i++){
                                // if(columns[i] == "student_id") continue;
                                th += "<th>"+datecolumns[i]+"</th>";
                            } 
                            th += "<th>Total</th>"; 
                            th += "<th>Percentage</th>";
                            var td = "";
                            for(var i = 0; i < res.data.length; i++){
                                td += "<tr>"
                                td += "<td>"+res.data[i].roll_no+"</td>";
                                td += "<td>"+res.data[i].student_name+"</td>";
                                for(var j = 0; j < numCol; j++){
                                    //if(columns[j] == "student_id") continue;
                                    td += "<td>"+res.data[i][datecolumns[j]]+"</td>";
                                } 
                                td += "<td>"+res.total[i].total+"</td>";
                                td += '<td style="mso-number-format:0.00%">'+res.total[i].percent+'</td>';
                                td += "</tr>"
                            }
                            $("#staff-report thead tr").html(th);
                            $("#staff-report tbody").html(td);
                            var table = $("#staff-report").DataTable(
                                {
                                    scrollY:        "500px",
                                    scrollX:        true,
                                    scrollCollapse: true,
                                    paging:         false,
                                    autoWidth:  false,
                                    fixedColumns:   {
                                        leftColumns: 2,
                                        rightColumns: 1
                                    },
                                    dom: 'Bfrtip',
                                    buttons: [
                                        'copy', 'csv', 'excel', 'pdf', 'print'
                                    ],
                                }
                            );
                            break;
                    }
                    
                },
                error : function(e){
                    console.log(e);
                }
            })
        }
    })
}