@extends('admin.layouts.email_template')
@section('content')
<table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width: 100%;    border-bottom: solid 1px #ccc;">
    <tr>
        <td class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
            <div class="title" style="font-family: Helvetica, Arial, sans-serif; font-size: 18px;font-weight:400;color: #000;text-align: left;
                 padding-top: 20px;">{{ $subject }}</div></td>
    </tr>
    <tr>
        <td class="cols-wrapper" style="padding-left:12px;padding-right:12px"><!--[if mso]>
         <table border="0" width="576" cellpadding="0" cellspacing="0" style="width: 576px;">
            <tr>
               <td width="192" style="width: 192px;" valign="top">
                  <![endif]--> 

            <?php if(null!==($jobs)){?> 
            <?php foreach ($jobs as $key => $job) {?>
            <?php $company = $job->getCompany(); ?> 
            <?php if(isset($company)){?>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tbody><tr>
                <td>    
                <a href="{{route('job.detail', $job->slug)}}" style="text-decoration:none;font:bold 16px/20px HelveticaNeue,Helvetica,Arial,sans-serif;color:#00c;padding:0 0 5px" target="_blank" data-saferedirecturl="https://www.google.com/url?q={{route('job.detail', $job->slug)}}">{{$job->title}}</a>

                </td>
                </tr>
                <tr>
                <td style="font:15px/18px HelveticaNeue,Helvetica,Arial,sans-serif;color:#6f6f6f;padding:0 0 4px">
                <span style="color:#000">
                {{$company->name}}

                </span>
                <span>
                {{$company->location}}

                </span>
                </td>
                </tr>
                <tr>
                <td class="m_-2367700890496463653job-info-snippet" style="font:13px/18px HelveticaNeue,Helvetica,Arial,sans-serif;color:#000;padding:0 0 3px">
                </td>
                </tr>
                <tr>
                <td style="font:13px/18px HelveticaNeue,Helvetica,Arial,sans-serif;color:#999">
                {{ \Carbon\Carbon::parse($job->created_at)->diffForHumans()}}
                </td>
                </tr>
                <tr>
                <td style="font:13px/18px HelveticaNeue,Helvetica,Arial,sans-serif;color:#cd29c0">
                </td>
                </tr>
                </tbody></table> 
                <?php } ?>     
                <?php } ?>     
                <?php } ?>     
            <!--[if mso]>
               </td>
            </tr>
         </table>
         <![endif]--></td>
    </tr>
</table>
@endsection