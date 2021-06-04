$(document).ready(function(){
    $('#student-table').DataTable();
    $('#class-table').DataTable();
    $('#course-table').DataTable();
    $('#staff-table').DataTable();
    $('#pract-class-table').DataTable();
    processOnChangeClass();
    processAddStudent();
    inputStudentPlaceholder();
    processEditStudent();
    processDeleteStudent()
    processAddStaff();
    inputStaffPlaceholder();
    processEditStaff();
    processDeleteStaff();
    processAddClass();
    processDeleteClass();
    processAddBulkStudent();
    processAddCourse();
    inputCoursePlaceholder();
    processEditCourse();
    processDeleteCourse();
    processAddPractClass()
    processHodReport();
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
                    case "duplicateRoll":
                        alert("Duplicate Rollno Found! Please Check File again");
                        break;
                    case "duplicatePrn":
                        alert("Duplicate PRN Found! Please Check File again");
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
                                <td class="faculty-id">'+res.data[i].faculty_id+'</td>\
                                <td class="faculty-name">'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#editStaffModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                    <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].faculty_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                </td>\
                            </tr>'
                            }
                            $.when($('#staff-table tbody').html(html)).then(alert("Staff successfully Added..."));
                        }
                        
                        break;     
                }
            }
        })
    })
}

function inputStaffPlaceholder(){
    $("#staff-table").on("click", "#edit-btn",function(e){
        var faculty_id = $(this).closest("tr").find('.faculty-id').text();
        var fname = $(this).closest("tr").find(".faculty-name").text().split(" ")[1];
        var lname = $(this).closest("tr").find(".faculty-name").text().split(" ")[0];
        $("#edit-faculty-id").val(faculty_id);
        $("#edit-fname").val(fname);
        $("#edit-lname").val(lname);
    });
}

function processEditStaff(){
    $("#edit-staff-form").on("submit", function(e){
        e.preventDefault();
        var data = {};
        $.when(
            $("#edit-staff-form input").each(function(k,v){
                data[$(v).attr("name")] = $(v).val();
            })
        ).then(() => {
            console.log(data);
            $('#editStaffModal #add-staff').trigger("reset");
            $('#editStaffModal').modal('hide');
            $.ajax({
            url : '../controller/ajaxController.php?action=editStaff',
            type : 'post',
            data : data,
            dataType : 'json',
            success : function(res) {
                console.log(res);
                switch(res.error){
                    case "empty":
                        alert("Please Fill all the fields");
                        break;
                    case "notexists":
                        alert("Staff not found");
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
                                <td class="faculty-id">'+res.data[i].faculty_id+'</td>\
                                <td class="faculty-name">'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#editStaffModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                    <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].faculty_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                </td>\
                            </tr>'
                            }
                            $.when($('#staff-table tbody').html(html)).then(alert("Staff successfully edited..."));
                            
                        }
                        break;     
                    }
                }
            })
        })
    })
}

function processDeleteStaff(){
    $('#staff-table').on("click","#del-btn",function(){
        if(confirm("Are you sure you want to delete ?")){
            var id;
            id = $(this).attr("data-control");
            console.log(id);
            var data = {};
            data['id'] = id;
            console.log(data);
            $.ajax({
                url : "../controller/ajaxController.php?action=delStaff",
                type : "post",
                data : data,
                dataType : 'json',
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            alert("Please Fill all the fields");
                            break;
                        case "notdelete":
                            alert("Data Not Deleted");
                            break;
                        case "none":
                            console.log(res.data.length);
                            if(res.data.length < 1) {
                                $('#staff-table tbody').html("<tr><td colspan='4'>Nothing Found</td></tr>");
                            }else{
                                var html = " ";
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<tr>\
                                    <td class="faculty-id">'+res.data[i].faculty_id+'</td>\
                                    <td class="faculty-name">'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                    <td>\
                                        <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#editStaffModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                        <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].faculty_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                    </td>\
                                </tr>'
                                }
                                $.when($('#staff-table tbody').html(html)).then(alert("Staff successfully Deleted..."));
                                
                            }
                            break;     
                    }
                }
            })
        }
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
            $('#manageClassModal #add-class').trigger("reset");
            $('#manageClassModal').modal('hide');
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
                                $.when(
                                    $('#class-table tbody').html(html)
                                ).then(
                                    alert("Class Added!")
                                ) 
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
                $('#addClassModal #add-staff').trigger("reset");
                $('#addClassModal').modal('hide');
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
                                    alert("Class Deleted!");
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
                                <td class="course-id">'+res.data[i].course_id+'</td>\
                                <td class="course-name">'+res.data[i].course_name+'</td>\
                                <td class="s-class-name" id="'+res.data[i].s_class_id+'">'+res.data[i].s_class_name+'</td>\
                                <td class="sem-name" id="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].course_id+'" data-toggle="modal" data-target="#courseEditModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                    <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].course_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
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

