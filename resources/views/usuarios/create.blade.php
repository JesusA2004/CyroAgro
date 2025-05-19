@extends('layouts.auth')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Create User</h1>
        <form action="{{ route('users.store') }}" method="POST">
            @include('users.form')
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</main>
@endsection