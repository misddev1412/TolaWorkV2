@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end -->
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Blog Detail')])
<!-- Inner Page Title end -->
@if(null!==($blog))


<div class="listpgWraper">
<section id="blog-content">
    <div class="container">
        <?php
        $cate_ids = explode(",", $blog->cate_id);
        $data = DB::table('blog_categories')->whereIn('id', $cate_ids)->get();
        $cate_array = array();
        foreach ($data as $cat) {
            $cate_array[] = "<a href='" . url('/blog/category/') . "/" . $cat->slug . "'>$cat->heading</a>";
        }
        ?>
        <!-- Blog start -->
        <div class="row">
       
            <div class="col-lg-9">
                <!-- Blog List start -->
                <div class="blogWraper">
                    <ul class="blogList">
                        <li>
                            <div class="bloginner">


                                <div class="postimg">{{$blog->printBlogImage()}}</div>


                                <div class="post-header">
                                    <h2>{{$blog->heading}}</h2>
                                    <div class="postmeta">Category : {!!implode(', ',$cate_array)!!}</div>
                                </div>
                                <p>{!! $blog->content !!}</p>


                            </div>
                        </li>

                    </ul>
                </div>


            </div>
			
			 <div class="col-lg-3">
				 
				 <div class="sidebar"> 
          <!-- Search -->
          <div class="widget">
            <h5 class="widget-title">Search</h5>
            <div class="search">
              <form action="{{route('blog-search')}}" method="GET">
                <input type="text" class="form-control" placeholder="Search" name="search">
                <button type="submit" class="btn"><i class="fa fa-search"></i></button>
              </form>
            </div>
          </div>
          <!-- Categories -->
          @if(null!==($categories))
          <div class="widget">
            <h5 class="widget-title">Categories</h5>
            <ul class="categories">
            @foreach($categories as $category)
              <li><a href="{{url('/blog/category/').'/'.$category->slug}}">{{$category->heading}}</a></li>
            @endforeach
            </ul>
          </div>
          @endif
        </div>
			</div>
			

        </div>
    </div>
</section>
</div>

@endif
@include('includes.footer')
@endsection
@push('styles')
<style>
.plus-minus-input {
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
}

.plus-minus-input .input-group-field {
    text-align: center;
    margin-left: 0.5rem;
    margin-right: 0.5rem;
    padding: 0rem;
}

.plus-minus-input .input-group-field::-webkit-inner-spin-button,
.plus-minus-input .input-group-field ::-webkit-outer-spin-button {
    -webkit-appearance: none;
    appearance: none;
}

.plus-minus-input .input-group-button .circle {
    border-radius: 50%;
    padding: 0.25em 0.8em;
}
</style>
@endpush
@push('scripts')
@include('includes.immediate_available_btn')
<script>
</script>
@endpush