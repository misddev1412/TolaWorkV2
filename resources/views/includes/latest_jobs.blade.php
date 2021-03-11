<div class="section">
    <div class="container"> 
        <!-- title start -->
        <div class="titleTop">
            <h3>{{__('Latest')}} <span>{{__('Jobs')}}</span></h3>
        </div>
        <!-- title end -->

        <ul class="jobslist newjbox row">
            @if(isset($latestJobs) && count($latestJobs))
            @foreach($latestJobs as $latestJob)
            <?php $company = $latestJob->getCompany(); ?>
            @if(null !== $company)
            <!--Job start-->
            <li class="col-md-4">
                <div class="jobint">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <a href="{{route('job.detail', [$latestJob->slug])}}" title="{{$latestJob->title}}">
                                {{$company->printCompanyImage()}}
                            </a>
                        </div>
                        <div class="col-md-9 col-sm-9">
                            <h4><a href="{{route('job.detail', [$latestJob->slug])}}" title="{{$latestJob->title}}">{{$latestJob->title}}</a></h4>
                            <div class="company"><a href="{{route('company.detail', $company->slug)}}" title="{{$company->name}}">{{$company->name}}</a> - <span>{{$latestJob->getCity('city')}}</span></div>
                            <div class="jobloc">
                                <label class="fulltime" title="{{$latestJob->getJobType('job_type')}}">{{$latestJob->getJobType('job_type')}}</label> </div>
                        </div>                       
                    </div>
                </div>
            </li>
            <!--Job end--> 
            @endif
            @endforeach
            @endif
        </ul>
        <!--view button-->
        <div class="viewallbtn"><a href="{{route('job.list')}}">{{__('View All Latest Jobs')}}</a></div>
        <!--view button end--> 
    </div>
</div>