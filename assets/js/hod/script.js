$(document).ready(function(){
    processOnChangeClass();
    processAddStudent();
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
        $('#myModal #add-hod').trigger("reset");
        $('#myModal').modal('hide');
        $.ajax({
            url : '../controller/ajaxController.php?action=addstudent',
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