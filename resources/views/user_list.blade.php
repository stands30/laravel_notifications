<!DOCTYPE html>
<html>
<head>
    <title>Laravel Datatables Tutorial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{ URL::asset('./css/datatable-styles.css') }}" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">User List</h2>
    <table id="usersTable" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Notification Status</th>
                <th>UnRead Notification Count</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(function () {
        const userListRoute = "{{ route('users.index') }}";
          var table = $('#usersTable').DataTable({
              processing: true,
              serverSide: true,
              ajax: userListRoute,
              columns: [
                  {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                  {data: 'name', name: 'name'},
                  {data: 'email', name: 'email'},
                  {data: 'phone_no', name: 'phone_no'},
                  {data: 'notification_status', name: 'is_notification_enabled'},
                  {data: 'notification_status', name: 'is_notification_enabled'},
              ]
          });
          $(document).on('click', '.notification_status', function () {
            let notificationStatus = $(this).prop('checked');
            let userId = $(this).data('id');
            console.log('notification_status ', $(this).prop('checked'), userId);
            $.ajax({
                url: "users/"+userId,
                type: 'PATCH',
            headers: { 'X-CSRF-TOKEN': $('[name=csrf-token]').attr('content') },
                data: { "notification_status": (notificationStatus) ? 1:0 },
                success: function (data) {
                    console.log('notificaiton response log ', data);
                    if(data?.status == true){
                        // swal({
                        //     text: `${_colType} Deactivated Successfully`,
                        //     type: "success",
                        //     icon: "success",
                        //     showConfirmButton: false,
                        //     timer: 2000,
                        // });
                    }
                },
                error: function(response) {

                }
            });
            // reDrawTable();

        });
    });
</script>
</html>
