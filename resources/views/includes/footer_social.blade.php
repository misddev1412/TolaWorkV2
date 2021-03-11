@if ((string)$siteSetting->facebook_address !== '')
<a href="{{ $siteSetting->facebook_address }}" target="_blank"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
@endif

@if ((string)$siteSetting->google_plus_address !== '')
<a href="{{ $siteSetting->google_plus_address }}" target="_blank"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a>
@endif

@if ((string)$siteSetting->pinterest_address !== '')
<a href="{{ $siteSetting->pinterest_address }}" target="_blank"><i class="fa fa-pinterest-square" aria-hidden="true"></i></a>
@endif

@if ((string)$siteSetting->twitter_address !== '')
<a href="{{ $siteSetting->twitter_address }}" target="_blank"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
@endif

@if ((string)$siteSetting->instagram_address !== '')
<a href="{{ $siteSetting->instagram_address }}" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
@endif

@if ((string)$siteSetting->linkedin_address !== '')
<a href="{{ $siteSetting->linkedin_address }}" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
@endif

@if ((string)$siteSetting->youtube_address !== '')
<a href="{{ $siteSetting->youtube_address }}" target="_blank"><i class="fa fa-youtube-square" aria-hidden="true"></i></a>
@endif

@if ((string)$siteSetting->tumblr_address !== '')
<a href="{{ $siteSetting->tumblr_address }}" target="_blank"><i class="fa fa-tumblr-square" aria-hidden="true"></i></a>
@endif

@if ((string)$siteSetting->flickr_address !== '')
<a href="{{ $siteSetting->flickr_address }}" target="_blank"><i class="fa fa-flickr-square" aria-hidden="true"></i></a>
@endif