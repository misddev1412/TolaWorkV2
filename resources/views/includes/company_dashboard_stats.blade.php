<ul class="row profilestat">
          <li class="col-md-2 col-sm-4 col-xs-6">
            <div class="inbox"> <i class="fa fa-clock-o" aria-hidden="true"></i>
              <h6><a href="{{route('posted.jobs')}}">{{Auth::guard('company')->user()->countOpenJobs()}}</a></h6>
              <strong>{{__('Open Jobs')}}</strong> </div>
          </li>
          <li class="col-md-2 col-sm-4 col-xs-6">
            <div class="inbox"> <i class="fa fa-user-o" aria-hidden="true"></i>
              <h6><a href="{{route('company.followers')}}">{{Auth::guard('company')->user()->countFollowers()}}</a></h6>
              <strong>{{__('Followers')}}</strong> </div>
          </li>
          <li class="col-md-2 col-sm-4 col-xs-6">
            <div class="inbox"> <i class="fa fa-envelope-o" aria-hidden="true"></i>
              <h6><a href="{{route('company.messages')}}">{{Auth::guard('company')->user()->countCompanyMessages()}}</a></h6>
              <strong>{{__('Messages')}}</strong> </div>
          </li>
        </ul>