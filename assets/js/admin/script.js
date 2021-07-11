
$(document).ready(function(){
    $("#acad-table").DataTable();
    $("#dept-table").DataTable();
    $("#course-table").DataTable();
    $("#hod-table").DataTable();
    processAddAcademicYear();
    processDeleteAcademicYear()
    processAddDepartment();
    processDeleteDepartment();
    processAddHod();
    processDeleteHod();
    processEditHod();
    processOnChangeClass()
    processAddCourse();
    processEditCourse();
    processDeleteCourse();
    inputCoursePlaceholder();
    inputHodPlaceholder();
    processReport();
    processAjaxClass();
    processAdminReport();
    processAjaxYear()
    processPracticalReport()
    //processAdminAdvReport()
});

function processAddAcademicYear(){
    $("#academic-form").on("submit", function(e){
        var data = {};
        $('#academic-form input').each(function(k,v){
            data[$(v).attr('name')] = $(v).val();
        });
        console.log(data);
        $.ajax({
            url: '../controller/ajaxController.php?action=addAcademicYear',
            type: 'post',
            data : data,
            dataType: 'json',
            success: function(res){
                console.log(res);
                switch(res.error){
                    case "empty":
                        alert("Please Fill all the fields");
                        break;
                    case "notinsert":
                        alert("Data Not Inserted");
                        break;
                    case "none":
                        var html = "";
                        for(var i = 0; i < res.data.length; i++){
                            html += '<tr><td>'+res.data[i].academic_descr+'</td><td><button class="btn btn-danger">Delete</button></td></tr>';
                        }
                        $('#addAcdModal').modal('hide');
                        $('#acad-table body').append(html);     
                }
            }
        });
    });
}

function processDeleteAcademicYear(){
    $('#acad-table').on("click", "#del-btn",function(){
        if(confirm("Are you sure you want to delete ?")){
            var id;
            id = $(this).attr("data-control");
            console.log(id);
            var data = {};
            data['id'] = id;
            console.log(data);
            $.ajax({
                url : "../controller/ajaxController.php?action=delAcademicYear",
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
                            alert("Data Not Inserted");
                            break;
                        case "none":
                            var html = "";
                            if(res.data.length == 0) {
                                $('#acad-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                            }else{
                                var html = "";
                                console.log(res.data.length);
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<tr><td>'+res.data[i].academic_descr+'</td><td><button class="btn btn-danger">Delete</button></td></tr>';
                                }
    
                                $('#acad-table tbody').html(html); 
                            }
                            break;  
                    }
                }
            })
        }
    })
}


function processAddDepartment() {
    $('#dpt-form').submit(function(e){
        e.preventDefault();
        var data = {};
        
            data[$('#dpt-form #dptname').attr('name')] = $('#dpt-form #dptname').val();
            data[$('#dpt-form #year_s').attr('name')] = $('#dpt-form #year_s').val();
            data[$('#dpt-form #div_s').attr('name')] = $('#dpt-form #div_s').val();  
            console.log(jQuery.isEmptyObject(data));
            $('#myModal').modal('hide');
            $.ajax({
                url : '../controller/ajaxController.php?action=addDept',
                type : 'POST',
                data : data,
                dataType : 'json',
                success : function(res) {
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            alert("Please Fill all the fields");
                            break;
                        case "notinsert":
                            alert("Data Not Inserted");
                            break;
                        case "none":
                            var html = "";
                            for(var i = 0; i < res.data.length; i++){
                                html += '<tr>\
                                            <td class="dept-name">'+res.data[i].dept_name+'</td>\
                                            <td>'+res.data[i].s_class_name+'</td>\
                                            <td>'+res.data[i].div_name+'</td>\
                                            <td><button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td>\
                                        </tr>';
                            }
                            $('#dept-table tbody').html(html)
                            
                    }
                }
            })
    
    })
}

// function inputDeptPlaceholder(){
//     $("#dept-table").on("click","#edit-btn",function(){
//         var c = $(this).closest("tr").find('.dept-name').text();
//         $("#editModal input").val(c);
//     })
// }

// function processEditDepartment(){
//     var id;
//     $('#dept-table').on("click","#edit-btn", function(){
//         id = $(this).attr("data-control");
//         console.log(id);
//     });

//     $("#edit-dept").on("submit", function(){
//         var data = {};
//         $("#edit-dept input").each(function(){
//             data[$(this).attr('name')] = $(this).val();
//         });
//         data['dept_id'] = id;
//         console.log(data);
//         $('#editModal').modal('hide');
//         $.ajax({
//             url : "../controller/ajaxController.php?action=editDept",
//             type : "post",
//             data : data,
//             dataType : 'json',
//             success : function(res){
//                 console.log(res);
//                 switch(res.error){
//                     case "empty":
//                         alert("Please Fill all the fields");
//                         break;
//                     case "notedit":
//                         alert("Data Not Inserted");
//                         break;
//                     case "none":
//                         var html = "";
//                         for(var i = 0; i < res.data.length; i++){
//                             html += '<tr><td class="dept-name">'+res.data[i].dept_name+'</td><td><button type="button" class="btn btn-primary mr-1" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button><button type="button" class="btn btn-danger id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td></tr>';
//                         }
//                         $('#dept-table tbody').html(html);     
//                 }
//             }
//         });
//         return false;
//     });
// }

