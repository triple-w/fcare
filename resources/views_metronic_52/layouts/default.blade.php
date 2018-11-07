<!doctype html>
<html>

@include('layouts.elements.head')

<!-- begin::Body -->
<body  class="m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default"  >
    <!-- Modal Eliminar Registro -->
    <div id="modal-elimina-registro" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Eliminar registro</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
      @include('layouts.elements.navigation_top')
      @include('layouts.elements.navigation')
      <!-- begin::Body -->
      <div class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop 	m-container m-container--responsive m-container--xxl m-page__container m-body">
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
          <!-- BEGIN: Subheader -->
          <div class="m-subheader ">
            <div class="d-flex align-items-center">
              <div class="mr-auto">
                <h3 class="m-subheader__title ">
                  @yield('title') 
                  @yield('panel_title')
                </h3>
              </div>
            </div>
          </div>
          <!-- END: Subheader -->
          <div class="m-content">
            <!--Begin::Section-->
            <div class="row">
                @include('flash::message')
            </div>
            <div class="m-portlet">
                <div class="m-portlet__body">
                  <div class="row">
                    <div class="col-md-12">
                      @yield('content')
                    </div>
                  </div>
                </div>
            </div>
            <!--End::Section-->
          </div>
        </div>
      </div>
      <!-- end::Body -->
      <!-- begin::Footer -->
      @include('layouts.elements.footer')
      <!-- end::Footer -->
    </div>
    <!-- end:: Page -->

</body>
<!-- end::Body -->
</html>