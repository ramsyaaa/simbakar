<!--Nav Start-->
<nav class="nav navbar navbar-expand-xl navbar-light iq-navbar header-hover-menu left-border">
    <div class="container-fluid navbar-inner">
       <a href="{{route('admin.dashboard')}}" class="navbar-brand">
          
          <!--Logo start-->
          <div class="logo-main">
            <div class="logo-normal">
               <div class="icon-30">
                   <img src="{{asset('assets/images/logo-ip.png')}}" alt="" width="200" class="pb-5 d-block mx-auto my-auto">
               </div>
           </div>
           <div class="logo-mini">
               <div class="icon-30">
                   <img src="{{asset('assets/images/new-logo.png')}}" alt="">
               </div>
           </div>
          </div>
          <!--logo End-->  
       </a>
       <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
          <i class="icon d-flex">
             <svg class="icon-20" width="20" viewbox="0 0 24 24">
                <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"></path>
             </svg>
          </i>
       </div>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
             <li class="nav-item dropdown" id="itemdropdown1">
                <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   <div class="btn btn-primary btn-icon btn-sm rounded-pill">
                      <span class="btn-inner">
                         <svg class="icon-32" width="32" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.997 15.1746C7.684 15.1746 4 15.8546 4 18.5746C4 21.2956 7.661 21.9996 11.997 21.9996C16.31 21.9996 19.994 21.3206 19.994 18.5996C19.994 15.8786 16.334 15.1746 11.997 15.1746Z" fill="currentColor"></path>
                            <path opacity="0.4" d="M11.9971 12.5838C14.9351 12.5838 17.2891 10.2288 17.2891 7.29176C17.2891 4.35476 14.9351 1.99976 11.9971 1.99976C9.06008 1.99976 6.70508 4.35476 6.70508 7.29176C6.70508 10.2288 9.06008 12.5838 11.9971 12.5838Z" fill="currentColor"></path>
                         </svg>
                      </span>
                   </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                   <li>
                     <form action="{{route('logout')}}" method="POST">
                        @csrf

                        <button class="dropdown-item" type="submit">Logout</button>
                     </form>
                   </li>
                </ul>
             </li>
             <li class="nav-item iq-full-screen d-none d-xl-block" id="fullscreen-item">
                <a href="#" class="nav-link" id="btnFullscreen" data-bs-toggle="dropdown">
                   <div class="btn btn-primary btn-icon btn-sm rounded-pill">
                      <span class="btn-inner">
                         <svg class="normal-screen icon-24" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.5528 5.99656L13.8595 10.8961" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M14.8016 5.97618L18.5524 5.99629L18.5176 9.96906" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M5.8574 18.896L10.5507 13.9964" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M9.60852 18.9164L5.85775 18.8963L5.89258 14.9235" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                         </svg>
                         <svg class="full-normal-screen d-none icon-24" width="24" height="24" viewbox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.7542 10.1932L18.1867 5.79319" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M17.2976 10.212L13.7547 10.1934L13.7871 6.62518" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M10.4224 13.5726L5.82149 18.1398" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M6.74391 13.5535L10.4209 13.5723L10.3867 17.2755" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                         </svg>
                      </span>
                   </div>
                </a>
             </li>
          </ul>
       </div>
    </div>
 </nav>            <!--Nav End-->
</div>