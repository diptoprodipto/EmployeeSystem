checkStatus = (e) => {
    let regignationDateInput = document.querySelector('#resignation_date')
    if (e.value === "1") regignationDateInput.disabled = false
    else regignationDateInput.disabled = true
}

saveAllData = () => {
    var presentTableData = []
    var absentTableData = []

    $('#presentTable tr').each(function(row, tr) {
        presentTableData[row]={
            "employee_id" : $(tr).find('td:eq(0)').text(),
            "date" : $(tr).find('td:eq(2) input[type="date"]').val(),
            "working_status" : $(tr).find('td:eq(3) input[type="radio"]:checked').val()
        }
    });
    presentTableData.shift()

    console.log(presentTableData)

    $('#absentTable tr').each(function(row, tr) {
        absentTableData[row]={
            "employee_id" : $(tr).find('td:eq(0)').text(),
            "date" : $(tr).find('td:eq(2) input[type="date"]').val(),
            "working_status" : $(tr).find('td:eq(3) input[type="radio"]:checked').val()
        }
    });

    $.ajax({
        url: 'save_attendance.php',
        type: 'post',
        data: 
        {
            presentTableData: presentTableData,
            absentTableData: absentTableData,
        },
        dataType: 'json',
        success:function(response){
            // alert("Data saved successfully")
            location.reload();
        },
        error: function(){
            alert('error!');
        }
    });

}