$(document).ready(function(){
    // var now = new Date(),
    // maxDate = now.toISOString().substring(0,10);
    // $('#datetime').prop('max', maxDate);

    //getClassAcademic();
    processAttendanceSheet();
    processMarkAttendance();
    generateStaffReport();
    AttendanceDetails();
    processDeleteAttendance()
    processOnChangeClass()
    processPracticalAttendance()
    processPracticalReport()
    processPracticalClassByAcademicYear()
    processTheoryClassByAcademicYear()
    processSubmitAttendance();
    processResetDate()
});

// function getClassAcademic(){
//     $("#select-acd").on("change", function(){
//         var id = $(this).val();
//         console.log(id);
//         $.ajax({
//             url : "../controller/ajaxController.php?action=get_acd_class",
//             type : "POST",
//             data : {'data' : id},
//             dataType : "JSON",
//             success : function(res){
//                 console.log(res);
//                 switch(res.error){
//                     case "notexist": 
//                         $("#select-class").val(" ");
//                         $("#select-class").prop("disabled",true);
//                         alert("No Class Found");
//                         break;
//                     case "none":
//                         if(res.data.length > 0){
//                             $("#select-class").prop("disabled",false);
//                             var html = '<option value=" "> </option>';
//                             for(var i = 0; i < res.data.length; i++){
//                                 html += '<option value="'+res.data[i].class_id+'" data-class="'+res.data[i].s_class_id+'">'+res.data[i].course_name+'</option>';
//                             }
//                             $('#select-class').html(html);
//                         }
//                         break;
//                 }
//             }
//         })
//     })
// }

