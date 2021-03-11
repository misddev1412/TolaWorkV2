<div class="top-menu">
    <ul class="nav navbar-nav pull-right">
        <!-- BEGIN USER LOGIN DROPDOWN --> 
        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
        <li class="dropdown dropdown-user"> <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> <span class="username username-hide-on-mobile"> {{ (null !== (Auth::user()) && isset(Auth::user()->name)) ? Auth::user()->name : '' }} </span> <i class="fa fa-angle-down"></i> </a>
            <ul class="dropdown-menu dropdown-menu-default">
                <li> <a href="{{ route('admin.home') }}"> <i class="icon-user"></i> My Profile </a> </li>
                <li class="divider"> </li>
                <li> <a href="{{ route('admin.logout') }}"> <i class="icon-key"></i> Log Out </a> </li>
            </ul>
        </li>
        <!-- END USER LOGIN DROPDOWN -->
        <li class="dropdown dropdown-quick-sidebar-toggler">
            <a href="{{ route('admin.logout') }}" class="dropdown-toggle">
                <i class="icon-logout"></i>
            </a>
        </li>
    </ul>
</div>
