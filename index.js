checkStatus = (e) => {
    let regignationDateInput = document.querySelector('#resignation_date')
    if (e.value === "1") regignationDateInput.disabled = false
    else regignationDateInput.disabled = true
}

saveAllData = () => {
    console.log("save all data")
    var tableData = [];
    $('#attendanceTable tr').each(function(row, tr) {
        tableData[row]={
            "employee_id" : $(tr).find('td:eq(0)').text(),
            "date" : $(tr).find('td:eq(2) input[type="datetime-local"]').val(),
            "working_status" : $(tr).find('td:eq(3) input[type="radio"]').val()
        }
    });
    tableData.shift();

    $.ajax({
        url: 'save_attendance.php',
        type: 'post',
        data: 
        {
           tableData: tableData,
        },
        dataType: 'json',
        success:function(response){
            alert("Data saved successfully")
        },
        error: function(){
            alert('error!');
        }
    });

}