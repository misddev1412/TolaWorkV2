<div class="instoretxt">
    <div class="credit">{{__('Your Package is')}}: <strong>{{$package->package_title}} - ${{$package->package_price}}</strong></div>
    <div class="credit">{{__('Package Duration')}} : <strong>{{Auth::user()->package_start_date->format('d M, Y')}}</strong> - <strong>{{Auth::user()->package_end_date->format('d M, Y')}}</strong></div>
    <div class="credit">{{__('Availed quota')}} : <strong>{{Auth::user()->availed_jobs_quota}}</strong> / <strong>{{Auth::user()->jobs_quota}}</strong></div>

</div>