function processDeleteDepartment(){
    $('#dept-table').on("click", "#del-btn",function(){
        if(confirm("Are you sure you want to delete ?")){
            var id;
            id = $(this).attr("data-control");
            console.log(id);
            var data = {};
            data['id'] = id;
            console.log(data);
            $.ajax({
                url : "../controller/ajaxController.php?action=delDept",
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
                            alert("Data Not Inserted");
                            break;
                        case "none":
                            var html = "";
                            if(res.data.length < 1) {
                                $('#dept-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                            }else{
                                html = "";
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<tr>\
                                            <td class="dept-name">'+res.data[i].dept_name+'</td>\
                                            <td>'+res.data[i].s_class_name+'</td>\
                                            <td>'+res.data[i].div_name+'</td>\
                                            <td><button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td>\
                                        </tr>';
                                }
                                $('#dept-table tbody').html(html);
                            }
                            break;  
                    }
                }
            })
        }
    })
}

function processAddHod(){
    $('#add-hod').on("submit",function(e){
        e.preventDefault();
        var data = {};
        $('#add-hod input').each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        })
        data[$('#add-hod select').attr('name')] = $('#add-hod select').val();
        console.log(data);
        $('#myModal #add-hod').trigger("reset");
        $('#myModal').modal('hide');
        $.ajax({
            url : '../controller/ajaxController.php?action=addHod',
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
                            $('#hod-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                        }else{
                            for(var i = 0; i < res.data.length; i++){
                                html += '<tr>\
                                <td class="faculty-id">'+res.data[i].faculty_id+'</td>\
                                <td class="faculty-name">'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                <td class="dept-name" id="'+res.data[i].dept_id+'">'+res.data[i].dept_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#editHodModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                    <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].faculty_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                </td>\
                            </tr>'
                            }
                            $('#hod-table tbody').html(html);
                        }
                        break;     
                }
            }
        })
    })
}

function inputHodPlaceholder(){
    $("#hod-table").on("click", "#edit-btn",function(e){
        var faculty_id = $(this).closest("tr").find('.faculty-id').text();
        var fname = $(this).closest("tr").find(".faculty-name").text().split(" ")[1];
        var lname = $(this).closest("tr").find(".faculty-name").text().split(" ")[0];
        var dept_name = $(this).closest("tr").find(".dept-name").attr("id");
        $("#edit-faculty-id").val(faculty_id);
        $("#edit-fname").val(fname);
        $("#edit-lname").val(lname);
        $("#edit-dept").val(dept_name);
    });
}

function processEditHod(){
    $("#edit-hod-form").on("submit", function(e){
        e.preventDefault();
        var data = {};
        $.when(
            $("#edit-hod-form input").each(function(k,v){
                data[$(v).attr("name")] = $(v).val();
            }),
            data[$("#edit-hod-form select").attr("name")] = $("#edit-hod-form select").val()
        ).then(() => {
            console.log(data);
            $('#editHodModal #add-hod').trigger("reset");
            $('#editHodModal').modal('hide');
            $.ajax({
            url : '../controller/ajaxController.php?action=editHod',
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
                            $('#hod-table tbody').html("<tr><td colspan='2'>Nothing Found</td></tr>");
                        }else{
                            for(var i = 0; i < res.data.length; i++){
                                html += '<tr>\
                                <td class="faculty-id">'+res.data[i].faculty_id+'</td>\
                                <td class="faculty-name">'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                <td class="dept-name" id="'+res.data[i].dept_id+'">'+res.data[i].dept_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#editHodModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                    <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].faculty_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                </td>\
                            </tr>'
                            }
                            $('#hod-table tbody').html(html);
                        }
                        break;     
                    }
                }
            })
        })
    })
}


function processDeleteHod(){
    $('#hod-table').on("click","#del-btn",function(){
        if(confirm("Are you sure you want to delete ?")){
            var id;
            id = $(this).attr("data-control");
            console.log(id);
            var data = {};
            data['id'] = id;
            console.log(data);
            $.ajax({
                url : "../controller/ajaxController.php?action=delHod",
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
                                $('#hod-table tbody').html("<tr><td colspan='4'>Nothing Found</td></tr>");
                            }else{
                                var html = " ";
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<tr>\
                                        <td class="faculty-id">'+res.data[i].faculty_id+'</td>\
                                        <td class="faculty-name">'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                        <td class="dept-name" id="'+res.data[i].dept_id+'">'+res.data[i].dept_name+'</td>\
                                        <td>\
                                            <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#editHodModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                            <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].faculty_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                        </td>\
                                    </tr>'
                                }
                                $('#hod-table tbody').html(html);
                            }
                            
                            break;     
                    }
                }
            })
        }
    })
}

