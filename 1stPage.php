<?php

//PHP Logic

//establish connection of php and pdo

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; //handling error

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {

        if ($_SERVER['REQUEST_METHOD'] === "POST"){ 
            $name = $_POST['name']; //for submitting form
            $password = $_POST['password'];

            $sql_query = "SELECT * FROM `users` WHERE name = :name"; //parameter binding - , sql commands
            $stm = $pdo->prepare($sql_query); //call pdo object, pass the query, extends the method of prepare
            $stm->execute([':name' => $name]); //execute sql syntax, extend execute method, get the name placeholder value in the input type field
            
            $user = $stm->fetch(PDO::FETCH_ASSOC);

            //condition stored in $user, comparison of password
            if($user) {
                if ('anything' === $password) { 
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['username'] = $user['username'];

                    header('Location: 2ndPage.php'); //redirect to 2nd Page
                    exit;
                } else {
                    echo "Sorry, that is not the key!";
                }
            } else {
                echo "Sorry, can't find a publisher named {$name}!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1st page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
    <script src=”https://cdn.tailwindcss.com”></script>
</head>

<style>
    body{
        font-family: "Special Elite", system-ui;
        overflow: hidden;
    }

    input[type="text"], input[type="password"] {
        margin-bottom: 10px;
        font-size: medium;
        font-style: italic;
        max-width: 500px;
        padding: 10px;
        font-family: "Special Elite", system-ui;
    }

    #form{

        padding-bottom: 10px;
        padding-left: 40px;
    }

    .div-container{
        border-radius: 20%;
        width: 300px;
        height: 400px;
        background-image: linear-gradient(to left, rgba(168, 202, 186), rgb(93,65,87));
        padding-right: 20px;     
    }

    .whole{
        padding-left: 600px;
        padding-top: 100px;
        display: float;
    }
    
    h1{
        padding-top: 50px;
        padding-left: 80px;
        font-size: 50px;
        text-shadow: 2px 2px #756b6b;
    }

    .back-video{
        left: 0;
        top: 0;
        position: absolute;   
        z-index: -1;
    }

    @media(min-aspect-ratio: 16/9) {
        .back-video{
            width: 100%;
            height: auto;
        }
    }

    @media(max-aspect-ratio: 16/9) {
        .back-video{
            width: auto;
            height: 100%;
        }
    }

    #submit{
        font-family: "Special Elite", system-ui;
        font-size: medium;
        padding: 10px;

        color: #101010;
        padding: 8px 22px;
        border-radius: 15px;
        background: rgb(230, 228, 225);
        transition: all 0.2s ease;

        cursor: pointer;
    }

    button:active {
        transform: scale(0.96)
    }

    #name, #password {
        border-radius: 10px;
    }
</style>

<body>
    <div class="whole">
        <video autoplay loop muted plays-inline class="back-video">
            <source src="1st_Page.mp4" type="video/mp4">
        </video>
        <div class="div-container">  
            <h1>LogIn</h1>
            <form id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"> <!--redirect to itself-->
                <input type="text" id="name" placeholder="Pick a publisher..." name="name" required><br> <!--has the key-->
                <input type="password" id="password" placeholder="Enter the key..." name="password" required><br> <!--has the key-->
                <button id="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>