function processAttendanceSheet(){
        var id = class_id = year = date = time = div = sem = " ";
        $(".sheet-input-field").on("change" ,function(){
            console.log($(this).val());
            if($("#check-attend #select-acd").val() != " " && $("#check-attend #select-class").val() != " " && $("#check-attend #date").val() != "" && $("#check-attend #time").val() != ""){
                var id = $("#check-attend #select-class").find(':selected').data('class');
                var class_id = $("#check-attend #select-class").find(':selected').val();
                var name = $("#check-attend #select-class option:selected").text();
                var year = $("#check-attend #select-year").val();
                var date = $('#check-attend #date').val();
                var time = $("#check-attend #time").val();
                var div = $("#check-attend #select-div").val();
                var sem = $("#check-attend #s_sem").val();
                console.log(name,year,date,time);
                ajaxAttendanceList(id,class_id,year,name,date,time,div, sem);  
            }
            
            return false;
        });

        $("#report #s_sem").on("change", function(){
            var acd = $("#select-acd")
            var id = $("#select-div")
            var year = $("#select-year")
            var sem = $(this)
            if((acd.val() != "" || acd.val() != " ") && (id.val() != "" || id.val() != " ") && (year.val() != "" || year.val() != " ") && (sem.val() != "" || sem.val() != " ")){
                showClassBySem(id.val(), acd.val(), year.val(), sem.val());
            }
        });

        
        $("#check-attend #s_sem").on("change", function(){
            var acd = $("#check-attend #select-acd");
            var id = $("#check-attend #select-div")
            var year = $("#check-attend #select-year")
            var sem = $(this)
            console.log(acd.val());
            if((acd.val() != "" || acd.val() != " ") && (id.val() != "" || id.val() != " ") && (year.val() != "" || year.val() != " ") && (sem.val() != "" || sem.val() != " ")){
                showClassBySem(id.val(), acd.val(), year.val(), sem.val());
            }
        });

        function showClassBySem(id, acd, year, sem){
            console.log(id,acd,sem,year);
            $.ajax({
                url : "../controller/ajaxController.php?action=get_class_div_wise",
                type : "post",
                data : {"id" : id, "acd" : acd, "year" : year, "sem" : sem},
                dataType : "json",
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            $("#select-class").val(" ");
                            $("#select-class").text(" ");
                            alert("Please fill all details!");
                            break;
                        case "notfound":
                            $("#select-class").val(" ");
                            $("#select-class").text(" ");
                            $("#select-class").text("No class found");
                            break;
                        case "none":
                            $("#select-class").prop("disabled", false);
                            $("#select-class").val(" ");
                            $("#select-class").text(" ");
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
        }

        

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

    function ajaxAttendanceList(id, class_id, year, name, date, time, div, sem){
        console.log(id);
        $.ajax({
            url : "../controller/ajaxController.php?action=attendanceSheet",
            type : "post",
            data : {id : id, class_id : class_id, year : year, date : date, time : time, div : div, sem : sem},
            dataType : 'json',
            success : function(res){
                console.log(res);
                switch(res.error){
                    case "empty" :
                        alert("Please fill all details.");
                        break;
                    case "nostudent":
                        $("#attend-list").removeAttr("hidden");
                        $("#attend-list").html("<h3>No students found.<h3>");
                        break;
                    case "notfound" :
                        $("#attend-list").removeAttr("hidden");
                        $("#save-btn").removeAttr("hidden");
                        var html = "";
                        for(var i = 0; i < res.data.length; i++){
                            html += '<div class="grid-item m-2 mark-attend">\
                                        <input type="hidden" name="attend['+res.data[i].prn_no+']" value="1" data-id="'+res.data[i].prn_no+'"/>\
                                        <p class="mt-2">'+res.data[i].roll_no+'</p>\
                                        <button type="button" class="btn btn-success rounded-0 marker">P</button>\
                                    </div>'
                        }
                        $('#attend-list').html(html);
                        $('#class-header').html('<h5><b>Course:- </b>'+name+'</h5>');
                        var d = new Date(date + 'T' + time);
                        var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
                        $('#date-header').html('<h6><b>Date:- </b>'+strDate+'</h6>');
                        break;
                    case "none":
                        $("#attend-list").removeAttr("hidden");
                        $("#save-btn").removeAttr("hidden");
                        var html = "";
                        for(var i = 0; i < res.data.length; i++){
                            if(res.data[i].status == 0){
                                html += '<div class="grid-item m-2 mark-attend">\
                                        <input type="hidden" name="attend['+res.data[i].prn_no+']" value="0" data-id="'+res.data[i].prn_no+'"/>\
                                        <p class="mt-2">'+res.data[i].roll_no+'</p>\
                                        <button type="button" class="btn btn-danger rounded-0 marker">A</button>\
                                    </div>'
                            }else{
                                html += '<div class="grid-item m-2 mark-attend">\
                                        <input type="hidden" name="attend['+res.data[i].prn_no+']" value="1" data-id="'+res.data[i].prn_no+'"/>\
                                        <p class="mt-2">'+res.data[i].roll_no+'</p>\
                                        <button type="button" class="btn btn-success rounded-0 marker">P</button>\
                                    </div>'
                            } 
                        }
                        $('#attend-list').html(html);
                        $('#class-header').html('<h5><b>Course:- </b>'+name+'</h5>');
                        var d = new Date(date + 'T' + time);
                        var strDate = d.getFullYear() + "/" + (d.getMonth()+1) + "/" + d.getDate();
                        $('#date-header').html('<h6><b>Date:- </b>'+strDate+'</h6>');
                        break;
                }
            }
        })
    }
}


function processMarkAttendance(){
    $("#pract-attend-list").on("click",".marker", function(){
        marker($(this))
    })

    $('#attend-list').on("click", '.marker', function(){
        marker($(this))
    }); 

    $('#theory-attend-list').on("click", '.marker', function(){
        marker($(this))
    }); 

    function marker(selector){
        if(selector.text() == "P"){
            selector.text("A");
            selector.removeClass("btn btn-success");
            selector.addClass("btn btn-danger");
            selector.attr("data-control",0);
            selector.parent().find('input').val(0); 
            var count = parseInt(selector.parent().find('.present').text());
            selector.parent().find('.present').text(count - 1);
        }else{
            selector.text("P");
            selector.removeClass("btn btn-danger");
            selector.addClass("btn btn-success");
            selector.attr("data-control",1);
            selector.find('input').val(1);
            selector.parent().find('input').val(1)
            var count = parseInt(selector.parent().find('.present').text());
            selector.parent().find('.present').text(count + 1);
        }
    }


}

function processSubmitAttendance(){
    $("#check-attend-theory").on("change",".sheet-input-field-theory" ,function(){
        var date = $("#check-attend-theory #date-theory");
        var time = $("#check-attend-theory #time-theory");
        var class_id = $("#class_id");
        console.log(class_id);
        if(date.val() != "" && time.val() != ""){
            $.ajax({
                url : "../controller/ajaxController.php?action=check_theory_attend",
                type : "POST",
                data : {"class_id" : class_id.val(), "date" : date.val(), "time" : time.val()},
                dataType : "json",
                success : function(res){
                    console.log(res.total);
                    switch(res.error){
                        case "empty":
                            alert("Please fill all details.");
                            break;
                        case "notfound":
                            break;
                        case "none":
                            if(!confirm("Already Attendance Take Do you want to edit!")){
                                break;
                            }else{
                                var html = "";
                                for(var i = 0; i < res.data.length; i++){
                                    var present = parseInt(res.total[i].total_present);
                                    if(res.data[i].status == 0){
                                        html += '<div class="grid-item m-2 mark-attend">\
                                                <input type="hidden" name="attend['+res.data[i].prn_no+']" value="0" data-id="'+res.data[i].prn_no+'"/>\
                                                <span class="btn roll_no"><a href="#?prn_no='+res.data[i].prn_no+'" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><b>'+res.data[i].roll_no+'</b></a></span> : <span class="present">'+present+'</span>\
                                                <button type="button" class="btn btn-danger rounded-0 marker">A</button>\
                                            </div>'
                                    }else{
                                        html += '<div class="grid-item m-2 mark-attend">\
                                                <input type="hidden" name="attend['+res.data[i].prn_no+']" value="1" data-id="'+res.data[i].prn_no+'"/>\
                                                <span class="btn roll_no"><a href="#?prn_no='+res.data[i].prn_no+'" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><b>'+res.data[i].roll_no+'</b></a></span> : <span class="present">'+present+'</span>\
                                                <button type="button" class="btn btn-success rounded-0 marker">P</button>\
                                            </div>'
                                    } 
                                }
                                $("#theory-attend-list").html(" ");
                                $("#theory-attend-list").html(html);

                                window
                            }
                            break;
                    }
                }
            });
        }
    })
    
    $("#check-attend-theory").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            url: '../controller/ajaxController.php?action=save_attend',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res){
                console.log(res);
                switch(res.error){
                    case "empty":
                        alert("Please fill date and time");
                        break;
                    case "update":
                        alert("Attendance Updated!");
                        history.go(-1);
                        break;
                    case "none":
                        alert("Attendance Submitted");
                        history.go(-1);
                        break;
                }
                return false;
            },
            error : function(e){
                console.log(e);
            }
        })
    
    })
}


