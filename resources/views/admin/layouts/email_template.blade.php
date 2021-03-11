<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- So that mobile will display zoomed in -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- enable media queries for windows phone 8 -->
        <meta name="format-detection" content="telephone=no">
        <!-- disable auto telephone linking in iOS -->
        <title>{{ $siteSetting->site_name }}</title>
        <style type="text/css">
            body {
                margin: 0;
                padding: 0;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            table {
                border-spacing: 0;
            }
            table td {
                border-collapse: collapse;
            }
            .ExternalClass {
                width: 100%;
            }
            .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
                line-height: 100%;
            }
            .ReadMsgBody {
                width: 100%;
                background-color: #ebebeb;
            }
            table {
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }
            img {
                -ms-interpolation-mode: bicubic;
            }
            .yshortcuts a {
                border-bottom: none !important;
            }
            .soc {
                margin: 0px;
                padding: 0px;
                display: block;
                text-align: center;
            }
            .soc ul {
                margin: 0px;
                padding: 0px;
                float: left;
            }
            .soc ul li {
                list-style: none;
                float: left;
                margin: 0px 9px 0px 0px;
            }
            @media screen and (max-width: 599px) {
                .force-row, .container {
                    width: 100% !important;
                    max-width: 100% !important;
                }
            }
            @media screen and (max-width: 400px) {
                .container-padding {
                    padding-left: 12px !important;
                    padding-right: 12px !important;
                }
                .col img {
                    width: 100% !important;
                }
            }
            .ios-footer a {
                color: #aaaaaa !important;
                text-decoration: underline;
            }
            @media screen and (max-width: 599px) {
                .col {
                    width: 100% !important;
                    border-top: 1px solid #eee;
                    padding-bottom: 0 !important;
                }
                .cols-wrapper {
                    padding-top: 18px;
                }
                .img-wrapper {
                    float: right;
                    max-width: 40% !important;
                    height: auto !important;
                    margin-left: 12px;
                }
                .subtitle {
                    margin-top: 0 !important;
                }
            }
            @media screen and (max-width: 400px) {
                .cols-wrapper {
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }
                .content-wrapper {
                    padding-left: 12px !important;
                    padding-right: 12px !important;
                }
            }
        </style>
    </head>
    <body style="margin:0; padding:0;" bgcolor="#F0F0F0" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <!-- 100% background wrapper (grey background) -->
        <table border="0" width="80%" cellpadding="0" cellspacing="0" bgcolor="#24140e">
            <tr>
                <td align="center" valign="top" bgcolor="#24140e" style="background-color:#fff;"><!-- 600px container (white background) -->
                    <table border="0" cellpadding="0" cellspacing="0" class="container" style="width:100%;border: solid 1px #d6d4d4;">
                        <tr>
                            <td class="content" align="left" style="padding-top:0px;padding-bottom:12px;background-color:#f8f8f8;"><table border="0" cellpadding="0" cellspacing="0" class="force-row" style="width:100%;">
                                    <tr>
                                        <td align="center" valign="middle" class="content-wrapper" style="padding-left:24px;padding-right:24px"><br>
                                            <a href="{{ url('/login') }}"><img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" /></a></td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td class="content" align="left" style="padding-top:0px;padding-bottom:12px;background-color:#fff"> @yield('content') </td>
                        </tr>
                        <tr style="background-color: #fff;">
                            <td class="container-padding footer-text" align="left" style="font-family:Helvetica, Arial, sans-serif;font-size:12px;line-height:16px;color:#aaaaaa;padding: 20px 20px;"><div class="soc"> 
                                    @include('admin.layouts.email_template_social')
                                </div>
                                <br>
                                <span class="ios-footer" style=" text-align:center;display: block;"> © Copyright {{ date('Y')}} {{ $siteSetting->site_name }} - All Rights Reserved </span> <br>
                                <br></td>
                        </tr>
                    </table>
                    <!--/600px container --></td>
            </tr>
        </table>
        <!--/100% background wrapper-->
    </body>
</html>