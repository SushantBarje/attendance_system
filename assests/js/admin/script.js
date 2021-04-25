//  /* When the user clicks on the button, 
// toggle between hiding and showing the dropdown content */
function dropdownbtn() {
    document.getElementById("myDropdown").classList.toggle("show");
    }
    
    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        var i;
        for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
        }
        }
    }
}

$(document).ready(function(){
    processAddDepartment();
});

function processAddDepartment(){
    $("#add_dept").on("submit",function(){
        var data = {};
        $('#add_dept input').each(function(k,v){
            data[$(this).attr('name')] = $(this).val();
        });
        console.log(data);
        $.ajax({
            url: '../controller/ajaxController.php?action=getDepartment',
            type: 'post',
            data : {data : data},
            dataType: 'json',
            success: function(res){
                console.log(res);
            }
        })
    })
   
    
}