function generateStaffReport(){
    $("#report").on("change", ".report-select-input", function() {
        if($("#report #select-acd").val() != " " && $("#report #select-year").val() != " " && $("#report #select-div").val() != " "){
            var acd = $("#report #select-acd").val();
            var year = $("#report #select-year").val();
            var div = $("#report #select-div").val();
            console.log(acd,year,div);
            $.ajax({
                url : "../controller/ajaxController.php?action=get_class_div_wise",
                type : "post",
                data : {"id" : div, "acd" : acd, "year" : year},
                dataType : "json",
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            $("#select-class").prop("disabled", true);
                            $("#select-class").val(" ");
                            $("#select-class").text(" ");
                            alert("Please fill all details!");
                            break;
                        case "notfound":
                            $("#select-class").val(" ");
                            $("#report #select-class").text("No class found");
                            break;
                        case "none":
                            $("#select-class").prop("disabled", false);
                            $("#select-class").val(" ");
                            $("#select-class").text(" ");
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
        }else{
            console.log("empty");
        }
    })

    $("#report #get-report").on("click", function(){
        var data = {};
        var title = "";
        $.when(
            data[$("#report #select-acd").attr("name")] = $("#report #select-acd").val(),
            data[$("#report #select-class").attr("name")] = $("#report #select-class").val(),
            data[$("#report #select-year").attr("name")] = $("#report #select-year").val(),
            data[$("#report #select-div").attr("name")] = $("#report #select-div").val(),
            data[$("#report #from-date").attr("name")] = $("#report #from-date").val(),
            data[$("#report #till-date").attr("name")] = $("#report #till-date").val(),
            data[$("#report #s_sem").attr("name")] = $("#report #s_sem").val(),
            title = $("#report #select-class option:selected").text(),
            academic_year = $("#report #select-acd option:selected").text(),
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
                            if($.fn.dataTable.isDataTable("#staff-report")){
                                $("#staff-report").DataTable().destroy();
                                $("#staff-report thead tr").html(" ");
                                $("#staff-report tbody").html(" ");
                            }
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
                                var date = new Date(datecolumns[i]);
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
                                th += "<th>"+date+" </br> "+time+"</th>";
                            } 
                            th += "<th>Total</th>"; 
                            th += "<th>Percentage</th>";
                            var td = "";
                            for(var i = 0; i < res.data.length; i++){
                                td += "<tr>"
                                td += "<td>"+res.data[i].roll_no+"</td>";
                                td += "<td>"+res.data[i].student_name+"</td>";
                                for(var j = 0; j < numCol; j++){
                                    if(res.data[i][datecolumns[j]] == 1){
                                        td += "<td>P</td>"
                                    }else{
                                        td += "<td style='color:red'>A</td>"
                                    }
                                } 
                                if(res.total[i].total == ""){
                                    td += "<td>NA</td>";
                                    td += '<td style="mso-number-format:0.00%">NA</td>';
                                }else{
                                    td += "<td>"+res.total[i].total+"</td>";
                                    td += '<td style="mso-number-format:0.00%">'+res.total[i].percent+'</td>';
                                }
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
                                        {
                                            extend: 'excel',
                                            text : 'Export Excel',
                                            title : res.dept[0].dept_name+"-"+res.year[0].s_class_name,
                                            messageTop: title+" Attendance Academic Year "+academic_year,
                                        }
                                    ]
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


function AttendanceDetails(){
    $(document).on("change", "#attend-details #select-acd", function(e){
        e.preventDefault();
        var acd = $("#select-acd").val();
        var class_id = $("#select-class option:selected").val();
        console.log(class_id);
        if(acd != " "){
            $.ajax({
                url : "../controller/ajaxController.php?action=get_class_div_wise",
                type : "post",
                data : {"acd" : acd, "for" : "detail"},
                dataType : "json",
                success : function(res){
                    switch(res.error){
                        case "empty":
                            alert("Please fill all details");
                            break;
                        case "notfound":
                            $("#box-content").html("<h4>Nothing found!</h4>");
                            break;
                        case "none":
                            var html = "";
                            html += '<option value=" "> </option>'
                            for(var i = 0; i < res.data.length; i++){
                                html += '<option value="'+res.data[i].class_id+'">'+res.data[i].course_name+' Div-'+res.data[i].div_name+'</option>';
                            }
                            $("#select-class").html(html);
                            break;
                    }
                    
                },
                error : function(e){
                    console.log(e);
                }
            })
        }
        //else if(acd != " " && class_id != " "){
        //     $.ajax({
        //         url : "../controller/ajaxController.php?action=get_attend_details_class",
        //         type : "post",
        //         data : {"acd" : acd, "class_id": class_id, "for" : "detail"},
        //         dataType : "json",
        //         success : function(res){
        //             switch(res.error){
        //                 case "empty":
        //                     alert("Please fill all details");
        //                     break;
        //                 case "notfound":
        //                     $("#box-content").html("<h4>Nothing found!</h4>");
        //                     break;
        //                 case "none":
        //                     var html = "";
        //                     html += '<option value=" "> </option>'
        //                     for(var i = 0; i < res.data.length; i++){
        //                         html += '<option value="'+res.data[i].class_id+'">'+res.data[i].course_name+' Div-'+res.data[i].div_name+'</option>';
        //                     }
        //                     $("#select-class").html(html);
        //                     $("#box-content").load("attendance_details.php", {"data" : res.data, "count" : res.count});  
        //                     break;
        //             }
                    
        //         },
        //         error : function(e){
        //             console.log(e);
        //         }
        //     })
        // }

        $(document).on("click", "#check-details", function(){
            var acd = $("#select-acd").val();
            var class_id = $("#select-class").val();
            console.log(class_id);
            $.ajax({
                url : "../controller/ajaxController.php?action=get_attend_details_class",
                type : "post",
                data : {"acd" : acd, "class_id": class_id},
                dataType : "json",
                success : function(res){
                    switch(res.error){
                        case "empty":
                            alert("Please fill all details");
                            break;
                        case "notfound":
                            $("#box-content").html("<h4>Nothing found!</h4>");
                            break;
                        case "none":
                            var html = "";
                            html += '<option value=" "> </option>'
                            for(var i = 0; i < res.data.length; i++){
                                html += '<option value="'+res.data[i].class_id+'">'+res.data[i].course_name+' Div-'+res.data[i].div_name+'</option>';
                            }
                            $("#box-content").load("attendance_details.php", {"data" : res.data, "count" : res.count});  
                            break;
                    }
                    
                },
                error : function(e){
                    console.log(e);
                }
            })
        })
    })
}


function processDeleteAttendance(){
    $(document).on("click", ".del-attend", function(){
        var class_id = $(this).attr("id");
        var date_time = $(this).data("time");
        console.log(class_id);
        console.log(date_time);
        $.ajax({
            url : "../controller/ajaxController.php?action=del_attend",
            type : "post",
            data : {"class" : class_id, "date_time" : date_time},
            dataType : "json",
            success : function(res){
                console.log(e);
            },
            error : function(e){
                console.log(e);
            }
        })
    })
}

function processOnChangeClass(){
    $("#select-year").on("change", function(){
        var id = $(this).val();
        console.log(id);
        if(id == " ") return $("#s_sem").html('<option value="'+' '+'">Select Year</option>').prop("disabled",true);
        $.ajax({
            url : "../controller/ajaxController.php?action=getSem",
            type : "post",
            data : {data : id},
            dataType : "json",
            success : function(res){
                console.log(res);
                if(res.data.length > 0){
                    $("#s_sem").prop("disabled",false);
                    var html = "";
                    html += '<option value=""></option>';
                    for(var i = 0; i < res.data.length; i++){
                        html += '<option value="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</option>';
                    }
                    $('#s_sem').html(html);
                }
            }
        })
    })
}



function processPracticalAttendance(){
    $("#check-attend-pract").on("change",".sheet-input-field-pract" ,function(){
        var date = $("#date-pract");
        var time = $("#time-pract");
        var class_id = $("#class_id_pract");
        console.log(class_id);
        if(date.val() != "" && time.val() != ""){
            $.ajax({
                url : "../controller/ajaxController.php?action=check_pract_attend",
                type : "POST",
                data : {"class_id" : class_id.val(), "date" : date.val(), "time" : time.val()},
                dataType : "json",
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            alert("Please fill all details.");
                            break;
                        case "notfound":
                            break;
                        case "none":
                            if(!confirm("Already Attendance Take Do you want to edit!")){
                                break;
                            }else{
                                var html = "";
                                for(var i = 0; i < res.data.length; i++){
                                    var present = parseInt(res.total[i].total_present);
                                    if(res.data[i].status == 0){
                                        html += '<div class="grid-item m-2 mark-attend">\
                                                <input type="hidden" name="attend['+res.data[i].prn_no+']" value="0" data-id="'+res.data[i].prn_no+'"/>\
                                                <span class="btn roll_no"><a href="#?prn_no='+res.data[i].prn_no+'" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><b>'+res.data[i].roll_no+'</b></a></span> : <span class="present">'+present+'</span>\
                                                <button type="button" class="btn btn-danger rounded-0 marker">A</button>\
                                            </div>'
                                    }else{
                                        html += '<div class="grid-item m-2 mark-attend">\
                                                <input type="hidden" name="attend['+res.data[i].prn_no+']" value="1" data-id="'+res.data[i].prn_no+'"/>\
                                                <span class="btn roll_no"><a href="#?prn_no='+res.data[i].prn_no+'" data-toggle="tooltip" data-placement="top" title="Tooltip on top"><b>'+res.data[i].roll_no+'</b></a></span> : <span class="present">'+present+'</span>\
                                                <button type="button" class="btn btn-success rounded-0 marker">P</button>\
                                            </div>'
                                    } 
                                }
                                $("#pract-attend-list").html(" ");
                                $("#pract-attend-list").html(html);
                            }
                            break;
                    }
                }
            });
        }
    })

    $("#check-attend-pract").on("submit", function(e){
        e.preventDefault(); 
        $.ajax({
            url : "../controller/ajaxController.php?action=save_pract_attendance",
            type : "post",
            data : $(this).serialize(),
            dataType : 'json',
            success : function(res){
                console.log(res);
                switch(res.error){
                    case "empty":
                        alert("Please fill date and time");
                        break;
                    case "update":
                        alert("Attendance Updated!");
                        history.go(-1);
                        break;
                    case "none":
                        alert("Attendance Submitted");
                        //  location.href = window.location.href+"/.../new_attendance.php";
                        history.go(-1);
                        break;
                }
                return false;
            },
            error : function(e){
                console.log(e);
            }
        })
    })
}


function processPracticalReport(){
    $("#report-pract").on("change", ".report-select-input", function() {
        if($("#report-pract #select-acd").val() != "" && $("#report-pract #select-year").val() != "" && $("#report-pract #s_sem").val() != "" && $("#report-pract #select-div").val() != ""){
            var acd = $("#report-pract #select-acd").val();
            var year = $("#report-pract #select-year").val();
            var sem = $("#report-pract #s_sem").val();
            var div = $("#report-pract #select-div").val();
            console.log(acd,year,sem);
            $.ajax({
                url : "../controller/ajaxController.php?action=get_pract_class_sem_wise",
                type : "post",
                data : {"sem" : sem, "acd" : acd, "year" : year, "div" : div},
                dataType : "json",
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            $("#report-pract #select-class").prop("disabled", true);
                            $("#report-pract #select-class").val(" ");
                            $("#report-pract #select-class").text(" ");
                            alert("Please fill all details!");
                            break;
                        case "notfound":
                            $("#report-pract #select-class").html("<option>No class Found</option>");
                            //$("#report-pract #report #select-class").text("No class found");
                            break;
                        case "none":
                            $("#report-pract #select-class").prop("disabled", false);
                            $("#report-pract #select-class").val(" ");
                            $("#report-pract #select-class").text(" ");
                            if(res.data.length > 0){
                                $("#report-pract #select-class").prop("disabled",false);
                                var html = '<option value=" "> </option>';
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<option value="'+res.data[i].course_id+'" data-class="'+res.data[i].year_id+'">'+res.data[i].course_name+'</option>';
                                }
                                $('#report-pract #select-class').html(html);
                            }
                            break;
                    }
                }
            })
        }else{
            console.log("empty");
        }
    });

    $("#report-pract").on("submit", function(e){
        e.preventDefault();
        $.ajax({
            url : "../controller/ajaxController.php?action=get_staff_pract_report",
            type : "post",
            data : $(this).serialize(),
            dataType : "json",
            error : function(e){
                console.log(e);
            },
            success : function(res){
                console.log(res);
                DrawpracticalReportTableOfParticularClass(res)
            }
        })
    })

    function DrawpracticalReportTableOfParticularClass(res){
        switch(res.error){
            case "empty":
                if($.fn.dataTable.isDataTable("#hod-report-adv")){
                    $("#hod-report-adv").DataTable().destroy();
                    $("#hod-report-adv thead").html(" ");
                    $("#hod-report-adv tbody").html(" ");
                } 

                if($.fn.dataTable.isDataTable(".staff-pract-report")){
                    $(".report-tables").html(" ");
                } 
                alert("Enter all Details...");
                break;
            case "notfound":
                if($.fn.dataTable.isDataTable("#hod-report-adv")){
                    $("#hod-report-adv").DataTable().destroy();
                    $("#hod-report-adv thead").html(" ");
                    $("#hod-report-adv tbody").html(" ");
                } 

                if($.fn.dataTable.isDataTable(".staff-pract-report")){
                    $(".report-tables").html(" ");
                } 
                alert("No attendance Found")
                $("#report-pract #select-class").val(" ");
                break;
            case "date":
                alert("Please Enter Correct Date");
                break;
            case "none":
                if($.fn.dataTable.isDataTable("#hod-report-adv")){
                    $("#hod-report-adv").DataTable().destroy();
                    $("#hod-report-adv thead").html(" ");
                    $("#hod-report-adv tbody").html(" ");
                } 

                if($.fn.dataTable.isDataTable(".staff-pract-report")){
                    $(".report-tables").html(" ");
                } 
                var course = $("#report-pract #select-class option:selected").text();
                var year = $("#report-pract #select-year option:selected").text();
                var table = "";
                
                Object.keys(res.data).map(function(k){
                    $('.report-tables').append("<div class='mt-4'></div><h4 style='text-align:center'>Batch - "+res.data[k][0].batch_name+"</h4>")
                    $('.report-tables').append('<button type="button" class="btn btn-success export" id="'+res.data[k][0].batch_name+'">Print</button>');
                    var table = $('<table/>').attr({
                        id : "staff-pract-report_"+res.data[k][0].batch_name,
                        class : "staff-pract-report stripe row-border order-column cell-border"
                    });
                    table.append("<thead></thead><tbody></tbody><tfoot></tfoot>");
                    var columns = Object.keys(res.data[k][0]);
                    var datecolumns = columns.slice(7);
                    var numCol = datecolumns.length;
                    var th = "<tr>";
                    th += "<th>Roll no.</th>";
                    th += '<th>Student Name.</th>';
                    for(var i = 0; i < numCol; i++){
                        // if(columns[i] == "student_id") continue;
                        var date = new Date(datecolumns[i]);
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
                        th += "<th>"+date+" </br> "+time+"</th>";
                    } 
                    th += "<th>Total</th>"; 
                    th += "<th>Percentage</th></tr>";
                    tfoot = "<tr>";
                    tfoot += "<td colspan='2'><b>Total Present</b></td>"
                    for(var z = 0; z < numCol; z++){
                        var sum = 0;
                        for(var x = 0; x < res.data[k].length; x++){
                            if(res.data[k][x][datecolumns[z]] == 1){
                                sum++;
                            }
                        }
                        tfoot += "<td><b>"+sum+"</b></td>";
                    }
                    tfoot += '<td colspan="2">&nbsp</td>'
                    tfoot += "</tr>";
                    console.log(tfoot);
                    var td = "";
                    for(var i = 0; i < res.data[k].length; i++){
                        td += "<tr>"
                        td += "<td>"+res.data[k][i].roll_no+"</td>";
                        td += "<td>"+res.data[k][i].student_name+"</td>";
                        for(var j = 0; j < numCol; j++){
                            if(res.data[k][i][datecolumns[j]] == 1){
                                td += "<td>P</td>"
                            }else{
                                td += "<td style='color:red'>A</td>"
                            }
                        } 
                        if(res.data[k][i].total == ""){
                            td += "<td>NA</td>";
                            td += '<td style="mso-number-format:0.00%">NA</td>';
                        }else{
                            td += "<td>"+res.data[k][i].total+"</td>";
                            td += '<td style="mso-number-format:0.00%">'+parseFloat(res.data[k][i].percent).toFixed(2) +'%'+'</td>';
                        }
                        td += "</tr>"
                    }
                    table.find("thead").html(th);
                    table.find("tbody").html(td);
                    table.find("tfoot").html(tfoot);
                    $(".report-tables").append(table);
                    table.DataTable(
                        {
                            scrollY:        "300px",
                            scrollX:        true,
                            scrollCollapse: true,
                            paging:         false,
                            autoWidth:  false,
                            fixedColumns:   {
                                leftColumns: 2,
                                rightColumns: 1
                            }
                        }
                    );
                }   );
                
                // $(".export").on("click", function(){
                //     var id = $(this).attr('id');
                //     console.log(id);
                //     $("#staff-pract-report_"+id).table2excel({
                //         name: "Worksheet Name",
                //         filename: "SomeFile.xlsx",
                //         fileext: ".xlsx",
                //         preserveColors: false
                //     }); 
                // })
                // var wb = XLSX.utils.table_to_book(document.getElementById('mytable'), {sheet:"Sheet JS"});
                // var wbout = XLSX.write(wb, {bookType:'xlsx', bookSST:true, type: 'binary'});
                function s2ab(s) {
                    var buf = new ArrayBuffer(s.length);
                    var view = new Uint8Array(buf);
                    for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                    return buf;
                }
                $(".export").click(function(){
                    var id = $(this).attr("id");
                    var wb = XLSX.utils.table_to_book(document.getElementById("staff-pract-report_"+id), {sheet:"Sheet JS"});
                    var wbout = XLSX.write(wb, {bookType:'xlsx', bookSST:true, type: 'binary'});
                    saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), 'test.xlsx');
                });
                break;
        }
    }
}

