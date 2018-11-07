<!-- resources/views/auth/login.blade.php -->

@extends('layouts.admin')


@section('title', 'Recuperar Password')

@section('content')

    {!! BootForm::open(); !!}
        {!! BootForm::password('password_actual', 'Password Anterior', ['required' => 'required']); !!}
        {!! BootForm::password('password', 'Password', ['required' => 'required']); !!}
        {!! BootForm::password('password_confirmation', 'Password Confirm', ['required' => 'required']); !!}
        {!! BootForm::submit('Agregar'); !!}
    {!! BootForm::close(); !!}

@endsection