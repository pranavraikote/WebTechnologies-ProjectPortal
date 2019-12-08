function approve_change(id){
    $.post('modifyStudentTeam.php',{postusn:id},
    function(){
        alert("APPROVED");
        location.reload();
    }
    );
}