function processPracticalClassByAcademicYear(){
    
    $("#attend-class #acd_id").on("change", function(){
        var id = $(this).val();
        var prev_acd_id = $("#attend-class #acd_id option:selected").val()
        console.log(prev_acd_id)
        var acd_select = $(this);
        $.ajax({
            url : "../controller/ajaxController.php?action=get_pract_class_by_acd",
            type : "POST",
            data : {"id" : id},
            dataType : "json",
            success : function(res){
                switch(res.error){
                    case "empty":
                        alert("Please Select Academic Year");
                        break;
                    case "notfound":
                        alert("No class found !");
                        $("#attend-class #acd_id").val(prev_acd_id);
                        break;
                    case "none":
                        var html = " ";
                        for(var i = 0; i < res.data.length; i++){
                            html += '<a href="mark_pract_attendance_demo.php?practical_class='+res.data[i].p_class_id+'" class="shadow p-3 mb-4 bg-white rounded">\
                                        <div class="class-box">\
                                            <div class="div">\
                                                <div><strong>Course: </strong>'+res.data[i].course_name+'</div>\
                                                <div><strong>Class: </strong>'+res.data[i].s_class_name+' <strong>Div: </strong> '+res.data[i].div_name+'</div>\
                                                <div><strong>Batch: </strong>'+res.data[i].batch_name+'</div>\
                                            </div>\
                                        </div>\
                                    </a>'
                        }
                        $("#show_pract_class").html(html);
                        break;
                }
            },
            error : function(err){
                console.log(err);
            }
        })
    })
}