function processOnChangeClass(){
    $(".c-y").on("change",function(){
        OnChangeClass($(this).val(),".s-sem");
    });

    $("#select-year-report").on("change", function(e){
        e.preventDefault();
        OnChangeClass($(this).val(),"#select-sem-report");
    })

    function OnChangeClass(data, selector){
        var id = data;
        console.log(id);
        console.log(selector)
        if(id == " ") return $(selector).html('<option value="'+' '+'">Select Year</option>').prop("disabled",true);
        $.ajax({
            url : "../controller/ajaxController.php?action=getSem",
            type : "post",
            data : {data : id},
            dataType : "json",
            success : function(res){
                console.log(res);
                if(res.data.length > 0){
                    $(selector).prop("disabled",false);
                    var html = "";
                    for(var i = 0; i < res.data.length; i++){
                        html += '<option value="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</option>';
                    }
                    $(selector).html(html);
                }
            }
        })
    }
        
   
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
            url : '../controller/ajaxController.php?action=addCourse',
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
                        alert("Course already Exists");
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
                                <td class="dept-name" id="'+res.data[i].dept_id+'">'+res.data[i].dept_name+'</td>\
                                <td class="s-class-name" id="'+res.data[i].s_class_id+'">'+res.data[i].s_class_name+'</td>\
                                <td class="sem-name" id="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].course_id+'" data-toggle="modal" data-target="#courseEditModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                    <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].course_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
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


function inputCoursePlaceholder(){
    $("#course-table").on("click","#edit-btn",function(){
        var course_id = $(this).closest("tr").find('.course-id').text();
        var course_name = $(this).closest("tr").find('.course-name').text();
        var dept_name = $(this).closest("tr").find('.dept-name').attr("id");
        var s_class_name = $(this).closest("tr").find('.s-class-name').attr("id");
        var sem_name = $(this).closest("tr").find('.sem-name').attr("id");
        $("#courseEditModal .c-id").val(course_id);
        $("#courseEditModal .c-name").val(course_name);
        $("#courseEditModal #course-dept").val(dept_name);
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
            data[$("#edit-course .c-d").attr("name")] = $("#edit-course select[name=edit_course_dept]").val(),
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
                                    <td class="dept-name" id="'+res.data[i].dept_id+'">'+res.data[i].dept_name+'</td>\
                                    <td class="s-class-name" id="'+res.data[i].s_class_id+'">'+res.data[i].s_class_name+'</td>\
                                    <td class="sem-name" id="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</td>\
                                    <td>\
                                        <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].course_id+'" data-toggle="modal" data-target="#courseEditModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                        <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].course_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                    </td>\
                                </tr>'
                                }
                                $('#course-table tbody').html(html);
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
                                    <td class="dept-name" id="'+res.data[i].dept_id+'">'+res.data[i].dept_name+'</td>\
                                    <td class="s-class-name" id="'+res.data[i].s_class_id+'">'+res.data[i].s_class_name+'</td>\
                                    <td class="sem-name" id="'+res.data[i].sem_id+'">'+res.data[i].sem_name+'</td>\
                                    <td>\
                                        <button type="button" class="btn btn-success btn-sm" id="edit-btn" data-control="'+res.data[i].course_id+'" data-toggle="modal" data-target="#courseEditModal"><span> <i class="fas fa-edit"></i></span> Edit</button>\
                                        <button type="button" class="btn btn-danger btn-sm" id="del-btn" data-control="'+res.data[i].course_id+'"><span><i class="fas fa-trash-alt"></i></span> Delete</button>\
                                    </td>\
                                </tr>'
                                }
                                $('#course-table tbody').html(html);
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

function processReport(){
    
    $("#report").on("submit", function(){
        var data = {};
        $("#report select").each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        });

        $("#report input").each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        });
        console.log(jQuery.isEmptyObject(data));
        console.log(data.department);
    });
}


function processAjaxClass(){
    $("#course-dept").on("change", function(){
        var id = $(this).val();
        console.log(id);
        $("#s_sem").val(" ");
        $.ajax({
            url : "../controller/ajaxController.php?action=get_year_belong_dept",
            type: "post",
            data : {"id" : id},
            dataType : "json",
            success : function(res){
                switch(res.error){
                    case "empty":
                        alert("Please fill all details.");
                        break;
                    case "notfound":
                        var html = "<option value=' '>Not Found</option>";
                        $("#class_year").html(html);
                        $("#class_year").prop("disabled",true);
                        break;
                    case "none":
                        $("#class_year").prop("disabled",false);
                        var html = "";
                        html += '<option value=""> </option>'
                        for(var i = 0; i < res.data.length; i++){
                            html += '<option value="'+res.data[i].year_id+'">'+res.data[i].s_class_name+'</option>';
                        }
                        $("#class_year").html(html);
                        break;
                }
            },
            error : function(e){
                console.log(e);
            }
        })
    })
}



