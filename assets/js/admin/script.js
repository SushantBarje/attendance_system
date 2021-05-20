// //  /* When the user clicks on the button, 
// // toggle between hiding and showing the dropdown content */
// function dropdownbtn() {
//     document.getElementById("myDropdown").classList.toggle("show");
//     }
    
//     // Close the dropdown if the user clicks outside of it
//     window.onclick = function(event) {
//     if (!event.target.matches('.dropbtn')) {
//         var dropdowns = document.getElementsByClassName("dropdown-content");
//         var i;
//         for (i = 0; i < dropdowns.length; i++) {
//         var openDropdown = dropdowns[i];
//         if (openDropdown.classList.contains('show')) {
//             openDropdown.classList.remove('show');
//         }
//         }
//     }
// }

$(document).ready(function(){
    processAddAcademicYear();
    processDeleteAcademicYear()
    processAddDepartment();
    inputDeptPlaceholder();
    processEditDepartment();
    processDeleteDepartment();
    processAddHod();
    processDeleteHod();
    //processHodDetail();
    processEditHod();
    processOnChangeClass()
    processAddCourse();
    processEditCourse();
    processDeleteCourse()
    inputCoursePlaceholder();
    inputHodPlaceholder();
    processReport();
    // $("#dept-m").on("click", function(){
    //     $(this).find("option:selected",this).remove();
    // })
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


// function processAddDepartment() {
//     $('#dpt-form').submit(function(e){
//         e.preventDefault();
//         var data = {};
//         $.when(
//             $('#dpt-form input').each(function(k,v){
//                 data[$(v).attr('name')] = $(v).val();
//             })
//         ).then(            
//             console.log(jQuery.isEmptyObject(data)),
//             $('#myModal').modal('hide'),
//             $.ajax({
//                 url : '../controller/ajaxController.php?action=addDept',
//                 type : 'POST',
//                 data : data,
//                 dataType : 'json',
//                 success : function(res) {
//                     console.log(res);
//                     switch(res.error){
//                         case "empty":
//                             alert("Please Fill all the fields");
//                             break;
//                         case "notinsert":
//                             alert("Data Not Inserted");
//                             break;
//                         case "none":
//                             var html = "";
//                             for(var i = 0; i < res.data.length; i++){
//                                 html += '<tr><td class="dept-name">'+res.data[i].dept_name+'</td><td><button type="button" class="btn btn-primary mr-4" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button><button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td></tr>';
//                             }
//                             $('#dept-table tbody').html(html)
                            
//                     }
//                 }
//             })
//         );
//     })
// }

function processAddDepartment() {
    $('#dpt-form').submit(function(e){
        e.preventDefault();
        var data = {};
        
            $('#dpt-form input').each(function(k,v){
                data[$(v).attr('name')] = $(v).val();
            })
                
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
                                html += '<tr><td class="dept-name">'+res.data[i].dept_name+'</td><td><button type="button" class="btn btn-primary mr-4" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button><button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td></tr>';
                            }
                            $('#dept-table tbody').html(html)
                            
                    }
                }
            })
    
    })
}

function inputDeptPlaceholder(){
    $("#dept-table").on("click","#edit-btn",function(){
        var c = $(this).closest("tr").find('.dept-name').text();
        $("#editModal input").val(c);
    })
}

