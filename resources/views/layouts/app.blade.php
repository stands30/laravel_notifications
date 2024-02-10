<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Notificaitons') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('./css/styles.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if (Auth::user()->user_role == 'admin')
                                <li class="nav-item create-notif">
                                    <a class="nav-link"
                                        href="{{ route('notification.index') }}">{{ __('Create notification') }}</a>
                                </li>
                            @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown1" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img class="notif-icon" src="{{ asset('images/notif_icon.png') }}"
                                        alt="notifications" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-end notif-container" aria-labelledby="navbarDropdown">
                                    @forelse($notifications as $notification)

                                        <div class="alert alert-success" role="alert">
                                            [@switch($notification->notification_type)
                                                @case(1)
                                                    Marketing
                                                    @break
                                                @case(2)
                                                    Invoice
                                                    @break
                                                @case(3)
                                                    System
                                                    @break
                                            @endswitch] {{ $notification->data }}
                                            <a href="#" class="float-right mark-as-read " data-id="{{ $notification->id }}">
                                                Mark as read
                                            </a>
                                        </div>

                                        @if($loop->last)
                                            <a href="#" id="mark-all" class="all-read-tag">
                                                Mark all as read
                                            </a>
                                        @endif
                                    @empty
                                        <p class="no-notif">There are no new notifications</p>
                                    @endforelse

                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @if (Route::currentRouteName() == 'users.index' || Route::currentRouteName() == 'home')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
             const userListRoute = "{{ route('users.index') }}";
             function initDataTable(){
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
                    {data: 'unred_count', name: 'unred_count'},
                ]
            });
             }
          $(document).on("ready", function(){
            initDataTable();
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
                        swal({
                            text: `Notification Toggle updated Successfully`,
                            type: "success",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 2000,
                        });
                    }
                },
                error: function(response) {
                    console.log('Oops!! some error occured');
                }
            });

        });
        </script>
    @endif
<script type="text/javascript">
    $(function () {

        function sendMarkRequest(id = null) {
            return $.ajax("{{ route('markNotification') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('[name=csrf-token]').attr('content') },
                data: {
                    id
                }
            });
        }
        $('.mark-as-read').click(function() {
            let request = sendMarkRequest($(this).data('id'));
            request.done(() => {
                location.reload();
            });
        });
        $('#mark-all').click(function() {
            let request = sendMarkRequest();
            request.done(() => {
                location.reload();
            })
        });
    });
</script>
</body>

</html>
