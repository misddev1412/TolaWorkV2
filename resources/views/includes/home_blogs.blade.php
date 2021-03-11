<div class="section">
    <div class="container"> 
        <!-- title start -->
        <div class="titleTop">
            <div class="subtitle">{{__('Here You Can See')}}</div>
            <h3>{{__('Latest')}} <span>{{__('Blogs')}}</span></h3>
        </div>
        <!-- title end -->

        <ul class="jobslist row">
           @if(null!==($blogs))
                        <?php
                        $count = 1;
                        ?>
                        @foreach($blogs as $blog)
                        <?php
                        $cate_ids = explode(",", $blog->cate_id);
                        $data = DB::table('blog_categories')->whereIn('id', $cate_ids)->get();
                        $cate_array = array();
                        foreach ($data as $cat) {
                            $cate_array[] = "<a href='" . url('/blog/category/') . "/" . $cat->slug . "'>$cat->heading</a>";
                        }
                        ?>
                        <li class="col-lg-4">
                            <div class="bloginner">
                                <div class="postimg">
									@if(null!==($blog->image) && $blog->image!="")

									<img src="{{asset('uploads/blogs/'.$blog->image)}}"
                                        alt="{{$blog->heading}}">
									@else
									<img src="{{asset('images/blog/1.jpg')}}"
                                        alt="{{$blog->heading}}">
									@endif
								</div>

                                <div class="post-header">
                                    <h4><a href="{{route('blog-detail',$blog->slug)}}">{{$blog->heading}}</a></h4>
                                    <div class="postmeta">Category : {!!implode(', ',$cate_array)!!}
                                    </div>
                                </div>
                                <p>{!! \Illuminate\Support\Str::limit($blog->content, $limit = 150, $end = '...') !!}</p>

                            </div>
                        </li>

                        
                        <?php $count++; ?>
                        @endforeach
                        @endif
        </ul>
        <!--view button-->
        <div class="viewallbtn"><a href="{{route('blogs')}}">{{__('View All Blog Posts')}}</a></div>
        <!--view button end--> 
    </div>
</div>