function inputCoursePlaceholder(){
    $("#course-table").on("click","#edit-btn",function(){
        var course_id = $(this).closest("tr").find('.course-id').text();
        var course_name = $(this).closest("tr").find('.course-name').text();
        var s_class_name = $(this).closest("tr").find('.s-class-name').attr("id");
        var sem_name = $(this).closest("tr").find('.sem-name').attr("id");
        $("#courseEditModal .c-id").val(course_id);
        $("#courseEditModal .c-name").val(course_name);
        $("#courseEditModal .c-y").val(s_class_name);
        $.ajax({
            url : "../controller/ajaxController.php?action=getSem",
            type : "post",
            data : {data : s_class_name},
            dataType : "json",
            success : function(res){
                console.log(res);
                if(res.data.length > 0){
                    $(".s-sem").prop("disabled",false);
                    var html = "";
                    for(var i = 0; i < res.data.length; i++){
                        html += '<option value="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</option>';
                    }
                    $('.s-sem').html(html);
                }
            }
        })
        $("#courseEditModal .s-sem").val(sem_name);
    })
}

function processEditCourse(){
    $('#edit-course').on("submit",function(e){
    e.preventDefault();
    var data = {};
        $.when(
            data[$("#edit-course .c-id").attr("name")] = $("#edit-course input[name=edit_course_id]").val(),
            data[$("#edit-course .c-name").attr("name")] = $("#edit-course input[name=edit_course_name]").val(),
            data[$("#edit-course .c-y").attr("name")] = $("#edit-course select[name=edit_course_class]").val(),
            data[$("#edit-course .s-sem").attr("name")] = $("#edit-course select[name=edit_course_sem]").val(),
            $('#courseEditModal #edit-course').trigger("reset"),
            $('#courseEditModal').modal('hide'),
        ).then(
            console.log(data),
            $.ajax({
                url : '../controller/ajaxController.php?action=editCourse',
                type : 'post',
                data : data,
                dataType : 'json',
                success : function(res) {
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            alert("Please Fill all the fields");
                            break;
                        case "notexists":
                            alert("Course Not Exists");
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
                                    <td class="course-id">'+res.data[i].course_id+'</td>\
                                    <td class="course-name">'+res.data[i].course_name+'</td>\
                                    <td class="s-class-name" id="'+res.data[i].s_class_id+'">'+res.data[i].s_class_name+'</td>\
                                    <td class="sem-name" id="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</td>\
                                    <td>\
                                        <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].course_id+'" data-toggle="modal" data-target="#courseEditModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                        <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].course_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                    </td>\
                                </tr>'
                                }
                                $.when(
                                    $('#course-table tbody').html(html)
                                ).then(
                                    alert("Courses successfully edited...")
                                )
                                
                                
                            }
                            break;     
                    }
                },
                error : function(err){
                    console.log(err);
                }
            })
        )    
    })
}

function processDeleteCourse(){
    $('#course-table').on("click","#del-btn",function(){
        if(confirm("Are you sure you want to delete ?")){
            var id;
            id = $(this).attr("data-control");
            console.log(id);
            var data = {};
            data['id'] = id;
            console.log(data);
            $.ajax({
                url : "../controller/ajaxController.php?action=delCourse",
                type : "post",
                data : data,
                dataType : 'json',
                success : function(res) {
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            alert("Please Fill all the fields");
                            break;
                        case "notexists":
                            alert("Course Not Exists");
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
                                    <td class="course-id">'+res.data[i].course_id+'</td>\
                                    <td class="course-name">'+res.data[i].course_name+'</td>\
                                    <td class="s-class-name" id="'+res.data[i].s_class_id+'">'+res.data[i].s_class_name+'</td>\
                                    <td class="sem-name" id="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</td>\
                                    <td>\
                                        <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].course_id+'" data-toggle="modal" data-target="#courseEditModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                        <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].course_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                    </td>\
                                </tr>'
                                }
                                $.when($('#course-table tbody').html(html)).then(alert("Course successfully Deleted..."))
                            }
                            break;     
                    }
                },
                error : function(err){
                    console.log(err);
                }
            })
        }
    })
}

