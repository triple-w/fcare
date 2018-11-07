<!-- begin::Header -->
<header id="m_header" class="m-grid__item		m-header "  m-minimize="minimize" m-minimize-offset="200" m-minimize-mobile-offset="200" >
    <div class="m-header__top">
        <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
            <div class="m-stack m-stack--ver m-stack--desktop">
                <!-- begin::Brand -->
                        <div class="m-stack__item m-brand">
                                <div class="m-stack m-stack--ver m-stack--general m-stack--inline">
                                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                        <a href="<?php echo e(action('Users\DashboardController@getIndex')); ?>" class="m-brand__logo-wrapper">
                                                <img alt="logo" src="<?php echo e(asset('webroot/img/logofactu.png')); ?>" class="img img-logo img-header"/>
                                        </a>
                                    </div>
                                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
                                            <a href="#" class="dropdown-toggle m-dropdown__toggle btn btn-outline-metal m-btn  m-btn--icon m-btn--pill">
                                                <span>
                                                    Info rápida
                                                </span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <ul class="m-nav">
                                                                <!--<li class="m-nav__item">
                                                                    <a href="" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                        <span class="m-nav__link-text">
                                                                        Descargas Disponibles:
                                                                        </span>
                                                                    </a>
                                                                    <?php $ultimoPago = \App\Models\UsersPagosContabilidad::getUltimoPago(Auth::user()); $__data['ultimoPago'] = \App\Models\UsersPagosContabilidad::getUltimoPago(Auth::user()); ?>
                                                                    <?php if(!empty($ultimoPago)): ?>
                                                                        <?php echo e($ultimoPago->getDescargasDisponibles()); ?>

                                                                    <?php else: ?>
                                                                        0
                                                                    <?php endif; ?>
                                                                </li>
                                                                <li class="m-nav__separator m-nav__separator--fit"></li>-->
                                                                <li class="m-nav__item">
                                                                    <a href="" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                        <span class="m-nav__link-text">
                                                                            Razon Social:
                                                                        </span>
                                                                    </a>
                                                                    <?php echo e(Auth::user()->getPerfil()->getRazonSocial()); ?>

                                                                </li>
                                                                <li class="m-nav__separator m-nav__separator--fit"></li>
                                                                <li class="m-nav__item">
                                                                    <a href="" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-info"></i>
                                                                        <span class="m-nav__link-text">
                                                                            RFC:
                                                                        </span>
                                                                    </a>
                                                                    <?php echo e(Auth::user()->getPerfil()->getRfc()); ?>

                                                                </li>
                                                                <li class="m-nav__separator m-nav__separator--fit"></li>
                                                                <li class="m-nav__item">
                                                                    <a href="" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                        <span class="m-nav__link-text">
                                                                        Timbres Disponibles: 
                                                                        </span>
                                                                    </a>
                                                                    <?php echo e(Auth::user()->getTimbresDisponibles()); ?>

                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- begin::Responsive Header Menu Toggler-->
                                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;" class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                                            <span></span>
                                        </a>
                                        <!-- end::Responsive Header Menu Toggler-->
                                        <!-- begin::Topbar Toggler-->
                                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                                            <i class="flaticon-more"></i>
                                        </a>
                                        <!--end::Topbar Toggler-->
                                    </div>
                                </div>
                            </div>
                            <!-- end::Brand -->
                            