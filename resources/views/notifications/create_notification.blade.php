@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Notification') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <div class="container h-100 mt-5">
                            <div class="row h-100 justify-content-center align-items-center">
                                <div class="col-10 col-md-8 col-lg-6">
                                    <form action="{{ route('notification.store') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="type">Type</label>
                                                <select name="type" id="type" class="form-control">
                                                    <option value="1" {{ old('destination') == 1 ? "selected":'' }}>Marketing</option>
                                                    <option value="2"  {{ old('destination') == 2 ? "selected":'' }}>Invoice</option>
                                                    <option value="3" {{ old('destination') == 3 ? "selected":'' }}>System</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br/>
                                        <div class="row">
                                            <div class="form-group">
                                                <label for="data">Body</label>
                                                <textarea class="form-control" id="data" name="data" rows="3" required>{{ old('data') }}</textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class=" col-6 form-group">
                                                <label for="expiration_date">Expiration Date</label>
                                                <input type="date" class="form-control" name="expiration_date"
                                                    id="expiration_date" required value="{{ old('expiration_date') }}">
                                            </div>
                                            <div class=" col-6 form-group">
                                                <label for="expiration_date">Destination</label>
                                                <select name="destination" id="destination" class="form-control">
                                                    <option value="all" {{ old('destination') == "all" ? "selected":'' }}>All Users</option>
                                                    @foreach ($userList as $user)
                                                        <option value="{{ $user->id }}" {{ old('destination') == $user->id ? "selected":'' }}>{{ $user->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-primary">Create Notification</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
