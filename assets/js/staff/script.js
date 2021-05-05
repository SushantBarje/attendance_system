$(document).ready(function(){
    processAttendanceSheet();
    //processMarkAttendance();
    processSubmitAttendance();
});

function processAttendanceSheet(){
    $("#select-class").on("change",function(){
        var data = {}
        id = $(this).find(":selected").data('class');
        var year = $("#select-acd").val();
        if(id == ' '){
            $("#attendance-table tbody").html(" ");
            alert("Select Class!");
            return;
        }
        if(year == ' '){
            $("#selec-class").val(" ");
            alert("Selec Academic Year");
            return;
        }
        
        //id = $(this).val();
        console.log(id);
        $.ajax({
            url : "../controller/ajaxController.php?action=attendanceSheet",
            type : "post",
            data : {data : id, year : year},
            dataType : 'json',
            success : function(res){
                console.log(res);
                $("#attendance-table").removeAttr("hidden");
                $("#save-btn").removeAttr("hidden");
                var html = "";
                for(var i = 0; i < res.length; i++){
                    var name = res[i].last_name +" "+ res[i].first_name+" "+res[i].middle_name;
                    var obj = '<label>Present</label> <input type="radio" name="attend['+res[i].prn_no+']" value="1" checked/> <label>Absent</label> <input type="radio" name="attend['+res[i].prn_no+']" value="0"/>';
                    var prn = '<input type="text" name="prn['+res[i].prn_no+']" value="'+res[i].prn_no+'" hidden>';
                    html += '<tr><td>'+res[i].roll_no+'</td><td>'+name+'</td><td>'+obj+'</td><td hidden>'+prn+'</td></tr>';
                }
                $('#attendance-table tbody').html(html);
            }
        })
    })
}


// function processMarkAttendance(){
//     $('#container').on("click",".att", function(){
//         if($(this).text() == "P"){
//             $(this).text("A");
//             $(this).removeClass("btn btn-success");
//             $(this).addClass("btn btn-danger");
//             $(this).attr("data-control",0);
//         }else{
//             $(this).text("P");
//             $(this).removeClass("btn btn-danger");
//             $(this).addClass("btn btn-success");
//             $(this).attr("data-control",1);
//         }
//     }); 
// }

function processSubmitAttendance(){
    $(document).on("submit","#check-attend",function(){
        $.ajax({
            url: '../controller/ajaxController.php?action=save_attend',
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res){
                console.log(res);
                switch(res.error){
                    case "none":
                        alert("Attendence Submitted");
                        break;
                }
            }
        })
    })
}