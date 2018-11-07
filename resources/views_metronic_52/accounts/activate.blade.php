<!-- resources/views/auth/login.blade.php -->

@extends('layouts.empty')

@section('title', 'Activar Usuario')

@section('content')

    {!! BootForm::open(); !!}
        <input type="hidden" name="id" value="{{ $user->id }}" />
        {!! BootForm::password('password', 'Password', ['required' => 'required']); !!}
        {!! BootForm::password('password_confirmation', 'Password Confirm', ['required' => 'required']); !!}
        {!! BootForm::submit('Agregar'); !!}
    {!! BootForm::close(); !!}

@endsection