<!doctype html>
<html>

<?php echo $__env->make('layouts.elements.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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

    <?php echo $__env->make('layouts.elements.navigation_top', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- Page container -->
    <div class="page-container">
        <!-- Page content -->
        <div class="page-content">
            <?php echo $__env->make('layouts.elements.navigation', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- Main content -->
            <div class="content-wrapper">
                <!-- Content area -->
                <div class="content">
                    <div class="row">
                        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php echo $__env->yieldContent('content'); ?>
                        <!-- Footer -->
                        <?php echo $__env->make('layouts.elements.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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