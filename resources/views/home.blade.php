<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Devide Task</title>
</head>

<style>
    .header{
        width:100%;
        height:550px;
        background-image:url("{{ asset('images/header2.jpg') }}");
        background-repeat:no-repeat;
        background-position:center;
        background-size:cover;
        display:flex;
        justify-content:center;
        align-items:flex-end;
    }
    .greeting{
        font-size:40px;
        color:#FFFFFF;
        margin-bottom:50px;
        text-align:center;
    }
    /* about style */
    body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    }

    header {
        background: #007BFF;
        color: #fff;
        padding: 20px;
        text-align: center;
    }

    h1 {
        margin: 0;
    }

    #features {
        display: flex;
        justify-content: space-around;
        padding: 20px;
        background: #fff;
    }

    .feature {
        text-align: center;
        max-width: 300px;
    }

    .feature img {
        width: 100px;
        height: 100px;
    }

    #about {
        padding: 20px;
        background: #e9ecef;
        text-align: center;
    }

    #cta {
        padding: 20px;
        background: #007BFF;
        color: #fff;
        text-align: center;
    }

    .button {
        background: #fff;
        color: #007BFF;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
    }

    footer {
        text-align: center;
        padding: 10px;
        background: #333;
        color: #fff;
    }

</style>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">MyWebsite</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">Room</a>
                </li>
            </ul>
            <ul class="navbar-nav">
            @if(Auth::check())
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link" style="background:none; border:none; padding:0; margin-top:7px;">Logout</button>
                    </form>
                </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/finding"><button class="nav-link" style="background:none; border:none; padding:0;">Find your employer</button></a>
                    </li>    
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                @endif
               
            </ul>
        </div>
    </div>
</nav>

<!-- <img src="{{ asset('images/header2.jpg') }}" alt="Header image" class="header"> -->

<div class="header">
    <div class="greeting">
        Welcome our website 
        <p> Please register or login to create or take a task! </p>
    </div>
