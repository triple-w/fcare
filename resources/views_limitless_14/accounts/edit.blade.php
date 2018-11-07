<!-- resources/views/auth/login.blade.php -->

@extends('layouts.admin')

@section('title', 'Agregar Usuario')

@section('content')

    {!! BootForm::open(['url' => 'users/edit']); !!}
        <input type="hidden" name="id" value="{{ $user->id }}" />
        {!! BootForm::email('email', 'Email', $user->email, ['required' => 'required']); !!}
        {!! BootForm::text('nombre', 'Nombre', $user->nombre, ['required' => 'required']); !!}
        {!! BootForm::text('apellidoPaterno', 'Apellido Paterno', $user->apellidoPaterno, ['required' => 'required']); !!}
        {!! BootForm::text('apellidoMaterno', 'Apellido Materno', $user->apellidoMaterno, ['required' => 'required']); !!}
        {!! BootForm::select('rol', 'Rol', [' ' => 'Seleccione', 'ROLE_ADMIN' => 'ADMINISTRADOR', 'ROLE_USER' => 'USUARIO'], $user->rol, ['required' => 'required']); !!}
        {!! BootForm:checkboxes('permisos', 'Permisos', \App\Models\Users::getListPermisos(), $user->getPermisos(), []) !!}
        {!! BootForm::checkbox('active', 'Activo', '', $user->active); !!}
        {!! BootForm::submit('Aceptar'); !!}
    {!! BootForm::close(); !!}

@endsection