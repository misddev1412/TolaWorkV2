@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('About Us')])
<!-- Inner Page Title end -->
<div class="about-wraper"> 
    <!-- About -->
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h2>Our Perfect Platform</h2>
                <p>Doctus omnesque duo ne, cu vel offendit erroribus. Laudem hendrerit pro ex, cum postea delectus ad. Te pro feugiat perpetua tractatos. Nam movet omnes id, usu te meis corpora. Augue doming quaestio vix at. Sumo duis ea sed, ut vix euismod lobortis prodesset, everti necessitatibus mei cu.<br>
                    <br>
                    Nam ea eripuit assueverit, invenire delicatissimi ad pro, an dicam principes duo. Paulo prodesset duo ad. Duo eu summo verear. Natum gubergren definitionem id usu, graeco cetero ius ut.<br>
                    <br>
                    Unum postea sit an, iudico invenire expetenda ei sea, atqui fierent sed ut. Ex pri numquam indoctum suavitate, sed id movet mentitum consequat, cum et amet ipsum dolor. Unum postea sit an, iudico invenire expetenda ei sea, atqui fierent sed ut.</p>
            </div>
            <div class="col-md-5">
                <div class="postimg"><img src="images/about-us-img1.jpg" alt="your alt text" /></div>
            </div>
        </div>
    </div>

    <!-- Process -->
    <div class="what_we_do">
        <div class="container">
            <div class="main-heading">Our process is simple</div>
            <div class="whatText">Diam velit voluptatibus has te. Verear aliquid mentitum nam no</div>
            <ul class="row whatList">
                <li class="col-md-4 col-sm-6">
                    <div class="iconWrap">
                        <div class="icon"><i class="fa fa-user" aria-hidden="true"></i></div>
                    </div>
                    <h3>Create Account</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque porttitor congue enim non rhoncus. Sed ac lacus non elit malesuada blandit.</p>
                </li>
                <li class="col-md-4 col-sm-6">
                    <div class="iconWrap">
                        <div class="icon"><i class="fa fa-file-text"></i></div>
                    </div>
                    <h3>Build CV</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque porttitor congue enim non rhoncus. Sed ac lacus non elit malesuada blandit.</p>
                </li>
                <li class="col-md-4 col-sm-6">
                    <div class="iconWrap">
                        <div class="icon"><i class="fa fa-briefcase" aria-hidden="true"></i></div>
                    </div>
                    <h3>Get Job</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque porttitor congue enim non rhoncus. Sed ac lacus non elit malesuada blandit.</p>
                </li>
            </ul>
        </div>
    </div>

    <!-- Text -->
    <div class="textrow">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="postimg"><img src="images/about-us-img2.jpg" alt="your alt text" /></div>
                </div>
                <div class="col-md-7">
                    <h2>Our Expertise</h2>
                    <p>Doctus omnesque duo ne, cu vel offendit erroribus. Laudem hendrerit pro ex, cum postea delectus ad. Te pro feugiat perpetua tractatos. Nam movet omnes id, usu te meis corpora. Augue doming quaestio vix at. Sumo duis ea sed, ut vix euismod lobortis prodesset, everti necessitatibus mei cu.<br>
                        <br>
                        Nam ea eripuit assueverit, invenire delicatissimi ad pro, an dicam principes duo. Paulo prodesset duo ad. Duo eu summo verear. Natum gubergren definitionem id usu, graeco cetero ius ut.</p>
                    <ul class="orderlist">
                        <li>Mauris convallis felis</li>
                        <li>Praesent vulputate diam</li>
                        <li>Vestibulum nec dui</li>
                        <li>Curabitur facilisis</li>
                        <li>Donec euismod urna</li>
                        <li>Mauris convallis felis</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