</div>
    <header>
        <h1>Welcome to Task Manager</h1>
        <p>Your go-to solution for creating and managing tasks efficiently!</p>
    </header>

    <section id="features">
        <h2>Features</h2>
        <div class="feature">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMwAAADACAMAAAB/Pny7AAAA6lBMVEX////59/gAAADorYzssI7v7e/SnH7hmXTY2NjF091bRDflnHbKiWjinXlSPTJPNSkdHR3Hxsa/vb8YEQ6SbVh8e3xGRkY0JyC2iG5XV1e2xM9FMimPjo+bmps3Nja4trjlyvNiYWKMlp1xb3AnJydBRkoMDAzj4uIVFRUuLi6joqPbte+Eg4Tu5OE/Pz/qtJVvU0PEkneofWWAX01MQlBXTFy9ms/OqOMrHxqea1JZPC16g4r68OwlISismLfMtNjDqNJZR2Onh7g1KzpxZHiWhaBlU2+Gdo7gwPFKPFF8ZYiXe6UWEhlqRzftn/8PAAAKoElEQVR4nO2dfWObuhXGBbYS3bbpDCk01GDChSFMPJYmzW26LU3X3ubeNd33/zoDSYgXExuwQTjj+ctvCP2sI3F0jgQAdCJDTvTrLwW9e/ful1/JF0Y3Z+1II0xPghghpYGQvhlGb1YawnBvKNheOYbeSMFmmKBZaYazsvFeUKDtLH25lZ6EaSx/6djSHlhWy3bn3ytMLE/b2dag27JV9g4jy+6ONNJqh5PvG0Ze7WZpdsDKuZ030ulmmNM2pcXjhr0LC6TXC/n1m6Nmmm+GmTcq7NWrT69pPYxdDM2mZVweTaeTJpq+3gzzuklx05OXL1/9g9Zkl6YxSQkvjpqh7BlmcnJ8fMxozPYsMCLd5aohyr5hJjHM8SfScfT2dobJsDx/37RhOoB5+Yp0Q7+9I4DomRtb2b5hThKYv5Aj0V5hprW0FaaWOoaZTt6f1dG2oblWIe8n0w5hptOry/nbOvI3w/i1CplfXtHW6QJmOrlOr8X1tLM7c3pNGqcDmJilUU324ptdd9Qy07O3/cO8PZt2AnPU0Mj2AnN6fdQFzPToBXmrGzU02wwzq1MGcT+IL9UZTGBjtFV4W0CjRhkoDDqHmSmgxhRpx1CTJEEoqbNeYLZqO8yWAmCswcO8++cBwjjkyOVf10RDPc5BwZhVw2wm86Bg0GYYdEgw0uYQ1Wrr4cOCwc6TwUPfwQcGA6BlLLwKLQwLbi9hWDDxhRWrdoVUDGoUMDAYwlOlWocOD2YHjTAjzAjzfw5DU9aXzwNGCpez0xdnnURneoeJDc18Q6Ka/cAUfl2sztoH+SOe+GX2OYWBf/t7RxHNKhgl56egQgVh6YO0tij2cVSUq7YEVZvOCABU+CEcpqNYcwWMFflcgR7mao3cWaDbZRaoaoYXBEtjZXMcvFoGhpqwIFc3TCwKRpELWihZtcm0eVnqXtDk6yM8LW0EK3lr4LjNyOBlCYIBVhHGt7g1qTTjbhYbxsxPcUhrxLXWCLYKFBpqM6AgmLAIM+N2Blz6iV6YHpca0iUWBV0Ko7BGEwUjQb2idsT6I9ZW+V7DIjZcTg7Gcxfs07BgZv/qcTTDpqF7pNZL3bD4ZBhY6boONz9BpnxetPDWWobbnwlzMFLoXJ71NzSnHWGWdJesxdy0botseAbQpwYVT0G12KYiu/TbpJiUhXoASbzq7VWfMCsCkx+WgZrajOznhgAKE6wULAFFWyll8BjUgvzHsRRSTK++2TqMZAa8fkZmZyAdl91Qya76OZhFmEU6BHnNazAA5Xq6lw0BuSinYSrcnjKTtEvuzBBgJJuYx4zmm3gvkACOMkg9THt6CmMU/IWhwEAazHQ0Upf8pUbN0XiMksNoBfdzKDCIpjNslj2zcz9HuaCtR9uGw3jhEGFCal+6QYcBJ/dbIGGLX1IcVICJy8i70sOAgeWQOQYpCSSzGYVFoekxudEssAY3AKjllcMsFwOgFTk2TOZizKc0SzDxpRcODKbkSsedgTVM4h4HZL5CXrKBruABeBYcFAwuOp+JyAEAkxYLHMtWLeohWFnLBEGJZhgwJT8/kUtgEDM/f8mcnUjNYJZalFraAGD4vIxajW6Fiehq9QVxaVgCOseYn8/Yisc+RiJhzCIMrRFbsUtnwjObNk3RAHU206TzGRukAwcdoMXAAHLhmHFfhNjQMnUvSU/36BEFn03m0Q7yk0iJx7gF+x8EwpA/PMtSkmXdvAcRB8ZJf4pDtkAonlny4Afx5FZJvycjNrVJYbFmRXNW2RwMhq4bcjSoxl/i7ABsm67jaKaaO952HTZJRabLpzmCYADEUumj/Jew4EDGb3DiCJSO5/BpSYeSBah1+KHA1NIIM8KUz0x++yxggIQURVWUDUPaocDEv7EcPYoi3bFK+Zh4MoZzgvXEmlgETDzj0tlFXZ7pYaFx0MrJL+x16knDwtwZrOWzFL6WRfEALsXJ68oTBbM233ezNivlO+qLeJoCYNamyDKPSbSHMcXAYHb6uw83H+6ovQU8FqMsyrWsKSwEBjAju/l8f3//+eYnebPiqKERLZpLFzQ5A4zl/jzRl3+Td3oWLUKVKwE3S0VZGrBXGGpld18Iy/mfX78lb5fqbtdOQVMAtlf4d9ow5xcfSdMUgqzt1TsMHa++M5aLjw+HD/MHNbJDh6Hxvg/3lOXit/8kbz37IGHSGNl3gnLx8Qd5F2XJpbpnGQQMYFG9Hx8zlmwzCUBuVOMuLJGjDAMmjSvf/Xj88Y2+9LmV4XI49iktqmj6N7NCOqLcMPV9s6o9GwIcTVT+9yN8uDCSUqTRc5d/JZLrKQgHAiMp2ozXaqYVrN82FsutfuVykVtAJBpGwjbrOEEuxEzrg9Q6QlCqkKhQE1ZUywxVZft2pQYag4AjzAgzwowwI8wIM8L0nTl7JjAAQKQguF8eQctNYKgvvSDwjLC8mbzdOQXCQDtbxRgVdzJBq86dcsoKBcWapWSbRrZSXmbredKvWmbODFEwuJw5y/YxtE82qYIyZ+GsXJOwRUCjJEtQ5oz1l583v9/c0ZcLvrtJ9cq1rCkkxMzSbRcsc0bf8DvKwLDVrZE9axCZMxI3Z/2X1KfRrb/5LcDFDM3sW//zXjNn6T8hKHPGWJ5T5uzPA0825TNnB58GVMm3JHN2fvCZMyindkYzZ2RVQy5zVlyi9ZSq73XU/9BM4/yz7zRzRtNN2W3YkKW5NWQOI3MmUTuT5YfHx8cH+tLnIzNaz0RVSx9I5ow7xj/TF20yZ+YgYCSlvPNnwXtM+WYBGzSUzJldXIeVy7UCpa5rlt0TQTBMsW2MgvXXtTNtMJkzAK3U1ffCUg4MIkQG382eZXWOSlB0BgDbNXRDU9bDM/VOMiQYXufKSrXVGNEcYUaYEWaEGWFGmAOAAXvdoyUQBkjJTf73u+VMFAxWLCNK7sK81zVagjJnfOrsu2qhPji0Wkho5iw/n1zkZzR4VUiq1ZXvCttzZhazTdkNG9JIdAspgjJndvnPD+wW0ZmSQjEwcD05tshappWVyeyZAcIyZ/L38/v7P9jr7FkMLR9euRKaOftG0wBfaHg2e+QHQJbZXCzw1nsWgO1sTPecPZIc7SKzwnbnFHOdqd5zdqApDRaAfSaZMwrzTPac0YzGzfPYc8YyZ58py8Va5qzuWQYBA2gK4O4ryQI+0hxNlqCBVq27GbjD2HKSul8/H77+9vWBsmR7zir2cD0ht4JGgDuzfpe5qI1vVjFmiMicre35R4cLI9nF9NgsG8qAurYW7UlVDIBCZpp2fgednq8VNGvmAZdmxUYtMTEAZOrshhO6WXrgl1pvoqxWbToTtBRYUsKV67hmchPmYoXqnqWCReQibbJq5DmEmrrRCDPCjDAjzAgzwjwDGF9tXVwDJUCq3zmMbGg9iTrkHcFMrp98Emt38q8nXcBMple3/cPcXk27eP5MbGeX/cMkj5/pAob3mh71gpy7C5iY5np+e9qbbufX9NSdwMR98ejsTW86O5rQM3cDk/D0qPScncGI0B5h5u9FwxwnMPMdYTCJWN5eCWZJYI4/kYvcAreGoY9TkC8nYpsmsbLj/5KqaC0zpYlowPj0jViak5jlE3WlwvYsIH2aTHzt2jbiJOpmTDt5mfZ+Wd9sZf8DZFaN7qt65J0AAAAASUVORK5CYII=" alt="Task Icon">
            <h3>Create Tasks</h3>
            <p>Easily create tasks with deadlines, priority levels, and descriptions to stay organized.</p>
        </div>
        <div class="feature">
            <img src="https://cdn-icons-png.flaticon.com/128/4285/4285662.png" alt="Reminder Icon">
            <h3>Set Reminders</h3>
            <p>Never miss a deadline again! Set reminders to keep you on track.</p>
        </div>
        <div class="feature">
            <img src="https://cdn-icons-png.flaticon.com/128/11314/11314901.png" alt="Collaboration Icon">
            <h3>Collaborate with Teams</h3>
            <p>Invite team members to work together on tasks and projects for seamless collaboration.</p>
        </div>
    </section>

    <section id="about">
        <h2>About Us</h2>
        <p>At Task Manager, we believe that effective task management is key to productivity. Our platform is designed to help individuals and teams streamline their workflows, stay organized, and achieve their goals.</p>
    </section>

    <section id="cta">
        <h2>Get Started Today!</h2>
        <p>Join our community of productive users. Sign up now and take control of your tasks!</p>
        <a href="{{ route('register') }}" class="button">Sign Up</a>
    </section>

    <footer>
        <p>&copy; 2024 Task Manager. All rights reserved.</p>
    </footer>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>