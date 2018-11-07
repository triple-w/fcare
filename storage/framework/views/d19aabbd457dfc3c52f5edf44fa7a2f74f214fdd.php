<?php $__env->startSection('title', 'Agregar Factura'); ?>

<?php $__env->startSection('styles'); ?>

    <!-- CSS -->
    <?php echo HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/css/socialize-bookmarks.css'); ?>

    <?php echo HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/fancybox/source/jquery.fancybox.css?v=2.1.4'); ?>

    <?php echo HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/check_radio/skins/square/aero.css'); ?>


    <!-- Toggle Switch -->
    <?php echo HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/css/jquery.switch.css'); ?>


    <!-- Owl Carousel Assets -->
    <?php echo HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/css/owl.carousel.css'); ?>

    <?php echo HTML::styleLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/css/owl.theme.css'); ?>


    <!-- Google web font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' rel='stylesheet' type='text/css'>

    <style>
        .ui-widget { }
        .ui-widget input, .ui-widget select, .ui-widget textarea, .ui-widget button {}
        .ui-widget-content { background: #fff; color: #222222; }
        .ui-widget-content a { color: #222222; }
        .ui-widget-header {background: #f68e56; }
        .ui-widget-header a { color: #222222; }
        .ui-progressbar { height:2em; text-align: left; }
        .ui-progressbar .ui-progressbar-value {margin: -1px; height:100%; }

        #bottom-wizard {
            text-align:center;
            padding:15px 120px;
            border-top:1px solid #e7e7e7;
            background-color:#f3f3f3;
        }

        #bottom-wizard {padding:15px 30px;}



        /*#bottom-wizard {margin}*/

    </style>

<?php $__env->appendSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <?php echo HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/jquery-ui-1.8.22.min.js'); ?>


    <!-- Wizard-->
    <?php echo HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/jquery.wizard.js'); ?>


    <!-- Radio and checkbox styles -->
    <?php echo HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/check_radio/jquery.icheck.js'); ?>


    <!-- HTML5 and CSS3-in older browsers-->
    <?php echo HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/modernizr.custom.17475.js'); ?>


    <!-- Support media queries for IE8 -->
    <?php echo HTML::scriptLocal('webroot/themes/clean-ui/annova-survey-wizard/annova_files_v1.6/html/full/js/respond.min.js'); ?>


    <?php echo HTML::scriptLocal('webroot/js/fnsGenerales_no_require.js?v=1.0.0'); ?>


    <?php echo HTML::scriptLocal('webroot/js/limitless_14/facturasV33_add.js?v=1.1.4'); ?>

    <?php echo HTML::script('assets/js/plugins/forms/validation/validate.min.js'); ?>

    <?php echo HTML::script('assets/js/plugins/forms/selects/bootstrap_multiselect.js'); ?>

    <?php echo HTML::script('assets/js/plugins/forms/selects/select2.min.js'); ?>


<?php $__env->appendSection(); ?>

<?php $__env->startSection('content'); ?>

    <div id="modal-add-cliente" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Nuevo Cliente</h4>
          </div>
            <?php echo BootForm::open([ 'id' => 'form-agregar-cliente' ]); ?>

                  <div class="modal-body">
                    <input type="hidden" name="tipo" value="" />
                    <input type="hidden" name="id" value="" />
                    <?php echo BootForm::text('rfc', 'RFC', null, [
                        'data-validation' => '[NOTEMPTY, L<30]',
                        'data-validation-message' => 'Campo requerido y máximo 15 caracteres',
                        'data-validation-regex' => '/^[A-Z,Ñ,&]{3,4}[0-9]{2}[0-1][0-9][0-3][0-9][A-Z,0-9]{3}$/',
                        'data-validation-regex-message' => 'RFC no válido',
                    ]); ?>

                    <?php echo BootForm::text('razonSocial', 'Razon Social', null, [
                        'data-validation' => '[NOTEMPTY, L<200]',
                        'data-validation-message' => 'Campo requerido y máximo 90 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('calle', 'Calle', null, [
                        'data-validation' => '[NOTEMPTY, L<90]',
                        'data-validation-message' => 'Campo requerido y máximo 90 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('noExt', 'Numero Exterior', null, [
                        'data-validation' => '[NOTEMPTY, L<10]',
                        'data-validation-message' => 'Campo requerido y máximo 10 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('noInt', 'Numero Interior', null, [
                        'data-validation' => '[OPTIONAL,L<10]',
                        'data-validation-message' => 'Máximo 10 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('colonia', 'Colonia', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('municipio', 'Municipio', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('localidad', 'Localidad', null, [
                        'data-validation' => '[OPTIONAL,L<50]',
                        'data-validation-message' => 'Máximo 30 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('estado', 'Estado', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('codigoPostal', 'Codigo Postal', null, [
                        'data-validation' => '[NOTEMPTY, L<10]',
                        'data-validation-message' => 'Campo requerido y máximo 10 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('pais', 'Pais', null, [
                        'data-validation' => '[NOTEMPTY, L<50]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('telefono', 'Telefono', null, [
                        'data-validation' => '[NOTEMPTY, L<30]',
                        'data-validation-message' => 'Campo requerido y máximo 30 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('nombreContacto', 'Nombre de Contacto', null, [
                        'data-validation' => '[OPTIONAL,L<90]',
                        'data-validation-message' => 'Máximo 90 caracteres',
                    ]); ?>

                    <?php echo BootForm::text('email', 'Email', null, [
                        'data-validation' => '[OPTIONAL,EMAIL]',
                        'data-validation-message' => 'Email no válido',
                    ]); ?>

              </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Agregar">
            <?php echo BootForm::close();; ?>

          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <?php /* <div class="alert alert-success mensaje-cliente-agregar" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Cliente agregado correctamente
    </div>

    <div class="alert alert-success mensaje-cliente-editar" style="display:none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        Cliente editado correctamente
    </div> */ ?>

    <!-- Start Survey container -->
    <div id="survey_container">

        <div id="top-wizard">
            <strong>Progreso <span id="location"></span></strong>
            <div id="progressbar"></div>
            <div class="shadow"></div>
        </div><!-- end top-wizard -->

        <?php echo BootForm::open([ 'id' => 'form-wizard' ]);; ?>

            <div id="middle-wizard">
                <div class="step row">
                    <div class="col-md-12">
                    <h2>Tipo de CFDI</h2>
                    <?php echo BootForm::select('nombreComprobante', 'Nombre de Comprobante', \App\Models\Facturas::getNombresDocumentos(), null, [ 'class' => 'nombreComprobante' ]); ?>

                    <?php echo BootForm::date('fechaFactura', 'Fecha de expedición', null, [ 'class' => 'datetimepicker' ]); ?>

                    <h2>Serie y Folio</h2>
                    <?php echo BootForm::text('serie', 'Serie', null, [ 'class' => 'serie' ]); ?>

                    <?php echo BootForm::text('folio', 'Folio', null, [ 'class' => 'folio' ]); ?>

                    <h2>Cliente</h2>
                    <?php $clientes = []; $__data['clientes'] = []; ?>
                    <?php
app('blade.helpers')->get('loop')->newLoop(Auth::user()->getClientes());
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $cliente):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <?php $clientes[$cliente->getId()] = $cliente->getRazonSocial() . ' - ' . $cliente->getRfc(); $__data['clientes[$cliente->getId()]'] = $cliente->getRazonSocial() . ' - ' . $cliente->getRfc(); ?>
                    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                    <button id="nuevo-cliente" class="btn btn-success"><i class="icon-plus2" aria-hidden="true"></i> Nuevo Cliente</button>
                    <button id="actualizar-cliente" class="btn btn-success"><i class="icon-pencil5" aria-hidden="true"></i> Actualizar Cliente</button>
                    <div class="mensaje-cliente" style="color:red"></div>
                    <?php echo BootForm::select('cliente', 'Cliente', $clientes, [], [ 'id' => 'clientes', 'readonly' => 'readonly' ]); ?>

                    <div class="col-md-4">
                        <?php echo BootForm::text('rfc', 'RFC', null, [ 'class' => 'cliente-rfc recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('razonSocial', 'Razon Social', null, [ 'class' => 'cliente-razonSocial recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('calle', 'Calle', null, [ 'class' => 'cliente-calle recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('noExt', 'No Ext', null, [ 'class' => 'cliente-noExt recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('noInt', 'No Int', null, [ 'class' => 'cliente-noInt recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('colonia', 'Colonia', null, [ 'class' => 'cliente-colonia recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('municipio', 'Municipio', null, [ 'class' => 'cliente-municipio recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('localidad', 'Localidad', null, [ 'class' => 'cliente-localidad recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('estado', 'Estado', null, [ 'class' => 'cliente-estado recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('codigoPostal', 'Codigo Postal', null, [ 'class' => 'cliente-codigoPostal recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('pais', 'Pais', null, [ 'class' => 'cliente-pais recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('telefono', 'Telefono', null, [ 'class' => 'cliente-telefono recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('nombreContacto', 'Nombre de Contacto', null, [ 'class' => 'cliente-nombreContacto recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <div class="col-md-4">
                        <?php echo BootForm::text('email', 'Email', null, [ 'class' => 'cliente-email recolect-cliente', 'readonly' => 'readonly' ]); ?>

                    </div>
                    <h2>Productos</h2>
                    <?php $productos = []; $__data['productos'] = []; ?>
                    <?php
app('blade.helpers')->get('loop')->newLoop(Auth::user()->getProductos());
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as  $producto):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
                        <?php $productos[$producto->getId()] = "{$producto->getClave()} - {$producto->getDescripcion()}"; $__data['productos[$producto->getId()]'] = "{$producto->getClave()} - {$producto->getDescripcion()}"; ?>
                    <?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>
                    <div class="cont">
                        <div class="clone">
                            <?php echo BootForm::select('nProductos', 'Producto', $productos, [], [ 'id' => 'productos' ]); ?>

                            <h3>Información de Producto</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo BootForm::select('nClaveServProd', 'Clave de Servicio', [], [], [ 'id' => 'clave-prod-serv', 'data-url' => 'productos/clave-prod-serv' ]); ?>

                                    <input type="hidden" id="hclave-prod-serv" value=""/>
                                    <input type="hidden" id="hclave-prod-serv-text" value=""/>
                                </div>
                                <div class="col-md-6">
                                    <?php echo BootForm::select('nClaveUnidad', 'Clave de Unidad', [], [], [ 'id' => 'clave-unidad', 'data-url' => 'productos/clave-unidad' ]); ?>

                                    <input type="hidden" id="hclave-unidad" value=""/>
                                    <input type="hidden" id="hclave-unidad-text" value=""/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <?php echo BootForm::text('nUnidadProducto', 'Unidad de Producto', null, [ 'id' => 'unidad_producto' ]); ?>

                                </div>
                                <div class="col-md-6">
                                    <?php echo BootForm::text('nClaveProducto', 'Clave de Producto', null, [ 'id' => 'clave_producto' ]); ?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <?php echo BootForm::text('nDescripcionProducto', 'Descripción de Producto', null, [ 'id' => 'descripcion_producto' ]); ?>

                                </div>
                                <div class="col-md-4">
                                    <?php echo BootForm::text('nObservacionesProducto', 'Observaciones de Producto', null, [ 'id' => 'observaciones_producto' ]); ?>

                                </div>
                                <div class="col-md-4">
                                    <?php echo BootForm::text('nDescuento', 'descuento', null, [ 'id' => 'descuento_producto' ]); ?>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <?php echo BootForm::text('nPrecio', 'Precio', null, [ 'id' => 'precio', 'class' => 'fixed-to-2' ]); ?>

                                    <div class="mensaje-precio" style="color:red"></div>
                                </div>
                                <div class="col-md-4">
                                    <?php echo BootForm::text('nCantidad', 'Cantidad', '1', [ 'id' => 'cantidad' ]); ?>

                                    <div class="mensaje-cantidad" style="color:red"></div>
                                </div>
                            </div>
                            <h3>Impuestos de Producto</h3>
                            <div class="contenedor-retenciones">
                                <div class="row rete">
                                    <div class="col-md-4">
                                        <?php echo BootForm::select('nRetenciones', 'Tipo de Retencion', \App\Models\Facturas::getClavesImpuestos(), [], [ 'id' => 'retenciones', 'class' => 'retenciones-tipo' ]); ?>

                                        <div class="mensaje-retenciones" style="color:red"></div>
                                    </div>
                                    <div class="col-md-4">
                                    <?php echo BootForm::text('nRetencionesTasa', 'Retenciones Tasa', '', [ 'id' => 'retenciones-tasa', 'class' => 'retenciones-tasa' ]); ?>

                                        <div class="mensaje-retenciones-tasa" style="color:red"></div>
                                    </div>
                                    <a href="#" class="mas-retencion">+</a>
                                </div>
                            </div>
                            <div class="contenedor-traslados">
                                <div class="row tras">
                                    <div class="col-md-4">
                                        <?php echo BootForm::select('nTrasladados', 'Trasladados Tipo', \App\Models\Facturas::getClavesImpuestos(), [], [ 'id' => 'trasladados', 'class' => 'traslados-tipo'  ]); ?>

                                        <div class="mensaje-traslados" style="color:red"></div>
                                    </div>
                                    <div class="col-md-4">
                                        <?php echo BootForm::text('nTrasladadosTasa', 'Trasladados Tasa', '', [ 'id' => 'trasladados-tasa', 'class' => 'traslados-tasa'  ]); ?>

                                        <div class="mensaje-traslados-tasa" style="color:red"></div>
                                    </div>
                                    <a href="#" class="mas-traslado">+</a>
                                </div>
                            </div>
                            <?php echo HTML::link('#', '<i class="icon-checkmark2" aria-hidden="true"></i> Agregar', [ 'class' => 'btn btn-default btn-agregar' ]); ?>

                            <br />
                            <br />
                        </div>
                        <div class="mensaje" style="color:red"></div>
                        <div class="table-responsive">
                            <table class="table table-productos">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Clave Servicio</th>
                                        <th>Clave Unidad</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Descuento</th>
                                        <?php /* <th>IVA</th> */ ?>
                                        <th>Importe</th>
                                        <th class="delete">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <p class="subtotal" style="text-align:right"><strong>Subtotal: </strong><span></span></p>
                    </div>
                    <br />
                    <br />

                    <h2>Datos CFDI</h2>
                    <?php echo BootForm::select('formaPago', 'Forma de Pago *', \App\Models\Facturas::getFormasPago(), [ 'class' => 'forma-pago', 'required' => 'required' ]); ?>

                    <div class="mensaje-pago" style="color:red"></div>
                    <?php echo BootForm::select('tipoMoneda', 'Tipo de Moneda', \App\Models\Facturas::getTiposMonedas(), 'MXN', [ 'id' => 'select-tipo-moneda' ]); ?>

                    <div class="cont-tipo-moneda">
                        <?php echo BootForm::text('tipoCambio', 'Tipo de Cambio', null, [ 'class' => 'tipo-moneda' ]); ?>

                    </div>
                    <?php echo BootForm::select('metodoPago', 'Metodo de Pago', \App\Models\Facturas::getMetodosPago(), [], [ 'class' => 'metodo-pago' ]); ?>

                    <?php echo BootForm::select('usoCFDI', 'Uso de CFDI', \App\Models\Facturas::getUsosCFDI(), [], [ 'class' => 'uso-cfdi' ]); ?>

                    <div class="mensaje-comentarios" style="color:red"></div>
                    <?php /* <?php echo BootForm::text('folioFo', 'Folio FO', null, []); ?>

                    <?php echo BootForm::text('serieFolioFo', 'Serie de Folio FO', null, []); ?>

                    <?php echo BootForm::text('fechaFolioFo', 'Fecha de Folio FO', null, []); ?>

                    <?php echo BootForm::text('montoFolioFo', 'Monto de Folio FO', null, []); ?> */ ?>
                    </div>
                </div>
                <div class="step row">
                <div class="col-md-12">
                    <br />
                    <br />
                    <br />
                    <div class="row">
                        <div class="col-md-6">
                            <h4><strong>Comprobante: </strong><span class="Ccomprobante"></span></h4>
                        </div>
                        <div class="col-md-6">
                            <h4><strong>Fecha: </strong><span class="Cfecha-comprobante"></span></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2><strong>Cliente</strong></h2>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente">Cliente: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-rfc">RFC: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-razonSocial">Razon Social: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-calle">Calle: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-noExt">No Ext: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-noInt">No Int: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-colonia">Colonia: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-municipio">Municipio: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-localidad">Localidad: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-estado">Estado: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-codigoPostal">Codigo Postal: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-pais">Pais: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-telefono">Telefono: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-nombreContacto">Nombre de Contacto: <span></span></p>
                        </div>
                        <div class="col-md-4">
                            <p class="Ccliente-email">Email: <span></span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h2><strong>Productos</strong></h2>
                            <div class="clone-productos"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="text-right"><strong>Impuestos</strong></h2>
                            <div class="clone-impuestos text-right">
                                <p class="Ctotal-trasladado">Total Trasladado: <span></span></p>
                                <p class="Ctotal-retenido">Total Retenido: <span></span></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2 class="text-right"><strong>Importes</strong></h2>
                            <div class="clone-importes text-right">
                                <p class="Csubtotal">Subtotal: <span></span></p>
                                <p class="Cdescuento">Descuento: <span></span></p>
                                <p class="Cnuevo-subtotal">Nuevo subtotal: <span></span></p>
                            </div>
                            <h2 class="Ctotal text-right"><strong>Total de factura:</strong> <span></span></h2>
                            <input type="submit" class="btn btn-primary" style="float:right" value="Facturar">
                            <br />
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div id="bottom-wizard">
                <button type="button" name="backward" class="btn btn-info backward"><</i></button>
                <button type="button" name="forward" class="btn btn-success forward">></i></button>
            </div><!-- end bottom-wizard -->
        <?php echo BootForm::close();; ?>


    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo HTML::scriptLocal('webroot/js/limitless_14/generals.js'); ?>

<?php $__env->appendSection(); ?>
