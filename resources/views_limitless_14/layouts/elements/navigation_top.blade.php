<!-- Main navbar -->
<div class="navbar navbar-default header-highlight">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{ action('Users\DashboardController@getIndex') }}"><img src="{{ asset('webroot/img/logo_light.png') }}" alt=""></a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>

            <p class="navbar-text">
                <strong>Timbres Disponibles: </strong>{{ Auth::user()->getTimbresDisponibles() }}
            </p>
            <p class="navbar-text">
                <strong>Descargas Disponibles: </strong>
                @set('ultimoPago', \App\Models\UsersPagosContabilidad::getUltimoPago(Auth::user()))
                @if (!empty($ultimoPago))
                    {{ $ultimoPago->getDescargasDisponibles() }}
                @else
                    0
                @endif
            </p>
            <p class="navbar-text">
                Razon Social: {{ Auth::user()->getPerfil()->getRazonSocial() }}
            </p>
            <p class="navbar-text">
                RFC: {{ Auth::user()->getPerfil()->getRfc() }}
            </p>
            <!-- <li class="dropdown"> -->
            <!--     <a href="#" class="dropdown&#45;toggle" data&#45;toggle="dropdown"> -->
            <!--         <i class="icon&#45;puzzle3"></i> -->
            <!--         <span class="visible&#45;xs&#45;inline&#45;block position&#45;right">Git updates</span> -->
            <!--         <span class="status&#45;mark border&#45;pink&#45;300"></span> -->
            <!--     </a> -->
            <!--  -->
            <!--     <div class="dropdown&#45;menu dropdown&#45;content"> -->
            <!--         <div class="dropdown&#45;content&#45;heading"> -->
            <!--             Git updates -->
            <!--             <ul class="icons&#45;list"> -->
            <!--                 <li><a href="#"><i class="icon&#45;sync"></i></a></li> -->
            <!--             </ul> -->
            <!--         </div> -->
            <!--  -->
            <!--         <ul class="media&#45;list dropdown&#45;content&#45;body width&#45;350"> -->
            <!--             <li class="media"> -->
            <!--                 <div class="media&#45;left"> -->
            <!--                     <a href="#" class="btn border&#45;primary text&#45;primary btn&#45;flat btn&#45;rounded btn&#45;icon btn&#45;sm"><i class="icon&#45;git&#45;pull&#45;request"></i></a> -->
            <!--                 </div> -->
            <!--  -->
            <!--                 <div class="media&#45;body"> -->
            <!--                     Drop the IE <a href="#">specific hacks</a> for temporal inputs -->
            <!--                     <div class="media&#45;annotation">4 minutes ago</div> -->
            <!--                 </div> -->
            <!--             </li> -->
            <!--  -->
            <!--             <li class="media"> -->
            <!--                 <div class="media&#45;left"> -->
            <!--                     <a href="#" class="btn border&#45;warning text&#45;warning btn&#45;flat btn&#45;rounded btn&#45;icon btn&#45;sm"><i class="icon&#45;git&#45;commit"></i></a> -->
            <!--                 </div> -->
            <!--  -->
            <!--                 <div class="media&#45;body"> -->
            <!--                     Add full font overrides for popovers and tooltips -->
            <!--                     <div class="media&#45;annotation">36 minutes ago</div> -->
            <!--                 </div> -->
            <!--             </li> -->
            <!--  -->
            <!--             <li class="media"> -->
            <!--                 <div class="media&#45;left"> -->
            <!--                     <a href="#" class="btn border&#45;info text&#45;info btn&#45;flat btn&#45;rounded btn&#45;icon btn&#45;sm"><i class="icon&#45;git&#45;branch"></i></a> -->
            <!--                 </div> -->
            <!--  -->
            <!--                 <div class="media&#45;body"> -->
            <!--                     <a href="#">Chris Arney</a> created a new <span class="text&#45;semibold">Design</span> branch -->
            <!--                     <div class="media&#45;annotation">2 hours ago</div> -->
            <!--                 </div> -->
            <!--             </li> -->
            <!--  -->
            <!--             <li class="media"> -->
            <!--                 <div class="media&#45;left"> -->
            <!--                     <a href="#" class="btn border&#45;success text&#45;success btn&#45;flat btn&#45;rounded btn&#45;icon btn&#45;sm"><i class="icon&#45;git&#45;merge"></i></a> -->
            <!--                 </div> -->
            <!--  -->
            <!--                 <div class="media&#45;body"> -->
            <!--                     <a href="#">Eugene Kopyov</a> merged <span class="text&#45;semibold">Master</span> and <span class="text&#45;semibold">Dev</span> branches -->
            <!--                     <div class="media&#45;annotation">Dec 18, 18:36</div> -->
            <!--                 </div> -->
            <!--             </li> -->
            <!--  -->
            <!--             <li class="media"> -->
            <!--                 <div class="media&#45;left"> -->
            <!--                     <a href="#" class="btn border&#45;primary text&#45;primary btn&#45;flat btn&#45;rounded btn&#45;icon btn&#45;sm"><i class="icon&#45;git&#45;pull&#45;request"></i></a> -->
            <!--                 </div> -->
            <!--  -->
            <!--                 <div class="media&#45;body"> -->
            <!--                     Have Carousel ignore keyboard events -->
            <!--                     <div class="media&#45;annotation">Dec 12, 05:46</div> -->
            <!--                 </div> -->
            <!--             </li> -->
            <!--         </ul> -->
            <!--  -->
            <!--         <div class="dropdown&#45;content&#45;footer"> -->
            <!--             <a href="#" data&#45;popup="tooltip" title="All activity"><i class="icon&#45;menu display&#45;block"></i></a> -->
            <!--         </div> -->
            <!--     </div> -->
            <!-- </li> -->
        </ul>

        <div class="navbar-right">
            <!-- <p class="navbar&#45;text">Morning, Victoria!</p> -->
            <!-- <p class="navbar&#45;text"><span class="label bg&#45;success">Online</span></p> -->

            <!-- <ul class="nav navbar&#45;nav"> -->
            <!--     <li class="dropdown"> -->
            <!--         <a href="#" class="dropdown&#45;toggle" data&#45;toggle="dropdown"> -->
            <!--             <i class="icon&#45;bell2"></i> -->
            <!--             <span class="visible&#45;xs&#45;inline&#45;block position&#45;right">Activity</span> -->
            <!--             <span class="status&#45;mark border&#45;pink&#45;300"></span> -->
            <!--         </a> -->
            <!--  -->
            <!--         <div class="dropdown&#45;menu dropdown&#45;content"> -->
            <!--             <div class="dropdown&#45;content&#45;heading"> -->
            <!--                 Activity -->
            <!--                 <ul class="icons&#45;list"> -->
            <!--                     <li><a href="#"><i class="icon&#45;menu7"></i></a></li> -->
            <!--                 </ul> -->
            <!--             </div> -->
            <!--  -->
            <!--             <ul class="media&#45;list dropdown&#45;content&#45;body width&#45;350"> -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"> -->
            <!--                         <a href="#" class="btn bg&#45;success&#45;400 btn&#45;rounded btn&#45;icon btn&#45;xs"><i class="icon&#45;mention"></i></a> -->
            <!--                     </div> -->
            <!--  -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         <a href="#">Taylor Swift</a> mentioned you in a post "Angular JS. Tips and tricks" -->
            <!--                         <div class="media&#45;annotation">4 minutes ago</div> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--  -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"> -->
            <!--                         <a href="#" class="btn bg&#45;pink&#45;400 btn&#45;rounded btn&#45;icon btn&#45;xs"><i class="icon&#45;paperplane"></i></a> -->
            <!--                     </div> -->
            <!--  -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         Special offers have been sent to subscribed users by <a href="#">Donna Gordon</a> -->
            <!--                         <div class="media&#45;annotation">36 minutes ago</div> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--  -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"> -->
            <!--                         <a href="#" class="btn bg&#45;blue btn&#45;rounded btn&#45;icon btn&#45;xs"><i class="icon&#45;plus3"></i></a> -->
            <!--                     </div> -->
            <!--  -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         <a href="#">Chris Arney</a> created a new <span class="text&#45;semibold">Design</span> branch in <span class="text&#45;semibold">Limitless</span> repository -->
            <!--                         <div class="media&#45;annotation">2 hours ago</div> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--  -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"> -->
            <!--                         <a href="#" class="btn bg&#45;purple&#45;300 btn&#45;rounded btn&#45;icon btn&#45;xs"><i class="icon&#45;truck"></i></a> -->
            <!--                     </div> -->
            <!--  -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         Shipping cost to the Netherlands has been reduced, database updated -->
            <!--                         <div class="media&#45;annotation">Feb 8, 11:30</div> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--  -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"> -->
            <!--                         <a href="#" class="btn bg&#45;warning&#45;400 btn&#45;rounded btn&#45;icon btn&#45;xs"><i class="icon&#45;bubble8"></i></a> -->
            <!--                     </div> -->
            <!--  -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         New review received on <a href="#">Server side integration</a> services -->
            <!--                         <div class="media&#45;annotation">Feb 2, 10:20</div> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--  -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"> -->
            <!--                         <a href="#" class="btn bg&#45;teal&#45;400 btn&#45;rounded btn&#45;icon btn&#45;xs"><i class="icon&#45;spinner11"></i></a> -->
            <!--                     </div> -->
            <!--  -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         <strong>January, 2016</strong> &#45; 1320 new users, 3284 orders, $49,390 revenue -->
            <!--                         <div class="media&#45;annotation">Feb 1, 05:46</div> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--             </ul> -->
            <!--         </div> -->
            <!--     </li> -->
            <!--  -->
            <!--     <li class="dropdown"> -->
            <!--         <a href="#" class="dropdown&#45;toggle" data&#45;toggle="dropdown"> -->
            <!--             <i class="icon&#45;bubble8"></i> -->
            <!--             <span class="visible&#45;xs&#45;inline&#45;block position&#45;right">Messages</span> -->
            <!--             <span class="status&#45;mark border&#45;pink&#45;300"></span> -->
            <!--         </a> -->
            <!--  -->
            <!--         <div class="dropdown&#45;menu dropdown&#45;content width&#45;350"> -->
            <!--             <div class="dropdown&#45;content&#45;heading"> -->
            <!--                 Messages -->
            <!--                 <ul class="icons&#45;list"> -->
            <!--                     <li><a href="#"><i class="icon&#45;compose"></i></a></li> -->
            <!--                 </ul> -->
            <!--             </div> -->
            <!--  -->
            <!--             <ul class="media&#45;list dropdown&#45;content&#45;body"> -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"> -->
            <!--                         <img src="assets/images/placeholder.jpg" class="img&#45;circle img&#45;sm" alt=""> -->
            <!--                         <span class="badge bg&#45;danger&#45;400 media&#45;badge">5</span> -->
            <!--                     </div> -->
            <!--  -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         <a href="#" class="media&#45;heading"> -->
            <!--                             <span class="text&#45;semibold">James Alexander</span> -->
            <!--                             <span class="media&#45;annotation pull&#45;right">04:58</span> -->
            <!--                         </a> -->
            <!--  -->
            <!--                         <span class="text&#45;muted">who knows, maybe that would be the best thing for me...</span> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--  -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"> -->
            <!--                         <img src="assets/images/placeholder.jpg" class="img&#45;circle img&#45;sm" alt=""> -->
            <!--                         <span class="badge bg&#45;danger&#45;400 media&#45;badge">4</span> -->
            <!--                     </div> -->
            <!--  -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         <a href="#" class="media&#45;heading"> -->
            <!--                             <span class="text&#45;semibold">Margo Baker</span> -->
            <!--                             <span class="media&#45;annotation pull&#45;right">12:16</span> -->
            <!--                         </a> -->
            <!--  -->
            <!--                         <span class="text&#45;muted">That was something he was unable to do because...</span> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--  -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"><img src="assets/images/placeholder.jpg" class="img&#45;circle img&#45;sm" alt=""></div> -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         <a href="#" class="media&#45;heading"> -->
            <!--                             <span class="text&#45;semibold">Jeremy Victorino</span> -->
            <!--                             <span class="media&#45;annotation pull&#45;right">22:48</span> -->
            <!--                         </a> -->
            <!--  -->
            <!--                         <span class="text&#45;muted">But that would be extremely strained and suspicious...</span> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--  -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"><img src="assets/images/placeholder.jpg" class="img&#45;circle img&#45;sm" alt=""></div> -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         <a href="#" class="media&#45;heading"> -->
            <!--                             <span class="text&#45;semibold">Beatrix Diaz</span> -->
            <!--                             <span class="media&#45;annotation pull&#45;right">Tue</span> -->
            <!--                         </a> -->
            <!--  -->
            <!--                         <span class="text&#45;muted">What a strenuous career it is that I've chosen...</span> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--  -->
            <!--                 <li class="media"> -->
            <!--                     <div class="media&#45;left"><img src="assets/images/placeholder.jpg" class="img&#45;circle img&#45;sm" alt=""></div> -->
            <!--                     <div class="media&#45;body"> -->
            <!--                         <a href="#" class="media&#45;heading"> -->
            <!--                             <span class="text&#45;semibold">Richard Vango</span> -->
            <!--                             <span class="media&#45;annotation pull&#45;right">Mon</span> -->
            <!--                         </a> -->
            <!--  -->
            <!--                         <span class="text&#45;muted">Other travelling salesmen live a life of luxury...</span> -->
            <!--                     </div> -->
            <!--                 </li> -->
            <!--             </ul> -->
            <!--  -->
            <!--             <div class="dropdown&#45;content&#45;footer"> -->
            <!--                 <a href="#" data&#45;popup="tooltip" title="All messages"><i class="icon&#45;menu display&#45;block"></i></a> -->
            <!--             </div> -->
            <!--         </div> -->
            <!--     </li> -->
            <!-- </ul> -->
        </div>
    </div>
</div>
<!-- /main navbar -->