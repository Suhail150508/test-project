<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <title> @yield('title') </title>
        <style>
            body {
                font-family: bangla;
                font-size: 13px;
                background-color:red;
            }

            @page {
                margin-top: 30px;
                header: page-header;
                footer: page-footer;
            }

            table th,table td{
                padding: 5px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            table, td, th {
                border: 1px solid #08010C;
            }

            .bb-none {
                border-bottom: 2px solid transparent;
            }

            .br-none {
                border-right: 2px solid #fff;
            }

            .bt-none {
                border-top: 2px solid #fff;
            }

            .bl-none {
                border-left: 2px solid #fff;
            }

            .tc {
                text-align: center;
            }

            .tr {
                text-align: right;
            }

            .fs {
                font-size: 12px;
            }

            .gtc {
                text-align: center; border-radius: 15px;
            }

            .sgtc{
                background-color:green;
                color:white;  font-size: 20px;
            }

            .page-break {
                page-break-after: always;
            }
        </style>
    </head>

    <body>
        <htmlpageheader name="page-header">
            @yield('header')
        </htmlpageheader>
        <br><br><br>

        @yield('content')

        <htmlpagefooter name="page-footer">
            @yield('footer')
        </htmlpagefooter>
    </body>
</html>