function processEditDepartment(){
    var id;
    $('#dept-table').on("click","#edit-btn", function(){
        id = $(this).attr("data-control");
        console.log(id);
    });

    $("#edit-dept").on("submit", function(){
        var data = {};
        $("#edit-dept input").each(function(){
            data[$(this).attr('name')] = $(this).val();
        });
        data['dept_id'] = id;
        console.log(data);
        $('#editModal').modal('hide');
        $.ajax({
            url : "../controller/ajaxController.php?action=editDept",
            type : "post",
            data : data,
            dataType : 'json',
            success : function(res){
                console.log(res);
                switch(res.error){
                    case "empty":
                        alert("Please Fill all the fields");
                        break;
                    case "notedit":
                        alert("Data Not Inserted");
                        break;
                    case "none":
                        var html = "";
                        for(var i = 0; i < res.data.length; i++){
                            html += '<tr><td class="dept-name">'+res.data[i].dept_name+'</td><td><button type="button" class="btn btn-primary mr-1" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button><button type="button" class="btn btn-danger id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td></tr>';
                        }
                        $('#dept-table tbody').html(html);     
                }
            }
        });
        return false;
    });
}

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
                                for(var i = 0; i < res.data.length; i++){
                                    html += '<tr><td class="dept-name">'+res.data[i].dept_name+'</td><td><button type="button" class="btn btn-primary mr-1" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button><button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td></tr>';
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
    })
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
        var id = $(this).val();
        console.log(id);
        if(id == " ") return $(".s-sem").html('<option value="'+' '+'">Select Year</option>').prop("disabled",true);
        $.ajax({
            url : "../controller/ajaxController.php?action=getSem",
            type : "post",
            data : {data : id},
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


// function processReport(){
    
//     $(document).on("change", "#acd-year" ,function(){
//         if($(this).val() == " "){
//             $("#dept").attr("disabled","");
//             $("#chartContainer").addClass("chart-hide")
//             alert("Please Select Academic Year!");
//             return;
//         }else{
//             $("#dept").removeAttr("disabled");
//             $("#chartContainer").removeClass("chart-hide");
//             var acd_id = $(this).val();
//             showAcademicChart(acd_id);
            //else if(class_year_id == " "){
            //     $.ajax({
            //         url : "../controller/ajaxController.php?action=report_dept_attend",
            //         type: "post",
            //         data : {acd_id : acd_id, dept_id : dept_id},
            //         dataType: "json",
            //         success : function(res){
            //             console.log(res);
            //         }
            //     })
            // }else{
            //     $.ajax({
            //         url : "../controller/ajaxController.php?action=report_classyear_attend",
            //         type: "post",
            //         data : {acd_id : acd_id, dept_id : dept_id, class_year_id : class_year_id},
            //         dataType: "json",
            //         success : function(res){
            //             console.log(res);
            //         }
            //     });
    //          }
            

              
    // })

    // $(document).on("change","#dept", function(){
    //     var acd_id = $("#acd-year").val();
    //     var dept_id = $(this).val()
    //     if(acd_id == " "){
    //         $("#chartContainer").addClass("chart-hide")
    //         alert("Please Select Academic Year!");
    //         return;
    //     }else if(acd_id!= " "){
    //         showAcademicChart(acd_id);
    //     }else if(dept_id != " "){
    //         $("#chartContainer")
    //         showDepartmentWiseChart(acd_id,dept_id);
    //     }
    // });

    // $(document).on("change","#class-year", function(){
    //     var acd_id = $("#acd-year").val();
    //     var dept_id = $("#dept").val();
    //     var class_year_id = $(this).val();
    //     if(acd_id == " "){
    //         $("#chartContainer").addClass("chart-hide")
    //         alert("Please Select Academic Year!");
    //         return;
    //     }else if(acd_id!= " "){
    //         showAcademicChart(acd_id);
    //     }else if(dept_id != " "){
    //         showDepartmentWiseChart(acd_id,dept_id);
    //     }
    // });
// }

// function showAcademicChart(){
    // $.ajax({
    //     url : "../controller/ajaxController.php?action=report_acd_attend",
    //     type: "post",
    //     data : {data : acd_id},
    //     dataType: "json",
    //     success : function(res){
    //         console.log(res);
    //     }
    // });


      //Better to construct options first and then pass it as a parameter
                // var options = {
                //     animationEnabled: true,
                    
                //     title:{
                //         text: "Academic Record" ,
                //         fontFamily: "tahoma",  
                //     },
                //     axisY:{
                //         title:"Total number of Students"
                //     },
                //     toolTip: {
                //         shared: true,
                //         reversed: true
                //     },
                //     data: [{
                //         type: "stackedColumn",
                //         name: "Present",
                //         showInLegend: "true",
                //         yValueFormatString: "0",
                //         dataPoints: [
                //             { y: 50 , label: "CSE" },
                //             { y: 1, label: "Mech" },
                //             { y: 1, label: "ENTC" },
                //         ]
                //     },
                //     {
                //         type: "stackedColumn",
                //         name: "Absent",
                //         showInLegend: "true",
                //           indexLabel: "#total",
                //           indexLabelPlacement: "outside",
                //         yValueFormatString: "0",
                //         dataPoints: [
                //             { y: 13, label: "CSE" },
                //             { y: 1, label: "Mech" },
                //             { y: 1, label: "ENTC" },
                            
                //         ]
                //     }]
                // };
                
                // $("#chartContainer").CanvasJSChart(options);
           // }
// }

// function processReport(){
//     $("#report-form").on("submit", function(){
//         $.ajax({
//             url : "../controller/ajaxController.php?action=admin_report",
//             type : "post",
//             data : $(this).serialize(),
//             dataType : 'json',
//             success: function(res) {
//                 console.log(res);
//             }
//         })
//     });
// }

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