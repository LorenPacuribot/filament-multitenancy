<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: linear-gradient(to left,  #ffcccc, #ff99cc, #ff66cc, #ff33cc, #ff00cc, #ff00b3, #ff0099, #ff007f, #ff0066);
            /* Set the height of the body to fill the viewport */
            height: 100vh;
            /* Remove any default margin */
            margin: 0;
            /* Center content */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }
        /* Style for logo */
        .logo {
            width: 200px; /* Adjust width as needed */
            height: auto;
        }
        /* Style for login button container */
        .btn-container {
            display: flex;
            justify-content: center;
        }
        /* Style for login button */
        .login-btn {
            margin: 20px;
            padding: 10px 20px;
            background-color: #000000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
            text-decoration: none; /* Remove default anchor underline */
        }
        /* Style for login button hover */
        .login-btn:hover {
            background-color: #0056b3; /* Darker shade of blue */
        }
        /* Style for header */
        h2 {
            font-weight: bold; /* Make the header bold */
            color: #fff; /* Text color */
        }
    </style>
</head>
<body>
    <!-- Your logo here -->
    <img src="images/logo-transparent.png" alt="anya" class="logo">

    <!-- Headings -->
    <br>
    <h2>Laravel - Multitenancy</h2>
    <h2>example template</h2>

    <!-- Login button container -->
    <div class="btn-container">
        <!-- Admin button -->
        <a href="{{ url('/admin') }}" class="login-btn">Admin</a>

        <!-- User button -->
        <a href="{{ url('/app') }}" class="login-btn">User</a>
    </div>
</body>
</html>
