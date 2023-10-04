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

    <h1>{{$data['subject']}}</h1>

    <p>{{$data['body']}}</p>

    <table class="table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Attachment</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['resumes'] as $key=>$attachment)
                {{-- <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        @php
                            $segments = explode('.', $attachment);
                            $fileName = $segments[count($segments) - 2] . '.' . end($segments);
                        @endphp
                        <a href="{{$attachment}}" target="_blank" class="btn btn-primary btn-sm">{{$fileName}}</a>
                    </td>
                </tr> --}}

                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        <a href="{{$attachment}}" target="_blank" class="btn btn-primary btn-sm">View Resume</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
