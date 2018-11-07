
@section('title', 'Editar Perfil')

@section('content')

    <h3>Username: {{ $user->getUsername() }}</h3>

    
        {!! BootForm::open([ 'files' => true ]); !!}
            @set('userCategorias', [])
            @foreach ($user->getCategorias() as $categoria)
                @set('userCategorias[]', $categoria->getCategoria()->getId())
            @endforeach
            @set('categorias', [])
            @foreach (\App\Models\Categorias::findAll() as $categoria)
                @set("categorias[$categoria->getId()]", $categoria->getNombre())
            @endforeach
            {!! BootForm::checkboxes('nuevasCategorias[]', 'Intereses', $categorias, $userCategorias); !!}
            
            <hr />
            <h4>Imagen de Perfil</h4>
            @if (!empty($user->getTipoFile('PERFIL')))
                {!! HTML::image("uploads/users_files/{$user->getTipoFile('PERFIL')->getName()}", '', [ 'width' => '75', 'height' => '75' ]) !!}
                {!! HTML::link(action('Users\AccountsController@getBorrarFile', [ 'id' => $user->getTipoFile('PERFIL')->getId() ]), 'Borrar', [ 'class' => 'btn btn-danger' ], false) !!}
            @else
                {!! BootForm::file('PERFIL', 'Imagen de Perfil', []); !!}
            @endif

            {!! BootForm::submit('Aceptar'); !!}
        {!! BootForm::close(); !!}

@endsection