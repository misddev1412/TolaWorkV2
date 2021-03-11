<div class="section greybg">

  <div class="container"> 

    <!-- title start -->

    <div class="titleTop">

      <div class="subtitle">{{__('Here You Can See')}}</div>

      <h3>{{__('Featured')}} <span>{{__('Jobs')}}</span></h3>

    </div>

    <!-- title end --> 

    

    <!--Featured Job start-->

    <ul class="jobslist row">

    @if(isset($featuredJobs) && count($featuredJobs))

      @foreach($featuredJobs as $featuredJob)

      <?php $company = $featuredJob->getCompany();?>

      @if(null !== $company)

      <!--Job start-->

      <li class="col-md-6">

        <div class="jobint">

          <div class="row">

            <div class="col-md-2 col-sm-2">

            <a href="{{route('job.detail', [$featuredJob->slug])}}" title="{{$featuredJob->title}}">

            {{$company->printCompanyImage()}}

            </a>

            </div>

            <div class="col-md-7 col-sm-7">

              <h4><a href="{{route('job.detail', [$featuredJob->slug])}}" title="{{$featuredJob->title}}">{{$featuredJob->title}}</a></h4>

              <div class="company"><a href="{{route('company.detail', $company->slug)}}" title="{{$company->name}}">{{$company->name}}</a></div>

              <div class="jobloc">

              <label class="fulltime" title="{{$featuredJob->getJobType('job_type')}}">{{$featuredJob->getJobType('job_type')}}</label> - <span>{{$featuredJob->getCity('city')}}</span></div>

            </div>

            <div class="col-md-3 col-sm-3"><a href="{{route('job.detail', [$featuredJob->slug])}}" class="applybtn">{{__('View Detail')}}</a></div>

          </div>

        </div>

      </li>

      <!--Job end--> 

      @endif

      @endforeach

      @endif

      

    </ul>

    <!--Featured Job end--> 

    

    <!--button start-->

    <div class="viewallbtn"><a href="{{route('job.list', ['is_featured'=>1])}}">{{__('View All Featured Jobs')}}</a></div>

    <!--button end--> 

  </div>

</div>