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
    processAddDepartment();
    Inputplaceholder();
    processEditDepartment();
    processDeleteDepartment();
    processAddHod();
    processDeleteHod();
    processHodDetail();
    processOnChangeClass()
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
                if(res.error){
                    var html = "";
                    for(var i = 0; i < res.data.length; i++){
                        html += '<tr><td>'+res.data[i].academic_descr+'</td><td><button type="button" class="btn btn-primary">Edit</button><button class="btn btn-danger">Delete</button></td></tr>';
                    }
                    $('#myModal').modal('hide');
                    $('#acad-table').append(html);
                }
            }
        });
    });
}

function processAddDepartment() {
    $('#dpt-form').submit(function(e){
        e.preventDefault();
        var data = {};
        $('#dpt-form input').each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        })
        console.log(data);
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
                            html += '<tr><td class="dept-name">'+res.data[i].dept_name+'</td><td><button type="button" class="btn btn-primary" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button><button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td></tr>';
                        }
                        $('#dept-table tbody').html(html);
                        
                }
            }
        })
    })
}

function Inputplaceholder(){
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
                            html += '<tr><td class="dept-name">'+res.data[i].dept_name+'</td><td><button type="button" class="btn btn-primary" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button><button type="button" class="btn btn-danger id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td></tr>';
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
                                    html += '<tr><td class="dept-name">'+res.data[i].dept_name+'</td><td><button type="button" class="btn btn-primary" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button><button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td></tr>';
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
                                <td>'+res.data[i].faculty_id+'</td>\
                                <td>'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                <td>'+res.data[i].dept_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success" id="view-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#viewModal">View Details</button>\
                                    <button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].faculty_id+'">Delete</button>\
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

function processHodDetail(){
    var id;
    $('#hod-table').on("click","#view-btn", function(){
        id = $(this).attr("data-control");
        console.log(id);
        $.ajax({
            url : "../controller/ajaxController.php?action=hodDetails",
            type : "post",
            data : { data : id },
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
                        $("#edit-form #faculty_id").val(res.data[0].faculty_id);
                        $("#edit-form #fname").val(res.data[0].first_name);
                        $("#edit-form #lname").val(res.data[0].last_name);
                        $("#edit-form #dept-select").text(res.data[0].dept_name).val(res.data[0].dept_id);
                        break;     
                }
            }
        })
    }); 

    
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

function processAddCourse(){
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
                                <td>'+res.data[i].faculty_id+'</td>\
                                <td>'+res.data[i].last_name+' '+ res.data[i].first_name+'</td>\
                                <td>'+res.data[i].dept_name+'</td>\
                                <td>\
                                    <button type="button" class="btn btn-success" id="view-btn" data-control="'+res.data[i].faculty_id+'" data-toggle="modal" data-target="#viewModal">View Details</button>\
                                    <button type="button" class="btn btn-danger" id="del-btn" data-control="'+res.data[i].faculty_id+'">Delete</button>\
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