function processTheoryClassByAcademicYear(){
    $("#attend-class-theory #acd_id").on("change", function(){
        var id = $(this).val();
        var prev_acd_id = $("#attend-class-theory #acd_id option:selected").val()
        console.log(prev_acd_id)
        var acd_select = $(this);
        $.ajax({
            url : "../controller/ajaxController.php?action=get_theory_class_by_acd",
            type : "POST",
            data : {"id" : id},
            dataType : "json",
            success : function(res){
                switch(res.error){
                    case "empty":
                        alert("Please Select Academic Year");
                        break;
                    case "notfound":
                        alert("No class found !");
                        $("#attend-class-theory #acd_id").val(prev_acd_id);
                        break;
                    case "none":
                        var html = " ";
                        for(var i = 0; i < res.data.length; i++){
                            html += '<a href="theory_mark_attend.php?theory_class='+res.data[i].class_id+'" class="shadow p-3 mb-5 bg-white rounded">\
                                    <div class="class-box">\
                                        <div class="div">\
                                            <div><strong>Course: </strong>'+res.data[i].course_name+'</div>\
                                            <div><strong>Class: </strong>'+res.data[i].s_class_name+' <strong>Div: </strong> '+res.data[i].div_name+'</div>\
                                            <div><strong>Dept: </strong>'+res.data[i].dept_name+'</div>\
                                        </div>\
                                    </div>'
                        }
                        $("#show_class").html(html);
                        break;
                }
            },
            error : function(err){
                console.log(err);
            }
        })
    })
}


