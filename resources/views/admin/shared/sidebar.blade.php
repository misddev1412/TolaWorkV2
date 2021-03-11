<!-- BEGIN SIDEBAR -->
<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
    <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
    <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
    <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <ul class="page-sidebar-menu page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
        <li class="sidebar-toggler-wrapper hide">
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler"> </div>
            <!-- END SIDEBAR TOGGLER BUTTON -->
        </li>
        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
        <li class="sidebar-search-wrapper">
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        <li class="nav-item start active"> <a href="{{ route('admin.home') }}" class="nav-link"> <i class="icon-home"></i> <span class="title">Dashboard</span> </a> </li>
        @include('admin/shared/side_bars/admin_user')

        <li class="heading">
            <h3 class="uppercase">Modules</h3>
        </li>
        @include('admin/shared/side_bars/job')
        @include('admin/shared/side_bars/company')
        @include('admin/shared/side_bars/site_user')
        @include('admin/shared/side_bars/cms')
        @include('admin/shared/side_bars/blogs')
        @include('admin/shared/side_bars/seo')
        @include('admin/shared/side_bars/faq')
        @include('admin/shared/side_bars/video')
        @include('admin/shared/side_bars/testimonial')
        @include('admin/shared/side_bars/slider')
		
		
		@if(APAuthHelp::check(['SUP_ADM']))
        <li class="heading">
            <h3 class="uppercase">Translation</h3>
        </li>		
        @include('admin/shared/side_bars/language')




        <li class="heading">
            <h3 class="uppercase">Manage Location</h3>
        </li>
        @include('admin/shared/side_bars/country')
        @include('admin/shared/side_bars/country_detail')
        @include('admin/shared/side_bars/state')
        @include('admin/shared/side_bars/city')

		
        <li class="heading">
            <h3 class="uppercase">User Packages</h3>
        </li>
        @include('admin/shared/side_bars/package')

		
		
        <li class="heading">
            <h3 class="uppercase">Job Attributes</h3>
        </li>
        @include('admin/shared/side_bars/language_level')
        @include('admin/shared/side_bars/career_level')
        @include('admin/shared/side_bars/functional_area')
        @include('admin/shared/side_bars/gender') 
        @include('admin/shared/side_bars/industry') 
        @include('admin/shared/side_bars/job_experience') 
        @include('admin/shared/side_bars/job_skill') 
        @include('admin/shared/side_bars/job_type') 
        @include('admin/shared/side_bars/job_shift') 
        @include('admin/shared/side_bars/degree_level') 
        @include('admin/shared/side_bars/degree_type') 
        @include('admin/shared/side_bars/major_subject')  
        @include('admin/shared/side_bars/result_type')
        @include('admin/shared/side_bars/marital_status')
        @include('admin/shared/side_bars/ownership_type') 
        @include('admin/shared/side_bars/salary_period') 
		
        <li class="heading">
            <h3 class="uppercase">Manage</h3>
        </li>		 
        @include('admin/shared/side_bars/site_setting')   
		@endif
		
		
		
    </ul>
    <!-- END SIDEBAR MENU -->
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->