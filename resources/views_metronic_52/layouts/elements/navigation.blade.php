<!-- begin::Topbar -->
<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
    <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
        <div class="m-stack__item m-topbar__nav-wrapper">
            <ul class="m-topbar__nav m-nav m-nav--inline">
                <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1">
                    <!--<a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
                        <span class="m-nav__link-badge m-badge m-badge--dot m-badge--dot-small m-badge--danger"></span>
                        <span class="m-nav__link-icon">
                            <span class="m-nav__link-icon-wrapper">
                                <i class="flaticon-music-2"></i>
                            </span>
                        </span>
                    </a>-->
                    <div class="m-dropdown__wrapper">
                        <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__header m--align-center" style="background: url('{{ asset('/webroot/themes/metronic-52/dist/demo5/assets/app/media/img/misc/notification_bg.jpg') }}'); background-size: cover;">
                                <span class="m-dropdown__header-title">
                                    Info
                                </span>
                                <span class="m-dropdown__header-subtitle">
                                   Sobre tu cuenta
                                </span>
                            </div>
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#topbar_notifications_notifications" role="tab">
                                                Alertas
                                            </a>
                                        </li>
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#topbar_notifications_logs" role="tab">
                                                Logs
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                                            <div class="m-scrollable" data-scrollable="true" data-max-height="250" data-mobile-max-height="200">
                                                <div class="m-list-timeline m-list-timeline--skin-light">
                                                    <div class="m-list-timeline__items">
                                                        <div class="m-list-timeline__item">
                                                            <span class="m-list-timeline__badge -m-list-timeline__badge--state-success"></span>
                                                            <span class="m-list-timeline__text">
                                                                Nada nuevo
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                                            <div class="m-stack m-stack--ver m-stack--general" style="min-height: 180px;">
                                                <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                    <span class="">
                                                        Nada nuevo
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"  m-dropdown-toggle="click">
                    <a href="#" class="m-nav__link m-dropdown__toggle">
                        <span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
                        <span class="m-nav__link-icon">
                            <span class="m-nav__link-icon-wrapper">
                                <i class="flaticon-share"></i>
                            </span>
                        </span>
                    </a>
                    <div class="m-dropdown__wrapper">
                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__header m--align-center" style="background: url('{{ asset('/webroot/themes/metronic-52/dist/demo5/assets/app/media/img/misc/quick_actions_bg.jpg')}}'); background-size: cover;">
                                <span class="m-dropdown__header-title">
                                    Acciones rápidas
                                </span>
                                <span class="m-dropdown__header-subtitle">
                                    Accesos
                                </span>
                            </div>
                            <div class="m-dropdown__body m-dropdown__body--paddingless">
                                <div class="m-dropdown__content">
                                    <div class="m-scrollable" data-scrollable="false" data-max-height="380" data-mobile-max-height="200">
                                        <div class="m-nav-grid m-nav-grid--skin-light">
                                            <div class="m-nav-grid__row">
                                                <a href="#" class="m-nav-grid__item">
                                                    <i class="m-nav-grid__icon flaticon-file"></i>
                                                    <span class="m-nav-grid__text">
                                                        Generar factura
                                                    </span>
                                                </a>
                                                <a href="#" class="m-nav-grid__item">
                                                    <i class="m-nav-grid__icon flaticon-time"></i>
                                                    <span class="m-nav-grid__text">
                                                        Generar complemento de pago
                                                    </span>
                                                </a>
                                            </div>
                                            <!--<div class="m-nav-grid__row">
                                                <a href="#" class="m-nav-grid__item">
                                                    <i class="m-nav-grid__icon flaticon-folder"></i>
                                                    <span class="m-nav-grid__text">
                                                        Periodos
                                                    </span>
                                                </a>
                                                <a href="#" class="m-nav-grid__item">
                                                    <i class="m-nav-grid__icon flaticon-clipboard"></i>
                                                    <span class="m-nav-grid__text">
                                                        Contabilidad
                                                    </span>
                                                </a>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light" m-dropdown-toggle="click">
                    <a href="#" class="m-nav__link m-dropdown__toggle">
                        <span class="m-topbar__welcome">
                            Hola,&nbsp;
                        </span>
                        <span class="m-topbar__username">
                            {{ Auth::user()->getUsername() }}
                        </span>
                        @set('image', HTML::image('webroot/img/logo02.png', 'User', [ 'class' => 'm--img-rounded m--marginless m--img-centered' ]))
                        @if (!empty(Auth::user()->getLogo()))
                            @set("logo", Auth::user()->getLogo()->getName())
                            @set('image', HTML::image("uploads/users_logos/{$logo}", 'User', [ 'class' => 'm--img-rounded m--marginless m--img-centered' ]))
                        @endif
                        <span class="m-topbar__userpic">
                            {!! $image !!}
                        </span>
                    </a>
                    <div class="m-dropdown__wrapper">
                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__header m--align-center" style="background: url('{{ asset('/webroot/themes/metronic-52/dist/demo5/assets/app/media/img/misc/user_profile_bg.jpg')}}'); background-size: cover;">
                                <div class="m-card-user m-card-user--skin-dark">
                                    <div class="m-card-user__pic">
                                        {!! $image !!}
                                    </div>
                                    <div class="m-card-user__details">
                                        <span class="m-card-user__name m--font-weight-500">
                                            {{ Auth::user()->getUsername() }}
                                        </span>
                                        <a href="" class="m-card-user__email m--font-weight-300 m-link">
                                            {{ Auth::user()->getEmail() }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav m-nav--skin-light">
                                        <li class="m-nav__section m--hide">
                                            <span class="m-nav__section-text">
                                                Section
                                            </span>
                                        </li>
                                        <!--<li class="m-nav__item">
                                            <a href="{{ action('Users\AccountsController@getPerfil') }}" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                <span class="m-nav__link-title">
                                                    <span class="m-nav__link-wrap">
                                                        <span class="m-nav__link-text">
                                                            Información
                                                        </span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="{{ action('Users\AccountsController@getChangePassword') }}" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                <span class="m-nav__link-text">
                                                    Cambiar password
                                                </span>
                                            </a>
                                        </li>
                                        @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                                        <li class="m-nav__item">
                                            <a href="{{ action('Users\AccountsController@getDatos') }}" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                <span class="m-nav__link-text">
                                                    Subir sello digital
                                                </span>
                                            </a>
                                        </li>
                                        @endif-->
                                        <li class="m-nav__separator m-nav__separator--fit"></li>
                                        <li class="m-nav__item">
                                            <a href="{{ action('Auth\AuthController@getLogout') }}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- end::Topbar -->
</div>
</div>
</div>
<div class="m-header__bottom">
    <div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- begin::Horizontal Menu -->
            <div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light " id="m_aside_header_menu_mobile_close_btn">
                    <i class="la la-close"></i>
                </button>
                <div id="m_header_menu" class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light "  >
                    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                        <li class="m-menu__item m-menu__item--active"  aria-haspopup="true">
                            <a  href="{{ action('Users\DashboardController@getIndex') }}" class="m-menu__link ">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Dashboard
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
                            <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Facturación
                                </span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <ul class="m-menu__subnav">
                                    @if (Auth::user()->getRol() === 'ROLE_ADMIN')
                                    
                                    <li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                                        <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon flaticon-business"></i>
                                            <span class="m-menu__link-text">
                                                Timbres
                                            </span>
                                            <i class="m-menu__hor-arrow la la-angle-right"></i>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                            <span class="m-menu__arrow "></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Timbres\TimbresController@getTransferencia') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Transferencia
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                        
                                    @endif
                                    @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                                     @if (Auth::user()->isComplete())
                                    <li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                                        <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon flaticon-chat-1"></i>
                                            <span class="m-menu__link-text">
                                                Facturas/CFDI's
                                            </span>
                                            <i class="m-menu__hor-arrow la la-angle-right"></i>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                            <span class="m-menu__arrow "></span>
                                            <ul class="m-menu__subnav">
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\FacturasV33Controller@getIndex') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Facturas
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\NominasController@getIndex') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Nóminas
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\ComplementosV33Controller@getIndex') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Complementos de pago
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                     @endif
                                    @endif
                                    @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                                     @if (Auth::user()->isComplete())
                                    <li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="hover" m-menu-link-redirect="1" aria-haspopup="true">
                                        <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                            <i class="m-menu__link-icon flaticon-chat-1"></i>
                                            <span class="m-menu__link-text">
                                                Comprar timbres
                                            </span>
                                            <i class="m-menu__hor-arrow la la-angle-right"></i>
                                            <i class="m-menu__ver-arrow la la-angle-right"></i>
                                        </a>
                                        <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--right">
                                            <span class="m-menu__arrow "></span>
                                            <ul class="m-menu__subnav">
                                                <!--<li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Pagos\TimbresController@getPago') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Pago con tarjeta
                                                        </span>
                                                    </a>
                                                </li>-->
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\ReportarPagosController@getIndex') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Depósito o transferencia
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                     @endif
                                    @endif
                                    @if (Auth::user()->getRol() === 'ROLE_ADMIN')
                                     
                                    <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                        <a  href="{{ action('Users\AccountsController@getDocumentosAprobar') }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-users"></i>
                                            <span class="m-menu__link-text">
                                                Documentos por aprobar
                                            </span>
                                        </a>
                                    </li>
                                     
                                     
                                     <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                        <a  href="{{ action('Users\AccountsController@getIndex') }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-users"></i>
                                            <span class="m-menu__link-text">
                                                Usuarios
                                            </span>
                                        </a>
                                    </li>
                                     
                                     
                                     <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                        <a  href="{{ action('ReportarPagos\ReportarPagosController@getIndex') }}" class="m-menu__link ">
                                            <i class="m-menu__link-icon flaticon-users"></i>
                                            <span class="m-menu__link-text">
                                                Pagos Reportados
                                            </span>
                                        </a>
                                    </li>
                                     
                                    @endif
                                </ul>
                            </div>
                        </li>
                        @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                        @if (Auth::user()->isComplete())
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"  m-menu-submenu-toggle="click" aria-haspopup="true">
                            <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Catálogos
                                </span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu  m-menu__submenu--fixed m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <ul class="m-menu__subnav">
                                    
                                    
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\ClientesController@getIndex') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Clientes
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\ProductosController@getIndex') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Productos
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\ImpuestosController@getIndex') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Impuestos
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\EmpleadosController@getIndex') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Empleados
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\FoliosController@getIndex') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Folios
                                                        </span>
                                                    </a>
                                                </li>
                                       
                                     
                                </ul>
                            </div>
                        </li>
                        @endif
                        @endif
                        <li class="m-menu__item  m-menu__item--submenu"  m-menu-submenu-toggle="click" m-menu-link-redirect="1" aria-haspopup="true">
                            <a  href="javascript:;" class="m-menu__link m-menu__toggle">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">
                                    Configuración
                                </span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu  m-menu__submenu--fixed-xl m-menu__submenu--center" >
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <div class="m-menu__subnav">
                                    <ul class="m-menu__content">
                                        <li class="m-menu__item">
                                            <h3 class="m-menu__heading m-menu__toggle">
                                                <span class="m-menu__link-text">
                                                    Acerca de
                                                </span>
                                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                                            </h3>
                                            <ul class="m-menu__inner">
                                               
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\AccountsController@getPerfil') }}" class="m-menu__link ">
                                                        <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                        <span class="m-nav__link-wrap">
                                                            <span class="m-nav__link-text">
                                                                Información
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\AccountsController@getChangePassword') }}" class="m-menu__link ">
                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                        <span class="m-nav__link-wrap">
                                                            <span class="m-menu__link-text">
                                                                Cambiar password
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\AccountsController@getDatos') }}" class="m-menu__link ">
                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                        <span class="m-nav__link-wrap">
                                                            <span class="m-menu__link-text">
                                                                Subir sello digital
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                                @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                                                 @if (Auth::user()->isComplete())
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\PlantillasController@getIndex') }}" class="m-menu__link ">
                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                        <span class="m-nav__link-wrap">
                                                            <span class="m-menu__link-text">
                                                                Configurar plantilla de facturas
                                                            </span>
                                                        </span>
                                                    </a>
                                                </li>
                                                @endif
                                                @endif
                                                <!--
                                                @if (Auth::user()->getRol() === 'ROLE_USUARIO')
                                                 @if (Auth::user()->isComplete())
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="{{ action('Users\AccountsController@getQuejasySugerencias') }}" class="m-menu__link ">
                                                        <span class="m-menu__link-text">
                                                            Quejas y Sujerencias
                                                        </span>
                                                    </a>
                                                </li>
                                                 @endif
                                                @endif
                                                <li class="m-menu__item "  m-menu-link-redirect="1" aria-haspopup="true">
                                                    <a  href="#modal-terminos-condiciones" class="m-menu__link terminos-condiciones" data-toggle="modal" data-target="#modal-terminos-condiciones">
                                                        <span class="m-menu__link-text">
                                                            Ver Términos y Condiciones
                                                        </span>
                                                    </a>
                                                </li>
                                                -->
                                                
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end::Horizontal Menu -->	
<!--begin::Search-->
            <div class="m-stack__item m-stack__item--middle m-dropdown m-dropdown--arrow m-dropdown--large m-dropdown--mobile-full-width m-dropdown--align-right m-dropdown--skin-light m-header-search m-header-search--expandable m-header-search--skin-" id="m_quicksearch" m-quicksearch-mode="default">
                <!--begin::Search Form -->
                <form class="m-header-search__form">
                    <div class="m-header-search__wrapper">
                        <span class="m-header-search__icon-search" id="m_quicksearch_search">
                            <i class="la la-search"></i>
                        </span>
                        <span class="m-header-search__input-wrapper">
                            <input autocomplete="off" type="text" name="q" class="m-header-search__input" value="" placeholder="Buscar..." id="m_quicksearch_input">
                        </span>
                        <span class="m-header-search__icon-close" id="m_quicksearch_close">
                            <i class="la la-remove"></i>
                        </span>
                        <span class="m-header-search__icon-cancel" id="m_quicksearch_cancel">
                            <i class="la la-remove"></i>
                        </span>
                    </div>
                </form>
                <!--end::Search Form -->
<!--begin::Search Results -->
                <div class="m-dropdown__wrapper">
                    <div class="m-dropdown__arrow m-dropdown__arrow--center"></div>
                    <div class="m-dropdown__inner">
                        <div class="m-dropdown__body">
                            <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true"  data-max-height="300" data-mobile-max-height="200">
                                <div class="m-dropdown__content m-list-search m-list-search--skin-light"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Search Results -->
            </div>
            <!--end::Search-->
        </div>
    </div>
</div>
</header>
<!-- end::Header -->