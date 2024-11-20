<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        img, video {
            width: 100%;
            max-width: 800px;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .description {
            margin: 20px 0;
            font-size: 1.1em;
            color: #333;
        }

        .button-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 20px 0;
        }

        .button-group a {
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;
            color: #fff;
            transition: background-color 0.3s;
        }

        .button-group a.accept {
            background-color: #28a745;
        }

        .button-group a.accept:hover {
            background-color: #218838;
        }

        .button-group a.cancel {
            background-color: #dc3545;
        }

        .button-group a.cancel:hover {
            background-color: #c82333;
        }

        @media (max-width: 600px) {
            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        @if($donetask->file_type == 'image/jpeg')
            <img src="{{ asset('storage/' . $donetask->file_path) }}" alt="Image">
        @elseif($donetask->file_type == 'video/mp4')
            <video controls>
                <source src="{{ asset('storage/' . $donetask->file_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @else
            <a href="{{ asset('storage/' . $donetask->file_path) }}" download="{{$donetask->file_path}}">Download to see</a>
        @endif

        <div class="description">
            <p>{{ $donetask->description }}</p>
        </div>
        
        <div class="button-group">
            <a href="/acceptdonetask/{{$donetask->id}}" class="accept">Accept</a>
            <a href="/rejecttask/{{$donetask->id}}" class="cancel">Cancel</a>
        </div>
    </div>
</body>
</html>