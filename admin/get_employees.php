<script>
    $(document).ready(function() {
    $('#siteId').on('change', function() {
        var siteId = $(this).val();
        if (siteId) {
            $.ajax({
                type: 'POST',
                url: 'get_employees.php', // Endpoint to fetch employees based on site
                data: { siteId: siteId },
                success: function(data) {
                    $('#employeeList').html(data);
                }
            });
        } else {
            $('#employeeList').html(''); // Clear the employee list if no site selected
        }
    });

    // Submit Form via AJAX
    $('#attendanceForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'process_attendance.php', // Endpoint to process the attendance data
            data: $('#attendanceForm').serialize(),
            success: function(response) {
                alert(response); // Display success or error message
            }
        });
    });
});

</script>