// function processTheoryAttendance(){
//     $("#check-attend-theory").on("change",".sheet-input-field-theory" ,function(){
//         var date = $("#date-theory");
//         var time = $("#time-theory");
//         var class_id = $("#class_id");
//         console.log(class_id);
//         if(date.val() != "" && time.val() != ""){
//             $.ajax({
//                 url : "../controller/ajaxController.php?action=check_theory_attend",
//                 type : "POST",
//                 data : {"class_id" : class_id.val(), "date" : date.val(), "time" : time.val()},
//                 dataType : "json",
//                 success : function(res){
//                     console.log(res);
//                     switch(res.error){
//                         case "empty":
//                             alert("Please fill all details.");
//                             break;
//                         case "notfound":
//                             break;
//                         case "none":
//                             if(!confirm("Already Attendance Take Do you want to edit!")){
//                                 break;
//                             }else{
//                                 var html = "";
//                                 for(var i = 0; i < res.data.length; i++){
//                                     if(res.data[i].status == 0){
//                                         html += '<div class="grid-item m-2 mark-attend">\
//                                                 <input type="hidden" name="attend['+res.data[i].prn_no+']" value="0" data-id="'+res.data[i].prn_no+'"/>\
//                                                 <p class="mt-2">'+res.data[i].roll_no+'</p>\
//                                                 <button type="button" class="btn btn-danger rounded-0 marker">A</button>\
//                                             </div>'
//                                     }else{
//                                         html += '<div class="grid-item m-2 mark-attend">\
//                                                 <input type="hidden" name="attend['+res.data[i].prn_no+']" value="1" data-id="'+res.data[i].prn_no+'"/>\
//                                                 <p class="mt-2">'+res.data[i].roll_no+'</p>\
//                                                 <button type="button" class="btn btn-success rounded-0 marker">P</button>\
//                                             </div>'
//                                     } 
//                                 }
//                                 $("#pract-attend-list").html(" ");
//                                 $("#pract-attend-list").html(html);
//                             }
//                             break;
//                     }
//                 }
//             });
//         }
//     })
// }

function processResetDate(){
    $("#reset").on("click", function(){
        $("input[type=date]").val(new Date());
    })
}
