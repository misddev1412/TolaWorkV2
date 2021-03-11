<li class="nav-item "><a href="javascript:;" class="nav-link nav-toggle"> <i class="fa fa-level-up" aria-hidden="true"></i> <span class="title">Manage Blogs</span> <span class="arrow"></span> </a>
    <ul class="sub-menu">
        <li class="nav-item  "> <a href="{{ route('blog') }}" class="nav-link "> <span class="title">List Blogs</span> </a> </li>
        <li class="nav-item  "> <a href="{{ route('add-new-blog') }}" class="nav-link "> <span class="title">Add Blog</span> </a> </li>
 	<li class="nav-item  "> <a href="{{ URL::asset('/admin/blog_category')}}" class="nav-link "> <span class="title">Categories</span> </a> </li>
    </ul>
</li>