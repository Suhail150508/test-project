<!DOCTYPE html>
<html>
<head>
    <style>
        .container {
            width: 500px;
            margin: auto;
            text-align: center;
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #000;
            font-size: 28px;
            margin-top: 50px;
        }
        p {
            color: #333;
            font-size: 16px;
            margin: 20px 0;
            line-height: 1.5;
        }
        .btn {
            background-color: #5e72e4;
            color: #fff;
            padding: 2px 4px;
            border-radius: 4px;
            text-decoration: none;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>
<div class="container">

    <h1>{{$data['mail_subject']}}</h1>

    <p>{!! $data['mail_body'] !!}</p>
</div>
</body>
</html>
