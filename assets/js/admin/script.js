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
                            for(var i = 0; i < res.data.length; i++){
                                html += '<tr><td class="dept-name">'+res.data[i].dept_name+'</td><td><button type="button" class="btn btn-primary" id="edit-btn" data-control="'+res.data[i].dept_id+'" data-toggle="modal" data-target="#editModal">Edit</button><button type="button" class="btn btn-danger id="del-btn" data-control="'+res.data[i].dept_id+'">Delete</button></td></tr>';
                            }
                            $('#dept-table tbody').html(html);  
                    }
                }
            })
        }
    })
}