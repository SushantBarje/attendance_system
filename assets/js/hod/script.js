$(document).ready(function(){
    processOnChangeClass();
    processAddStudent();
    processAddStaff();
    addClass();
    processAddBulkStudent();
    processAddCourse();
});

function processOnChangeClass(){
    $("#class_year").on("change",function(){
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
                    for(var i = 0; i < res.data.length; i++){
                        html += '<option value="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</option>';
                    }
                    $('#s_sem').html(html);
                }
            }
        })
    });
}

function processAddStudent(){
    $('#add-student').on("submit",function(e){
        e.preventDefault();
        var data = {};
        $('#add-student input').each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        });
        $('#add-student select').each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        });
        console.log(data);
        $('#addModal #add-hod').trigger("reset");
        $('#addModal').modal('hide');
        $.ajax({
            url : '../controller/ajaxController.php?action=addStudent',
            type : 'post',
            data : data,
            dataType : 'json',
            success : function(res) {
                console.log(res);
                switch(res.error){
                    case "empty":
                        alert("Please Fill all the fields");
                        break;
                    case "exists":
                        alert("HOD already Exists");
                        break;
                    case "notinsert":
                        alert("Data Not Inserted");
                        break;
                    case "none":
                        var html = "";
                        console.log(res.data.length);
                        if(res.data.length < 1) {
                            $('#student-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                        }else{
                            for(var i = 0; i < res.data.length; i++){
                                html += '<tr>\
                                            <td>'+res.data[i].prn_no+'</td>\
                                            <td>'+res.data[i].last_name+' '+res.data[i].first_name+' '+res.data[i].middle_name+'</td>\
                                            <td>'+res.data[i].roll_no+'</td>\
                                            <td>'+res.data[i].s_class_name+'</td>\
                                            <td>'+res.data[i].dept_name+'</td>\
                                            <td>'+res.data[i].div_name+'</td>\
                                            <td>'+res.data[i].batch_name+'</td>\
                                            <td>\
                                                <button type="button" class="btn btn-primary" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button>\
                                                <button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button>\
                                            </td>\
                                        </tr>';
                            }
                            $('#student-table tbody').html(html);
                        }
                        
                        break;     
                }
            }
        })
    })
}

function processAddStaff(){
    $('#add-staff').on("submit",function(e){
        e.preventDefault();
        var data = {};
        $('#add-staff input').each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        })
        //data[$('#add-staff select').attr('name')] = $('#add-staff select').val();
        console.log(data);
        $('#addStaffModal #add-staff').trigger("reset");
        $('#addStaffModal').modal('hide');
        $.ajax({
            url : '../controller/ajaxController.php?action=addStaff',
            type : 'post',
            data : data,
            dataType : 'json',
            success : function(res) {
                console.log(res);
                switch(res.error){
                    case "empty":
                        alert("Please Fill all the fields");
                        break;
                    case "exists":
                        alert("HOD already Exists");
                        break;
                    case "notinsert":
                        alert("Data Not Inserted");
                        break;
                    case "none":
                        var html = "";
                        console.log(res.data.length);
                        if(res.data.length < 1) {
                            $('#staff-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                        }else{
                            for(var i = 0; i < res.data.length; i++){
                                html += '<tr>\
                                <td>'+res.data[i].faculty_id+'</td>\
                                <td>'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                <td>'+res.data[i].dept_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success" id="view-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#viewModal">View Details</button>\
                                    <button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].faculty_id+'">Delete</button>\
                                </td>\
                            </tr>'
                            }
                            $('#staff-table tbody').html(html);
                        }
                        
                        break;     
                }
            }
        })
    })
}


function addClass(){
    $("#add-class").on("submit", function(e){
        e.preventDefault();
        var data = {};
        data[$("#add-class #faculty_s").attr("name")] = $("#add-class #faculty_s").val();
        data[$("#add-class #courses_s").attr("name")] = $("#courses_s").val();
        console.log(data);
        $.ajax({
            url : "../controller/ajaxController.php?action=addClass",
            type : "post",
            data : data,
            dataType : 'json',
            success : function(res){
                console.log(res);
                switch(res.error){
                    case "empty":
                        alert("Please Fill all the fields");
                        break;
                    case "exists":
                        alert("HOD already Exists");
                        break;
                    case "notinsert":
                        alert("Data Not Inserted");
                        break;
                    case "none":
                        var html = "";
                        console.log(res.data.length);
                        if(res.data.length < 1) {
                            $('#staff-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                        }else{
                            for(var i = 0; i < res.data.length; i++){
                                html += '<tr>\
                                <td>'+res.data[i].faculty_id+'</td>\
                                <td>'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                <td>'+res.data[i].dept_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success" id="view-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#viewModal">View Details</button>\
                                    <button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].faculty_id+'">Delete</button>\
                                </td>\
                            </tr>'
                            }
                            $('#staff-table tbody').html(html);
                        }
                        
                        break;  
                }   
            }
        })
    })
}

function processAddBulkStudent(){
    var data = {};
    $("#add-bulk-student").on("submit",function(){
        data[$("#add-bulk-student select").attr("name")] = $("#add-bulk-student select").val();
        data[$("#add-bulk-student input").attr("name")] = $("#add-bulk-student input").val();
        console.log(data);
        $.ajax({
            url : "../controller/ajaxController.php?action=add_bulk_student",
            type : "post",
            data : data,
            dataType : 'json',
            contentType: false,
            cache: false,
            processData:false,
            success : function(res){
                console.log(res);
            }
        });
    });
}

function processAddCourse(){
    $('#add-course').on("submit",function(e){
        e.preventDefault();
        var data = {};
        $('#add-course input').each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        })
        $("#add-course select").each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        })
        console.log(data);
        $('#courseAddModal #add-course').trigger("reset");
        $('#courseAddModal').modal('hide');
        $.ajax({
            url : '../controller/ajaxController.php?action=addCourseDept',
            type : 'post',
            data : data,
            dataType : 'json',
            success : function(res) {
                console.log(res);
                switch(res.error){
                    case "empty":
                        alert("Please Fill all the fields");
                        break;
                    case "exists":
                        alert("HOD already Exists");
                        break;
                    case "notinsert":
                        alert("Data Not Inserted");
                        break;
                    case "none":
                        var html = "";
                        console.log(res.data.length);
                        if(res.data.length < 1) {
                            $('#course-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                        }else{
                            for(var i = 0; i < res.data.length; i++){
                                html += '<tr>\
                                <td>'+res.data[i].course_id+'</td>\
                                <td>'+res.data[i].course_name+'</td>\
                                <td>'+res.data[i].dept_name+'</td>\
                                <td>'+res.data[i].s_class_name+'</td>\
                                <td>'+res.data[i].sem_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success" id="view-btn" data-control="'+res.data[i].course_id+'" data-toggle="modal" data-target="#viewModal">View Details</button>\
                                    <button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].course_id+'">Delete</button>\
                                </td>\
                            </tr>'
                            }
                            $('#course-table tbody').html(html);
                        }
                        
                        break;     
                }
            }
        })
    })
}