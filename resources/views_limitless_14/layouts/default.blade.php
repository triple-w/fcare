<!doctype html>
<html>

@include('layouts.elements.head')

<body>
    <!-- Modal Eliminar Registro -->
    <div id="modal-elimina-registro" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Eliminar registro</h4>
          </div>
          <div class="modal-body">
            Esta seguro de eliminar el registro?
          </div>
          <div class="modal-footer">
            <input type="hidden" id="href-eliminar" value="">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary aceptar" data-dismiss="modal">Aceptar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal terminos y condiciones -->
    <div id="modal-terminos-condiciones" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body" style="max-height:500px;overflow:scroll;">
            @include('elements.terminos_condiciones_texto')
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary aceptar" data-dismiss="modal">Aceptar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    @include('layouts.elements.navigation_top')

    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">
            @include('layouts.elements.navigation')
            <!-- Main content -->
            <div class="content-wrapper">
                <!-- Content area -->
                <div class="content">
                    <div class="row">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">@yield('panel_title')</h5>
                                <div class="heading-elements">
                                    <ul class="icons-list">
                                        <li><a data-action="collapse"></a></li>
                                        <li><a data-action="reload"></a></li>
                                        <li><a data-action="close"></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body">
                                @include('flash::message')
                                @yield('content')
                            </div>
                        </div>
                        <!-- Footer -->
                        @include('layouts.elements.footer')
                        <!-- /footer -->
                    </div>
                </div>
                <!-- Content area -->
            </div>
            <!-- Main content -->
        </div>
        <!-- Page content -->
    </div>
    <!-- Page container -->

</body>
</html>