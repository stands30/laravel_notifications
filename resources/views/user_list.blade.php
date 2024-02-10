@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@section('content')

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
                <th>Un Read Notification Count</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection
