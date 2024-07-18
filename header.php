<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/form.css">
    <title>Simple Header Example</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        nav {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
        }
        nav a:hover {
            background-color: #45a049;
        }
        main {
            flex: 1;
            padding: 20px;
            text-align: center;
        }
        footer {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        footer a {
            color: #4CAF50;
            text-decoration: none;
            padding: 0 10px;
        }
        footer a:hover {
            color: #45a049;
        }
    </style>
</head>
<body>

<header>
<?php
$current_page = basename($_SERVER['PHP_SELF']);

if ($current_page == "about.php") {
    echo "<h1>My About</h1>";
} elseif ($current_page == "index.php") {
    echo "<h1>My Index</h1>";
}
?>

    
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="index.php?page=register">Register</a>
        <a href="index.php?page=login">Login</a>
    </nav>
</header>

</body>
</html>
