<div class="section">
    <div class="container"> 
        <!-- title start -->
        <div class="titleTop">            
            <h3>{{__('Featured')}} <span>{{__('Companies')}}</span></h3>
        </div>
        <!-- title end -->

        <ul class="employerList owl-carousel">
            <!--employer-->
            @if(isset($topCompanyIds) && count($topCompanyIds))
            @foreach($topCompanyIds as $company_id_num_jobs)
            <?php
            $company = App\Company::where('id', '=', $company_id_num_jobs->company_id)->active()->first();
            if (null !== $company) {
                ?>
                <li class="item" data-toggle="tooltip" data-placement="bottom" title="{{$company->name}}" data-original-title="{{$company->name}}">
					<div class="empint">
					<a href="{{route('company.detail', $company->slug)}}" title="{{$company->name}}">{{$company->printCompanyImage()}}</a>			
					
					</div>
			</li>
                <?php
            }
            ?>
            @endforeach
            @endif
        </ul>

    </div> 
	
	
	<div class="largebanner shadow3">
<div class="adin">
{!! $siteSetting->index_page_below_top_employes_ad !!}
</div>
<div class="clearfix"></div>
</div>

	
	
</div>


