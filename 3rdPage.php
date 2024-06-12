<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3rd Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: "Special Elite", system-ui;
        overflow: hidden;
    }

    .third-container {
        max-width: 600px;
        margin: 200px auto;
        padding: 50px;
        letter-spacing: 2pt;
        background-image: linear-gradient(to left, rgba(168, 202, 186), rgb(93,65,87));
        border-radius: 20px;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li:hover {
        background-color: #f0f0f0;
    }

    #postDetails h1 {     
       text-shadow: 2px 2px #756b6b;
    }

    .back-video{
        left: 0;
        top: 0;
        position: absolute;   
        z-index: -1;
    }

    a {
        text-decoration: none;
        padding-left: 5px;
        color: #101010;
    }

    #back{
        font-family: "Special Elite", system-ui;
        font-size: medium;
        
        padding: 10px;
        color: #101010;
        border-radius: 15px;
        background: rgb(230, 228, 225);
        transition: all 0.2s ease;

        width: 50px;
    }

    #back:hover {
        background-color: #c0c0c0;
        color: #101010;
        border-radius: 6px;
        background: rgb(230, 228, 225);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    #back:active{
        transform: scale(0.96)
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
</style>
<body>
    <div>
        <video autoplay loop muted plays-inline class="back-video">
            <source src="3rd_Page.mp4" type="video/mp4">
        </video>

        <div id="back">
            <a href="2ndPage.php">Back</a>
        </div>

        <div class="third-container">
            <div id="Details">
                
                <?php
                    //PHP Logic 
                    require 'config.php';

                    if (!isset($_SESSION['id'])) {
                        header("Location: 1stPage.php");
                        exit;
                    }

                    $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
                    $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]; //handling error

                    try {
                        $pdo = new PDO($dsn, $user, $password, $options);

                        if ($pdo) {
                        if (isset($_GET['id'])) { 
                            $id = $_GET['id'];

                            $sql_query = "SELECT * FROM `posts` WHERE id = :id"; //sql commands
                            $stm = $pdo->prepare($sql_query); //call pdo object, pass the query, extends the method of prepare
                            $stm->execute([':id' => $id]); //execute sql syntax
    
                            $post = $stm->fetch(PDO::FETCH_ASSOC);
    
                            if ($post) {
                                echo '<h2>Title: ' . $post['title'] . '</h2>';
                                echo '<p><i>Overview: </i>' . $post['body'] . '...</p>';
                            } else {
                                echo "No book found with the ID of {$id}.";
                            }
                        } else {
                            echo "No book ID provided!";
                        }
                        
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                    ?>
            </div>
        </div>
    </div>   
</body>
</html>