function processAddPractClass(){
    $("#add-pract-class").on("submit", function(e){
        e.preventDefault();
        var data = {};
        $.when(
            data[$("#add-pract-class #acd_year").attr("name")] = $("#add-pract-class #acd_year").val(),
            data[$("#add-pract-class #faculty_s").attr("name")] = $("#add-pract-class #faculty_s").val(),
            data[$("#add-pract-class #courses_s").attr("name")] = $("#add-pract-class #courses_s").val(),
            data[$("#add-pract-class #div_s").attr("name")] = $('#add-pract-class #div_s').val(),
            data[$("#add-pract-class #batch_s").attr("name")] = $('#add-pract-class #batch_s').val(),
        ).then(() => {
            console.log(data);
            $('#managePractClassModal #add-class').trigger("reset");
            $('#managePractClassModal').modal('hide');
            $.ajax({
                url : "../controller/ajaxController.php?action=add_pract_class",
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
                            alert("Practical already Exists");
                            break;
                        case "notinsert":
                            alert("Data Not Inserted");
                            break;
                        case "none":
                            var html = "";
                            console.log(res.data.length);
                            if(res.data.length < 1) {
                                $('#pract-class-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                            }else{
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<tr>\
                                    <td>'+res.data[i].class_id+'</td>\
                                    <td>'+res.data[i].course_name+'</td>\
                                    <td>'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                    <td>'+res.data[i].s_class_name+'</td>\
                                    <td>'+res.data[i].batch_name+'</td>\
                                    <td>\
                                        <button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].class_id+'">Delete</button>\
                                    </td>\
                                </tr>'
                                }
                                $.when(
                                    $('#pract-class-table tbody').html(html)
                                ).then(
                                    alert("Class Added!")
                                ) 
                            }
                            break;  
                    }   
                }
            })
        })   
    })
}


function processHodReport(){
    $(document).on("change", "#select-year", function(e){
        if($("#select-acd").val() != " " && $(this).val() != " "){
            var year = $(this).val();
            var acd = $("#select-acd option:selected").val();
            $.ajax({
                url : "../controller/ajaxController.php?action=get_hod_class",
                type : "POST",
                data : {'year' : year, 'acd' : acd},
                dataType : "JSON",
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "notexist": 
                            // $("#select-class").val(" ");
                            $("#select-class").prop("disabled",true);
                            alert("No class found!");
                            break;
                        case "none":
                            if(res.data.length > 0){
                                $("#select-class").prop("disabled",false);
                                var html = '<option> </option>';
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
            if($(this).val() != " " && $("#select-acd option:selected").val() == " "){
                alert("Please Select Academic Year");
            }
        }
    })

    $("#get-report").on("click", function(){
        var data = {};
        var title = "";
        $.when(
            data[$("#report #select-acd").attr("name")] = $("#report #select-acd").val(),
            data[$("#report #select-year").attr("name")] = $("#report #select-year").val(),
            data[$("#report #select-class").attr("name")] = $("#report #select-class").val(),
            data[$("#report #from-date").attr("name")] = $("#report #from-date").val(),
            data[$("#report #till-date").attr("name")] = $("#report #till-date").val(),
            title = $("#report #select-class option:selected").text(),
            academic_year = $("#report #select-acd option:selected").text(),
        ).then(
            getAjaxReport()
        );
        function getAjaxReport(){
            $.ajax({
                url : "../controller/ajaxController.php?action=hod_report",
                type : "post",
                data : data,
                dataType : "JSON",
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            if($.fn.dataTable.isDataTable("#hod-report")){
                                $("#hod-report").DataTable().destroy();
                                $("#hod-report thead tr").html(" ");
                                $("#hod-report tbody").html(" ");
                            }
                            alert("Enter all Details...");
                            break;
                        case "notexists":
                            if($.fn.dataTable.isDataTable("#hod-report")){
                                $("#hod-report").DataTable().destroy();
                                $("#hod-report thead tr").html(" ");
                                $("#hod-report tbody").html(" ");
                            }
                            alert("NO attendance Found")
                            break;
                        case "date":
                            alert("Please Enter Correct Date");
                            break;
                        case "none":
                            if($.fn.dataTable.isDataTable("#hod-report")){
                                $("#hod-report").DataTable().destroy();
                                $("#hod-report thead tr").html(" ");
                                $("#hod-report tbody").html(" ");
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
                            $("#hod-report thead tr").html(th);
                            $("#hod-report tbody").html(td);
                            
                            var table = $("#hod-report").DataTable(
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
                                            title : title,
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