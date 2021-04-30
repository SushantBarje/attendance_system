$(document).ready(function(){
    processAttendanceSheet();
});

function processAttendanceSheet(){
    $("#class-table").on("click","#take-btn",function(){
        var id = $(this).attr("data-control");
        console.log(id);
        $.ajax({
            url : "../controller/ajaxController.php?action=attendanceSheet",
            type : "post",
            data : {data : id},
            dataType : 'json',
            success : function(res){
                console.log(res);
            }
        })
    })
}