function processAdminReport(){
    $("#report").on("change", ".report-select-input-report", function(e){
        if($("#report #select-acd-report").val() != "" && $("#report #select-year-report").val() != "" && $("#report #select-div-report").val() != "" && $("#report #select-dept-report").val() != ""){
            var acd = $("#report #select-acd-report").val();
            var year = $("#report #select-year-report").val();
            var div = $("#report #select-div-report").val();
            var dept = $("#report #select-dept-report").val();
            var sem = $("#report #select-sem-report").val();
            console.log(acd,year,div,dept,sem);
            $.ajax({
                url : "../controller/ajaxController.php?action=get_class_div_wise",
                type : "POST",
                data : {"id" : div, "acd" : acd, "year" : year, "dept_id": dept, "sem" : sem},
                dataType : "JSON",
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            $("#select-class-report").prop("disabled", true);
                            $("#select-class-report").val(" ");
                            $("#select-class-report").text(" ");
                            alert("Please fill all details!");
                            break;
                        case "notfound":
                            $("#select-class-report").val(" ");
                            $("#report #select-class-report").text("No class found");
                            break;
                        case "none":
                            $("#select-class-report").prop("disabled", false);
                            $("#select-class-report").val(" ");
                            $("#select-class-report").text(" ");
                            if(res.data.length > 0){
                                $("#select-class-report").prop("disabled",false);
                                var html = '<option value=""> </option>';
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<option value="'+res.data[i].class_id+'" data-class="'+res.data[i].s_class_id+'">'+res.data[i].course_name+'</option>';
                                }
                                $('#select-class-report').html(html);
                            }
                            break;
                    }
                }
            })
        }else{
            if($("#select-acd-report option:selected").val() == " "){
                alert("Please Select Academic Year");
            }
        }
    })



    $("#report").on("click", "#get-report",function(){
        if($("#report #select-acd-report").val() != "" && $("#report #select-year-report").val() != "" && $("#report #select-div-report").val() != "" && $("#report #select-sem-report").val() != "" && $("#report #select-dept-report").val() != "" && $("#report #select-class-report").val() == ""){
            console.log("sushant");
            $.ajax({
                url : "../controller/ajaxController.php?action=perform_hod_report",
                type : "post",
                data : {"academic_year" : $("#report #select-acd-report").val(), "s_class_year" : $("#report #select-year-report").val(), "div_id" : $("#report #select-div-report").val(), "sem" : $("#report #select-sem-report").val(), "dept_id" : $("#report #select-dept-report").val()},
                dataType : 'json',
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "none":
                                if($.fn.dataTable.isDataTable("#admin-report-adv")){
                                    $("#admin-report-adv").DataTable().destroy();
                                    $("#admin-report-adv thead").html(" ");
                                    $("#admin-report-adv tbody").html(" ");
                                } 

                                if($.fn.dataTable.isDataTable("#admin-report")){
                                    $("#admin-report").DataTable().destroy();
                                    $("#admin-report thead").html(" ");
                                    $("#admin-report tbody").html(" ");
                                } 

                                var columns = Object.keys(res.data[0]);
                                var class_columns = columns.slice(3);
                                var numColClass = class_columns.length;
                                var table_header_1 = '<tr>\
                                                        <th colspan="2">Class :</th>\
                                                        <th colspan="'+numColClass+'">Intersaction Session</th>\
                                                        <th colspan="2">Total</th>\
                                                    </tr>';
                                var th_body =      '<tr>\
                                                        <th rowspan="2">Roll no.</th>\
                                                        <th>Name of Student</th>';
    
                                var th_1;
                                for(var i = 0; i < numColClass; i++){
                                    th_1 += '<th>'+class_columns[i]+'</th>'
                                }
                                var total_th = "<th>Total</th><th>%</th></tr>"
    
                                var total_header = "<tr><th>Total No. of Lectures</th>";
                                var columns = Object.values(res.lectures);
                                var numColTotal = class_columns.length;
                                var th_2;
                                var total_sum_lectures = 0;
                                for(var i = 0; i < numColTotal; i++){
                                    total_sum_lectures += parseInt(columns[i]);
                                    th_2 += '<th>'+columns[i]+'</th>' 
                                }
                                th_2 += '<th>'+total_sum_lectures+'</th>'
                                th_2 += "<th>-</th></tr>";
                                var tbody = "<tr>";
                                for(var i = 0; i < res.data.length; i++){
                                    tbody += '<td>'+res.data[i].roll_no+'</td>';
                                    tbody += '<td>'+res.data[i].student_name+'</td>';
                                    var sum = 0;
                                    for(var j = 0; j < numColClass; j++){
                                        if(res.data[i][class_columns[j]] != null){
                                            sum += parseInt(res.data[i][class_columns[j]]);
                                            tbody += '<td>'+res.data[i][class_columns[j]]+'</td>' 
                                        }else{
                                            tbody += '<td>-</td>'
                                        }
                                    }
                                    total_percent = (sum/total_sum_lectures)*100;
                                    tbody += '<td>'+sum+'</td>'
                                    tbody += '<td style="mso-number-format:"'+0.00+'%">'+total_percent.toFixed(2)+'%</td></tr>';
                                }
                                var concat_header = table_header_1+th_body+th_1+total_th+total_header+th_2;
                                
                                $("#admin-report-adv thead").html(concat_header);
                                $("#admin-report-adv tbody").html(tbody);
                                $("#admin-report-adv").DataTable(
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
                                    }
                                )
                                
                                // $("#hod-report-adv").tableExport({
                                //     headers: true, 
                                //     bootstrap : true,
                                //     exportButtons: true,                // (Boolean), automatically generate the built-in export buttons for each of the specified formats (default: true)
                                //     position: "bottom", 
                                // })
                                $("#export").on("click", function(){
                                    $("#admin-report-adv").table2excel({
                                        name: "Worksheet Name",
                                        filename: "SomeFile.xls", 
                                        preserveColors: false
                                    }); 
                                })
                                                             
                    }
                },
                error : function(e){
                    console.log(e);
                }
            })
        }
        else if($("#report #select-acd-report").val() != "" && $("#report #select-year-report").val() != "" && $("#report #select-div-report").val() != "" && $("#report #select-sem-report").val() != "" && $("#report #select-class-report").val() != ""){
            var data = {};
            var title = "";
            $.when(
                data[$("#report #select-acd-report").attr("name")] = $("#report #select-acd-report").val(),
                data[$("#report #select-dept-report").attr("name")] = $("#report #select-dept-report").val(),
                data[$("#report #select-year-report").attr("name")] = $("#report #select-year-report").val(),
                data[$("#report #select-class-report").attr("name")] = $("#report #select-class-report").val(),
                data[$("#report #select-sem-report").attr("name")] = $("#report #select-sem-report").val(),
                data[$("#report #from-date").attr("name")] = $("#report #from-date").val(),
                data[$("#report #till-date").attr("name")] = $("#report #till-date").val(),
                data[$("#report #select-div-report").attr("name")] = $("#report #select-div-report").val(),
                title = $("#report #select-class-report option:selected").text(),
                year = $("#report #select-year-report option:selected").text(),
                acd = $("#report #select-acd-report option:selected").text(),
                div = $("#report #select-div-report option:selected").text(),
                academic_year = $("#report #select-acd-report option:selected").text(),
            ).then(
                getAjaxReport()
            );
            function getAjaxReport(){
                $.ajax({
                    url : "../controller/ajaxController.php?action=admin_report",
                    type : "post",
                    data : data,
                    dataType : "JSON",
                    success : function(res){
                        console.log(res);
                        switch(res.error){
                            case "empty":
                                if($.fn.dataTable.isDataTable("#admin-report")){
                                    $("#admin-report").DataTable().destroy();
                                    $("#admin-report thead tr").html(" ");
                                    $("#admin-report tbody").html(" ");
                                }
                                alert("Enter all Details...");
                                break;
                            case "notexists":
                                if($.fn.dataTable.isDataTable("#admin-report")){
                                    $("#admin-report").DataTable().destroy();
                                    $("#admin-report thead tr").html(" ");
                                    $("#admin-report tbody").html(" ");
                                }
                                alert("No attendance Found")
                                break;
                            case "date":
                                alert("Please Enter Correct Date");
                                break;
                            case "none":
                                if($.fn.dataTable.isDataTable("#admin-report")){
                                    $("#admin-report").DataTable().destroy();
                                    $("#admin-report thead tr").html(" ");
                                    $("#admin-report tbody").html(" ");
                                } 
                                if($.fn.dataTable.isDataTable("#admin-report-adv")){
                                    $("#admin-report-adv").DataTable().destroy();
                                    $("#admin-report-adv thead").html(" ");
                                    $("#admin-report-adv tbody").html(" ");
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
                                    th += "<th>"+date+"</br>"+time+"</th>";
                                } 
                                th += "<th>Total Present</th>";
                                th += "<th>Percentage</th>";
                                var td = "";
                                
                                for(var i = 0; i < res.data.length; i++){
                                    td += "<tr>"
                                    td += "<td>"+res.data[i].roll_no+"</td>";
                                    td += "<td>"+res.data[i].student_name+"</td>";
                                    for(var j = 0; j < numCol; j++){
                                        //if(columns[j] == "student_id") continue;
                                       
                                        if(res.data[i][datecolumns[j]] == 1){
                                            td += "<td>P</td>"
                                        }else{
                                            td += "<td style='color:red'>A</td>"
                                        }
                                    } 
                                    td += "<td>"+res.total[i].total+"</td>";
                                    td += '<td style="mso-number-format:0.00%">'+res.total[i].percent+'</td>';
                                    td += "</tr>"
                                }
                            
                                $("#admin-report thead tr").html(th);
                                $("#admin-report tbody").html(td);
                                $("#faculty_header").html("<h5>Faculty Name: "+res.faculty+"</h5>");
                                $("#lecture_header").html("<h5>Total Lectures: "+numCol+"</h5>");
                                var table = $("#admin-report").DataTable(
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
                                                title : 'Attendance Report_'+title+'_'+year+'_'+'_Div_'+div+'_'+acd,
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
        }
    })
}


function processAjaxYear(){
    $(document).on("change", "#select-dept-report", function(){
        var id = $(this).val();
        console.log(id);
        $.ajax({
            url : "../controller/ajaxController.php?action=get_year_belong_dept",
            type: "post",
            data : {"id" : id},
            dataType : "json",
            success : function(res){
                switch(res.error){
                    case "empty":
                        alert("Please fill all details.");
                        break;
                    case "notfound":
                        var html = "<option value=' '>Not Found</option>";
                        $("#select-year-report").html(html);
                        $("#select-year-report").prop("disabled",true);
                        break;
                    case "none":
                        $("#select-year-report").prop("disabled",false);
                        var html = "";
                        html += "<option value=''> </option>";
                        for(var i = 0; i < res.data.length; i++){
                            html += '<option value="'+res.data[i].year_id+'">'+res.data[i].s_class_name+'</option>';
                        }
                        $("#select-year-report").html(html);
                        break;
                }
            },
            error : function(e){
                console.log(e);
            }
        })


        var id = $(this).val();
        console.log(id);
        $.ajax({
            url : "../controller/ajaxController.php?action=get_div_belongs_dept",
            type: "post",
            data : {"dept_id" : id},
            dataType : "json",
            success : function(res){
                switch(res.error){
                    case "empty":
                        alert("Please fill all details.");
                        break;
                    case "notfound":
                        var html = "<option value=' '>Not Found</option>";
                        $("#select-div-report").html(html);
                        $("#select-div-report").prop("disabled",true);
                        break;
                    case "none":
                        $("#select-div-report").prop("disabled",false);
                        var html = "";
                        html += "<option value=''> </option>";
                        for(var i = 0; i < res.data.length; i++){
                            html += '<option value="'+res.data[i].div_id+'">'+res.data[i].div_name+'</option>';
                        }
                        $("#select-div-report").html(html);
                        break;
                }
            },
            error : function(e){
                console.log(e);
            }
        })
    })
}



function processPracticalReport(){
    var acd = year = sem = div = class_id = from_date = till_date = " "; 
    function takePractReportInput(){
        acd = $("#report-pract #select-acd-report")
        dept = $("#report-pract #select-dept-report")
        year = $("#report-pract #select-year-report")
        sem = $("#report-pract #select-sem-report")
        div = $("#report-pract #select-div-report")
        class_id = $("#report-pract #select-class-report")
        from_date = $("#report-pract #from-date")
        till_date = $("#report-pract #till-date")
        dept_id = $("#report-pract #select-dept-report")
    }
    $("#report-pract").on("change", ".report-select-input-report", function(){
        takePractReportInput();
        console.log(acd.val(), year.val(), sem.val(), div.val(), class_id.val(), from_date.val(), till_date.val());
        if(acd.val() != "" && year.val() != "" && sem.val() != "" &&  div.val() != "" && dept.val() != ""){
            $.ajax({
                url : "../controller/ajaxController.php?action=get_pract_class_sem_wise",
                type : "post",
                data : {"sem" : sem.val(), "acd" : acd.val(), "year" : year.val(), "div" : div.val(), "dept_id" : dept.val()},
                dataType : "json",
                success : function(res){
                    console.log(res);
                    switch(res.error){
                        case "empty":
                            class_id.prop("disabled", true);
                            class_id.val("");
                            class_id.text("");
                            alert("Please fill all details!");
                            break;
                        case "notfound":
                            class_id.val(" ");
                            class_id.text("No class found");
                            break;
                        case "none":
                            class_id.prop("disabled", false);
                            class_id.val("");
                            class_id.text("");
                            if(res.data.length > 0){
                                $("#report-pract #select-class").prop("disabled",false);
                                var html = '<option value=""></option>';
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<option value="'+res.data[i].course_id+'">'+res.data[i].course_name+'</option>';
                                }
                                class_id.html(html);
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
        takePractReportInput();

        $.ajax({
            url : "../controller/ajaxController.php?action=get_pract_report",
            type : "post",
            data : $(this).serialize(),
            dataType : 'json',
            success : function(res){
                console.log(res);
                if(acd.val() != "" && year.val() != "" && div.val() != "" && sem.val() != "" && class_id.val() == ""){
                    DrawpracticalReportTableOfCombinedClass(res);
                }else if(acd.val() != "" && year.val() != "" && div.val() != "" && sem.val() != "" && class_id.val() != ""){
                    DrawpracticalReportTableOfParticularClass(res);
                }
            }
        })

        function DrawpracticalReportTableOfCombinedClass(res){
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
                    alert("Please Fill Required Fields!");
                
                case "none":
                    if($.fn.dataTable.isDataTable("#hod-report-adv")){
                        $("#hod-report-adv").DataTable().destroy();
                        $("#hod-report-adv thead").html(" ");
                        $("#hod-report-adv tbody").html(" ");
                    } 
                    if($.fn.dataTable.isDataTable(".staff-pract-report")){
                        $(".report-tables").html(" ");
                    } 

                    var columns = Object.keys(res.data[0]);
                    var class_columns = columns.slice(6);
                    var numColClass = class_columns.length;
                    var table_header_1 = '<tr>\
                                            <th colspan="2">Class :</th>\
                                            <th colspan="'+numColClass+'">Intersaction Session</th>\
                                            <th colspan="2">Total</th>\
                                        </tr>';
                    var th_body =      '<tr>\
                                            <th>Roll no.</th>\
                                            <th>Name of Student</th>';
                    var th_1 = " ";
                    for(var i = 0; i < numColClass; i++){
                        th_1 += '<th>'+class_columns[i]+'</th>'
                    }
                    var total_th = "<th>Total</th><th>%</th></tr>"

                    var tbody = "<tr>";
                    for(var i = 0; i < res.data.length; i++){
                        tbody += '<td>'+res.data[i].roll_no+'</td>';
                        tbody += '<td>'+res.data[i].student_name+'</td>';
                        var sum = 0;
                        for(var j = 0; j < numColClass; j++){
                            if(res.data[i][class_columns[j]] != null){
                                sum += parseInt(res.data[i][class_columns[j]]);
                                tbody += '<td>'+res.data[i][class_columns[j]]+'</td>' 
                            }else{
                                tbody += '<td>-</td>'
                            }
                        }
                        total_percent = (sum)*100;
                        tbody += '<td>'+sum+'</td>'
                        tbody += '<td style="mso-number-format:"'+0.00+'%">'+total_percent.toFixed(2)+'%</td></tr>';
                    }
                    var concat_header = table_header_1+th_body+th_1+total_th;
                    $("#hod-report-adv thead").html(concat_header);
                    $("#hod-report-adv tbody").html(tbody);
                    $('#hod-report-adv thead th[colspan]').wrapInner( '<span/>' ).append( '&nbsp;' );
                    $("#faculty_header").html(" ");
                    $("#lecture_header").html(" ");
                    $("#hod-report-adv").DataTable(
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
                        }
                    )
                    
                    
                    $("#export").on("click", function(){
                        $("#hod-report-adv").table2excel({
                            name: "Worksheet Name",
                            filename: "SomeFile.xls", 
                            preserveColors: false
                        }); 
                    })                                        
            }
        }

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
                    $("#report-pract #select-class-report").val(" ");
                    break;
                case "date":
                    if($.fn.dataTable.isDataTable("#hod-report-adv")){
                        $("#hod-report-adv").DataTable().destroy();
                        $("#hod-report-adv thead").html(" ");
                        $("#hod-report-adv tbody").html(" ");
                    } 
                    if($.fn.dataTable.isDataTable(".staff-pract-report")){
                        $(".report-tables").html(" ");
                    } 
                    alert("Please Enter Correct Date");
                    break;
                case "none":
                    if($.fn.dataTable.isDataTable(".staff-pract-report")){
                        $(".report-tables").html(" ");
                    }  
                    
                    if($.fn.dataTable.isDataTable("#hod-report-adv")){
                        $("#hod-report-adv").DataTable().destroy();
                        $("#hod-report-adv thead").html(" ");
                        $("#hod-report-adv tbody").html(" ");
                        $("#hod-report-adv tbody").attr("hidden","true");
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
        
        // if(acd.val() != "" && year.val() != "" && div.val() != "" && sem.val() != "" && class_id.val() == ""){
        //     console.log("sushant");
        //     $.ajax({
        //         url : "../controller/ajaxController.php?action=get_pract_report",
        //         type : "post",
        //         data : $(this).serialize(),
        //         dataType : 'json',
        //         success : function(res){
        //             console.log(res);
        //             switch(res.error){
        //                 case "none":
        //                     if($.fn.dataTable.isDataTable("#hod-report-adv")){
        //                         $("#hod-report-adv").DataTable().destroy();
        //                         $("#hod-report-adv thead").html(" ");
        //                         $("#hod-report-adv tbody").html(" ");
        //                     } 
        //                     if($.fn.dataTable.isDataTable("#hod-report")){
        //                         $("#hod-report").DataTable().destroy();
        //                         $("#hod-report thead").html(" ");
        //                         $("#hod-report tbody").html(" ");
        //                     } 

        //                     var columns = Object.keys(res.data[0]);
        //                     var class_columns = columns.slice(3);
        //                     var numColClass = class_columns.length;
        //                     var table_header_1 = '<tr>\
        //                                             <th colspan="2">Class :</th>\
        //                                             <th colspan="'+numColClass+'">Intersaction Session</th>\
        //                                             <th colspan="2">Total</th>\
        //                                         </tr>';
        //                     var th_body =      '<tr>\
        //                                             <th rowspan="2">Roll no.</th>\
        //                                             <th>Name of Student</th>';

        //                     var th_1;
        //                     for(var i = 0; i < numColClass; i++){
        //                         th_1 += '<th>'+class_columns[i]+'</th>'
        //                     }
        //                     var total_th = "<th>Total</th><th>%</th></tr>"

        //                     var total_header = "<tr><th>Total No. of Lectures</th>";
        //                     var columns = Object.values(res.lectures);
        //                     var numColTotal = class_columns.length;
        //                     var th_2;
        //                     var total_sum_lectures = 0;
        //                     for(var i = 0; i < numColTotal; i++){
        //                         total_sum_lectures += parseInt(columns[i]);
        //                         th_2 += '<th>'+columns[i]+'</th>' 
        //                     }
        //                     th_2 += '<th>'+total_sum_lectures+'</th>'
        //                     th_2 += "<th>-</th></tr>";
        //                     var tbody = "<tr>";
        //                     for(var i = 0; i < res.data.length; i++){
        //                         tbody += '<td>'+res.data[i].roll_no+'</td>';
        //                         tbody += '<td>'+res.data[i].student_name+'</td>';
        //                         var sum = 0;
        //                         for(var j = 0; j < numColClass; j++){
        //                             if(res.data[i][class_columns[j]] != null){
        //                                 sum += parseInt(res.data[i][class_columns[j]]);
        //                                 tbody += '<td>'+res.data[i][class_columns[j]]+'</td>' 
        //                             }else{
        //                                 tbody += '<td>-</td>'
        //                             }
        //                         }
        //                         total_percent = (sum/total_sum_lectures)*100;
        //                         tbody += '<td>'+sum+'</td>'
        //                         tbody += '<td style="mso-number-format:"'+0.00+'%">'+total_percent.toFixed(2)+'%</td></tr>';
        //                     }
        //                     var concat_header = table_header_1+th_body+th_1+total_th+total_header+th_2;
                            
        //                     $("#hod-report-adv thead").html(concat_header);
        //                     $("#hod-report-adv tbody").html(tbody);
        //                     $('#hod-report-adv thead th[colspan]').wrapInner( '<span/>' ).append( '&nbsp;' );
        //                     $("#faculty_header").html(" ");
        //                     $("#lecture_header").html(" ");
        //                     $("#hod-report-adv").DataTable(
        //                         {
        //                             scrollY:        "500px",
        //                             scrollX:        true,
        //                             scrollCollapse: true,
        //                             paging:         false,
        //                             autoWidth:  false,
        //                             fixedColumns:   {
        //                                 leftColumns: 2,
        //                                 rightColumns: 1
        //                             },
        //                         }
        //                     )
                            
                            
        //                     $("#export").on("click", function(){
        //                         $("#hod-report-adv").table2excel({
        //                             name: "Worksheet Name",
        //                             filename: "SomeFile.xls", 
        //                             preserveColors: false
        //                         }); 
        //                     })                                        
        //             }
        //         },
        //         error : function(e){
        //             console.log(e);
        //         }
        //     })
        // }
        // else if(acd.val() != "" && year.val() != "" && div.val() != "" && sem.val() != "" && class_id.val() != ""){
        //     $.ajax({
        //         url : "../controller/ajaxController.php?action=get_pract_report",
        //         type : "post",
        //         data : $(this).serialize(),
        //         dataType : "json",
        //         error : function(e){
        //             console.log(e);
        //         },
        //         success : function(res){
        //             console.log(res);
        //             switch(res.error){
        //                 case "empty":
        //                     if($.fn.dataTable.isDataTable("#staff-pract-report")){
        //                         $("#staff-pract-report").DataTable().destroy();
        //                         $("#staff-pract-report thead tr").html(" ");
        //                         $("#staff-pract-report tbody").html(" ");
        //                     }
        //                     alert("Enter all Details...");
        //                     break;
        //                 case "notfound":
        //                     if($.fn.dataTable.isDataTable("#staff-pract-report")){
        //                         $("#staff-pract-report").DataTable().destroy();
        //                         $("#staff-pract-report thead tr").html(" ");
        //                         $("#staff-pract-report tbody").html(" ");
        //                     }
        //                     alert("No attendance Found")
        //                     $("#report-pract #select-class").val(" ");
        //                     break;
        //                 case "date":
        //                     alert("Please Enter Correct Date");
        //                     break;
        //                 case "none":
        //                     if($.fn.dataTable.isDataTable(".staff-pract-report")){
        //                         $(".staff-pract-report").DataTable().destroy()
        //                         $(".report-tables").html(" ");
        //                     }  

        //                     var course = $("#report-pract #select-class option:selected").text();
        //                     var year = $("#report-pract #select-year option:selected").text();
        //                     var table = "";
                            
        //                     Object.keys(res.data).map(function(k){
        //                         $('.report-tables').append("<div class='mt-4'></div><h4 style='text-align:center'>Batch - "+res.data[k][0].batch_name+"</h4>")
        //                         $('.report-tables').append('<button type="button" class="btn btn-success export" id="'+res.data[k][0].batch_name+'">Print</button>');
        //                         var table = $('<table/>').attr({
        //                             id : "staff-pract-report_"+res.data[k][0].batch_name,
        //                             class : "staff-pract-report table table-striped table-bordered"
        //                         });
        //                         table.append("<thead></thead><tbody></tbody><tfoot></tfoot>");
        //                         var columns = Object.keys(res.data[k][0]);
        //                         var datecolumns = columns.slice(7);
        //                         var numCol = datecolumns.length;
        //                         var th = "<tr>";
        //                         th += "<th>Roll no.</th>";
        //                         th += '<th>Student Name.</th>';
        //                         for(var i = 0; i < numCol; i++){
        //                             // if(columns[i] == "student_id") continue;
        //                             var date = new Date(datecolumns[i]);
        //                             var dd = date.getDate();

        //                             var mm = date.getMonth()+1; 
        //                             var yyyy = date.getFullYear();
        //                             var hour    = date.getHours();
        //                             var minute  = date.getMinutes();
        //                             var second  = date.getSeconds(); 
        //                             if(dd<10) 
        //                             {
        //                                 dd='0'+dd;
        //                             } 

        //                             if(mm<10) 
        //                             {
        //                                 mm='0'+mm;
        //                             } 
        //                             if(hour.toString().length == 1) {
        //                                 hour = '0'+hour;
        //                         }
        //                         if(minute.toString().length == 1) {
        //                                 minute = '0'+minute;
        //                         }
        //                         if(second.toString().length == 1) {
        //                                 second = '0'+second;
        //                         } 
        //                             date = dd+'/'+mm+'/'+yyyy;
        //                             time = hour+':'+minute+':'+second;
        //                             th += "<th>"+date+" </br> "+time+"</th>";
        //                         } 
        //                         th += "<th>Total</th>"; 
        //                         th += "<th>Percentage</th></tr>";
        //                         tfoot = "<tr>";
        //                         tfoot += "<td colspan='2'>Total Present</td>"
        //                         for(var z = 0; z < numCol; z++){
        //                             var sum = 0;
        //                             for(var x = 0; x < res.data[k].length; x++){
        //                                 if(res.data[k][x][datecolumns[z]] == 1){
        //                                     sum++;
        //                                 }
        //                             }
        //                             tfoot += "<td>"+sum+"</td>";
        //                         }
        //                         tfoot += '<td colspan="2">&nbsp</td>'
        //                         tfoot += "</tr>";
        //                         console.log(tfoot);
        //                         var td = "";
        //                         for(var i = 0; i < res.data[k].length; i++){
        //                             td += "<tr>"
        //                             td += "<td>"+res.data[k][i].roll_no+"</td>";
        //                             td += "<td>"+res.data[k][i].student_name+"</td>";
        //                             for(var j = 0; j < numCol; j++){
        //                                 if(res.data[k][i][datecolumns[j]] == 1){
        //                                     td += "<td>P</td>"
        //                                 }else{
        //                                     td += "<td style='color:red'>A</td>"
        //                                 }
        //                             } 
        //                             if(res.data[k][i].total == ""){
        //                                 td += "<td>NA</td>";
        //                                 td += '<td style="mso-number-format:0.00%">NA</td>';
        //                             }else{
        //                                 td += "<td>"+res.data[k][i].total+"</td>";
        //                                 td += '<td style="mso-number-format:0.00%">'+parseFloat(res.data[k][i].percent).toFixed(2) +'%'+'</td>';
        //                             }
        //                             td += "</tr>"
        //                         }
        //                         table.find("thead").html(th);
        //                         table.find("tbody").html(td);
        //                         table.find("tfoot").html(tfoot);
        //                         $(".report-tables").append(table);
                                
        //                     }   );
        //                     var table = $(".staff-pract-report").DataTable(
        //                         {
        //                             scrollY:        "300px",
        //                             scrollX:        true,
        //                             scrollCollapse: true,
        //                             paging:         false,
        //                             autoWidth:  false,
        //                             fixedColumns:   {
        //                                 leftColumns: 2,
        //                                 rightColumns: 1
        //                             }
        //                         }
        //                     );
        //                     $(".export").on("click", function(){
        //                         var id = $(this).attr('id');
        //                         console.log(id);
        //                         $("#staff-pract-report_"+id).table2excel({
        //                             name: "Worksheet Name",
        //                             filename: "SomeFile.xls",
        //                             fileext: ".xls",
        //                             preserveColors: false
        //                         }); 
        //                     })
        //                     break;
        //             }
                    
                    /*switch(res.error){
                        case "empty":
                            if($.fn.dataTable.isDataTable("#staff-pract-report")){
                                $("#staff-pract-report").DataTable().destroy();
                                $("#staff-pract-report thead tr").html(" ");
                                $("#staff-pract-report tbody").html(" ");
                            }
                            alert("Enter all Details...");
                            break;
                        case "notfound":
                            if($.fn.dataTable.isDataTable("#staff-pract-report")){
                                $("#staff-pract-report").DataTable().destroy();
                                $("#staff-pract-report thead tr").html(" ");
                                $("#staff-pract-report tbody").html(" ");
                            }
                            alert("No attendance Found")
                            $("#report-pract #select-class").val(" ");
                            break;
                        case "date":
                            alert("Please Enter Correct Date");
                            break;
                        case "none":
                            if($.fn.dataTable.isDataTable("#staff-pract-report")){
                                $("#staff-pract-report").DataTable().destroy();
                                $("#staff-pract-report thead tr").html(" ");
                                $("#staff-pract-report tbody").html(" ");
                            }  
                            var columns = Object.keys(res.data[0]);
                            console.log(columns);
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
                                    td += '<td style="mso-number-format:0.00%">'+parseFloat(res.total[i].percent).toFixed(2) +'%'+'</td>';
                                }
                                td += "</tr>"
                            }
                            $("#staff-pract-report thead tr").html(th);
                            $("#staff-pract-report tbody").html(td);
                            var table = $("#staff-pract-report").DataTable(
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
                                            //title : res.dept[0].dept_name+"-"+res.year[0].s_class_name,
                                        // messageTop: title+" Attendance Academic Year "+academic_year,
                                        }
                                    ]
                                }
                            );
                            break;
                    }*/
                //}
    //         });
    //     }
    }); 
}



