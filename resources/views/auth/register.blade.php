@extends('layouts.app')

@section('content')

<div class="border text-center w-50 bg-light container-fluid">
    <h2 class="modal-titlemx-auto text-center fw-bold" id="exampleModalLabel">Sign Up</h2>
    <form class="form-group" method="post" action="{{ route('register') }}">
        {{ csrf_field() }}
        <label for="name">Name</label>
        <input name="name" class="bg-white w-50" type="text" id="name" placeholder="Enter name" required autofocus>
        @if ($errors->has('name'))
        <br>
        <span class="text-danger error">
            {{ $errors->first('name') }}
        </span>
        @endif

        <label for="email">Email address</label>
        <input name="email" class="bg-white w-50" type="email" id="email" placeholder="Enter email" required>
        @if ($errors->has('email'))
        <br>
        <span class="text-danger error">
            {{ $errors->first('email') }}
        </span>
        @endif

        <label for="password">Password</label>
        <input name="password" class="bg-white w-50" type="password" id="password" placeholder="Password" required>
        @if ($errors->has('password'))
        <br>
        <span class="text-danger error">
            {{ $errors->first('password') }}
        </span>
        @endif

        <label for="password">Confirm Password</label>
        <input name="password_confirmation" class="bg-white w-50" type="password" id="password-confirm" placeholder="Confirm Password" required>

        <label for="birthDate">Birth Date</label>
        <input name="birthDate" type="date" id="birthDate" required>

        <label for="country">Country</label>
        <input name="country" class="bg-white w-50" type="text" id="country" placeholder="Country" required>
        
        <label for="avatar">Choose avatar</label>
        <input name="avatar" type="file" id="avatar">
        <br>
        <button type="submit" class="btn btn-secondary w-50 fw-bold">Sign Up</button>
    </form>
</div>

@endsection