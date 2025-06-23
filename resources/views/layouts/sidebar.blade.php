<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu" style="background-color: #99e7c5">

    <!-- LOGO -->
    <div class="navbar-brand-box" style="background-color: #99e7c5;">
        <a href="/dashboard" class="logo logo-dark">
            <span class="logo-sm">
                <img class="" src="{{ URL::asset('/assets/images/logo-aisyiyah.png') }}" alt="" height="30" style="align-self: center; margin-top: 20px;">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/A.svg') }}" alt="" height="30" style="align-self: center; margin-top: 20px;">
            </span>
        </a>

        <a href="/dashboard" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('/assets/images/logo-aisyiyah.png') }}" alt="" height="10"  style="align-self: center; margin-top: 20px;">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('/assets/images/A.svg') }}" alt="" height="30" style="align-self: center; margin-top: 20px;">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">
        @if(Session::has('menu') && is_array(Session::get('menu')))
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                {{-- <li class="menu-title">@lang('translation.Menu')</li> --}}
                @if(in_array('pr0k3r', Session::get('menu')))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-business-time"></i>
                        <span>Program Kerja<span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/proker">List Proker</a></li>
                    @if(in_array('p3r10d3', Session::get('menu')))
                        <li><a href="/periode">Periode</a></li>
                    @endif
                    </ul>
                </li>
				@endif
                @if(in_array('n3w5', Session::get('menu')))
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-newspaper"></i>
                        <span>News<span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="/post">All Post</a></li>
                        <li><a href="/newscategory">News Category</a></li>
                    </ul>
                </li>
                @endif

                @if(in_array('5ur4t', Session::get('menu')))
                <li>
                    <a href="/inbox/{{Session::get('user_id')}}" class="">
                        <i class="uil-envelope"></i>
                        <span>e-Surat</span>
                    </a>
                </li>
                @endif

                @if(in_array('k4d3r', Session::get('menu')))
                <li>
                    <a href="/kader" class="">
                        <i class="uil-users-alt"></i>
                        <span>Kader</span>
                    </a>
                </li>
                @endif

                @if(in_array('4um', Session::get('menu')))
                <li>
                    <a href="/aum" class="">
                        <i class="uil-store"></i>
                        <span>AUM</span>
                    </a>
                </li>
                @endif

                @if(in_array('d0c5', Session::get('menu')))
                <li>
                    <a href="/document" class="waves-effect">
                        <i class="uil-file"></i>
                        <span>Document</span>
                    </a>
                </li>
                @endif

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-apps"></i>
                        {{-- <span>@lang('translation.Contacts')</span> --}}
                        <span>Master Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        @if(in_array('r0l3', Session::get('menu')))
                            <li><a href="/role">Role Manajemen</a></li>
                        @endif
                        
                        @if(in_array('r0l3', Session::get('menu')))
                        <li><a href="/account">Account Manajemen</a></li>
                        @endif

                        @if(in_array('pd4', Session::get('menu')))
                        <li><a href="/pda">PDA Manajemen</a></li>
                        @endif                

                        @if(in_array('pc4', Session::get('menu')))
                        <li><a href="/pca">PCA Manajemen</a></li>
                        @endif                

                        @if(in_array('r4nt1ng', Session::get('menu')))
                        <li><a href="/ranting">Ranting Manajemen</a></li>
                        @endif                

                        @if(in_array('m47el15', Session::get('menu')))
                        <li><a href="/majelis">Majelis/Lembaga Manajemen</a></li>
                        @endif                

                        @if(in_array('f1l3', Session::get('menu')))
                        <li><a href="/filetype">File Type Manajemen</a></li>
                        @endif                

                        @if(in_array('b1d4ng', Session::get('menu')))
                        <li><a href="/bidangusaha">Bidang Usaha Manajemen</a></li>
                        @endif

                    </ul>
                </li>

                @if(Session::get('role_code') == 'PWA2' OR Session::get('role_code') == 'SUP')
                <li>
                    <a href="/landingproperty" class="waves-effect">
                        <i class="uil-comment-alt-image"></i>
                        <span>Landing Page</span>
                    </a>
                </li>
                @else
                @endif
            </ul>
        </div>
        @endif
    </div>
</div>
<!-- Left Sidebar End -->
