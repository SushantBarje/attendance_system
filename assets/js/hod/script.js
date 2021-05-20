$(document).ready(function(){
    $('#student-table').DataTable();
    $('#class-table').DataTable();
    processOnChangeClass();
    processAddStudent();
    inputStudentPlaceholder();
    processEditStudent();
    processDeleteStudent()
    processAddStaff();
    processAddClass();
    processDeleteClass();
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
                                html += '<tr role="row" class="odd">\
                                            <td class="edit-prn">'+res.data[i].prn_no+'</td>\
                                            <td class="edit-name">'+res.data[i].last_name+' '+res.data[i].first_name+' '+res.data[i].middle_name+'</td>\
                                            <td class="edit-roll">'+res.data[i].roll_no+'</td>\
                                            <td class="edit-year" id="'+res.data[i].year_id+'">'+res.data[i].s_class_name+'</td>\
                                            <td class="edit-dept" id="'+res.data[i].dept_id+'">'+res.data[i].dept_name+'</td>\
                                            <td class="edit-div" id="'+res.data[i].div_id+'">'+res.data[i].div_name+'</td>\
                                            <td class="edit-batch" id="'+res.data[i].batch_id+'">'+res.data[i].batch_name+'</td>\
                                            <td>\
                                                <button type="button" class="btn btn-primary btn-sm" id="edit-btn" data-control="'+res.data[i].prn_no+'" data-toggle="modal" data-target="#editStudentModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                                <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].prn_no+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
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

function inputStudentPlaceholder(){
    $("#student-table").on("click","#edit-btn", function(){
        var prn = $(this).closest("tr").find(".edit-prn").text();
        var lname = $(this).closest("tr").find(".edit-name").text().split(" ")[0];
        var mname = $(this).closest("tr").find(".edit-name").text().split(" ")[1];
        var fname = $(this).closest("tr").find(".edit-name").text().split(" ")[2];
        var roll = $(this).closest("tr").find(".edit-roll").text();
        var dept = $(this).closest("tr").find(".edit-dept").attr("id");
        var year = $(this).closest("tr").find(".edit-year").attr("id");
        var div = $(this).closest("tr").find(".edit-div").attr("id");
        var batch = $(this).closest("tr").find(".edit-batch").attr("id");
        $("#prn-no").val(prn);
        $("#fname").val(fname);
        $("#mname").val(mname);
        $("#lname").val(lname);
        $("#roll").val(roll);
        $("#year").val(year);
        $("#dept").val(dept); 
    });
}

function processEditStudent(){
    $("#edit-student").on("submit",function(e){
        e.preventDefault();
        var data = {};
        $.when(
            $("#edit-student input").each(function(k,v){
                data[$(v).attr("name")] = $(v).val();
            }),
            $("#edit-student select").each(function(k,v){
                data[$(v).attr("name")] = $(v).val();
            })
        ).then(() => {
            console.log(data);
            $('#editStudentModal #add-hod').trigger("reset");
            $('#editStudentModal').modal('hide');
            $.ajax({
                url : '../controller/ajaxController.php?action=editStudent',
                type : 'post',
                data : data,
                dataType : 'json',
                "dataSrc" : "dataTable",
                success : function(res){    
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            alert("Please Fill all the fields");
                            break;
                        case "exists":
                            alert("Student already Exists");
                            break;
                        case "notinsert":
                            alert("Data Not Inserted");
                            break;
                        case "none":
                            var html = "";
                            console.log(res.data.length);
                            if(res.data.length < 1) {
                                $('#student-table tbody').html('<tr role="row" class="odd"><td colspan="2">Nothing Found</td></tr>');
                            }else{
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<tr role="row" class="odd">\
                                            <td class="edit-prn">'+res.data[i].prn_no+'</td>\
                                            <td class="edit-name">'+res.data[i].last_name+' '+res.data[i].first_name+' '+res.data[i].middle_name+'</td>\
                                            <td class="edit-roll">'+res.data[i].roll_no+'</td>\
                                            <td class="edit-year" id="'+res.data[i].year_id+'">'+res.data[i].s_class_name+'</td>\
                                            <td class="edit-dept" id="'+res.data[i].dept_id+'">'+res.data[i].dept_name+'</td>\
                                            <td class="edit-div" id="'+res.data[i].div_id+'">'+res.data[i].div_name+'</td>\
                                            <td class="edit-batch" id="'+res.data[i].batch_id+'">'+res.data[i].batch_name+'</td>\
                                            <td>\
                                                <button type="button" class="btn btn-primary btn-sm" id="edit-btn" data-control="'+res.data[i].prn_no+'" data-toggle="modal" data-target="#editStudentModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                                <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].prn_no+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                            </td>\
                                        </tr>';
                                }
                                $("#student-table").DataTable({ destroy : true });
                                $('#student-table tbody').html(html);
                                $("#student-table").DataTable();
                                
                        }     
                    }
                },
            })
        })
    })
}

function processDeleteStudent(){
    $('#student-table').on("click","#del-btn",function(){
        if(confirm("Are you sure you want to delete ?")){
            var data = {};
            $.when(
                data['id'] = $(this).attr("data-control")
            ).then(() => {
                console.log(data);
                $.ajax({
                    url : "../controller/ajaxController.php?action=delStudent",
                    type : "post",
                    data : data,
                    dataType : 'json',
                    success : function(res){
                        console.log(res);
                        switch(res.error){
                            case "empty":
                                alert("Please Fill all the fields");
                                break;
                            case "notexist":
                                alert("Data Not Deleted");
                                break;
                            case "none":
                                console.log(res.data.length);
                                if(res.data.length < 1) {
                                    $('#student-table tbody').html("<tr><td colspan='4'>Nothing Found</td></tr>");
                                }else{
                                    var html = " ";
                                    for(var i = 0; i < res.data.length; i++){
                                        html += '<tr role="row" class="odd">\
                                        <td class="edit-prn">'+res.data[i].prn_no+'</td>\
                                        <td class="edit-name">'+res.data[i].last_name+' '+res.data[i].first_name+' '+res.data[i].middle_name+'</td>\
                                        <td class="edit-roll">'+res.data[i].roll_no+'</td>\
                                        <td class="edit-year" id="'+res.data[i].year_id+'">'+res.data[i].s_class_name+'</td>\
                                        <td class="edit-dept" id="'+res.data[i].dept_id+'">'+res.data[i].dept_name+'</td>\
                                        <td class="edit-div" id="'+res.data[i].div_id+'">'+res.data[i].div_name+'</td>\
                                        <td class="edit-batch" id="'+res.data[i].batch_id+'">'+res.data[i].batch_name+'</td>\
                                        <td>\
                                            <button type="button" class="btn btn-primary btn-sm" id="edit-btn" data-control="'+res.data[i].prn_no+'" data-toggle="modal" data-target="#editStudentModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                            <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].prn_no+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
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
                                    <button type="button" class="btn btn-success" id="view-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#viewModal">Edit</button>\
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


function processAddClass(){
    $("#add-class").on("submit", function(e){
        e.preventDefault();
        var data = {};
        $.when(
            data[$("#add-class #acd_year").attr("name")] = $("#add-class #acd_year").val(),
            data[$("#add-class #faculty_s").attr("name")] = $("#add-class #faculty_s").val(),
            data[$("#add-class #courses_s").attr("name")] = $("#courses_s").val(),
        ).then(() => {
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
                                $('#class-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                            }else{
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<tr>\
                                    <td>'+res.data[i].class_id+'</td>\
                                    <td>'+res.data[i].course_name+'</td>\
                                    <td>'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                    <td>'+res.data[i].s_class_name+'</td>\
                                    <td>\
                                        <button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].class_id+'">Delete</button>\
                                    </td>\
                                </tr>'
                                }
                                $('#class-table tbody').html(html);
                            }
                            break;  
                    }   
                }
            })
        })   
    })
}


function processDeleteClass(){
    $('#class-table').on("click","#del-btn",function(){
        if(confirm("Are you sure you want to delete ?")){
            var data = {};
            $.when(
                data['id'] = $(this).attr("data-control")
            ).then(() => {
                console.log(data);
                $.ajax({
                    url : "../controller/ajaxController.php?action=delClass",
                    type : "post",
                    data : data,
                    dataType : 'json',
                    success : function(res){
                        console.log(res);
                        switch(res.error){
                            case "empty":
                                alert("Please Fill all the fields");
                                break;
                            case "notexist":
                                alert("Data Not Deleted");
                                break;
                            case "none":
                                console.log(res.data.length);
                                if(res.data.length < 1) {
                                    $('#class-table tbody').html("<tr><td colspan='4'>Nothing Found</td></tr>");
                                }else{
                                    var html = " ";
                                    for(var i = 0; i < res.data.length; i++){
                                        html += '<tr>\
                                                    <td>'+res.data[i].class_id+'</td>\
                                                    <td>'+res.data[i].course_name+'</td>\
                                                    <td>'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                                    <td>'+res.data[i].s_class_name+'</td>\
                                                    <td>\
                                                        <button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].class_id+'">Delete</button>\
                                                    </td>\
                                                </tr>'
                                    }
                                    $('#class-table tbody').html(html);
                                }
                                
                                break;     
                        }
                    }
                })
            })  
        }
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
                            alert("Course Added!");
                        }
                        
                        break;     
                }
            }
        })
    })
}