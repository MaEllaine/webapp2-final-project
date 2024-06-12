<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2nd Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: "Special Elite", system-ui;
        overflow: hidden;
        }

    .post-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background-image: linear-gradient(to top, rgb(93,65,87),  rgba(168, 202, 186));
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        margin-bottom: 10px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        background-color: #f9f9ff;
        cursor: pointer;
        text-align: center;
        text-decoration: none;       
    }

    li:hover {
        background-color: #c0c0c0;
        color: #101010;
        border-radius: 6px;
        background: rgb(230, 228, 225);
        transition: all 0.2s ease;
    }

    li:active{
        transform: scale(0.96)
    }

    h1{
        text-align: center;
        text-shadow: 2px 2px #756b6b;
    }

    .back-video{
        left: 0;
        top: 0;
        position: absolute;   
        z-index: -1;
        position: fixed;
    }

    a {
        text-decoration: none;
        padding: 7px;
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
            <source src="2nd_Page.mp4" type="video/mp4">
        </video>

        <div id="back">
            <a href="1stPage.php">Back</a>
        </div>

        <div class="post-container">
            <h1>Published Books</h1>
            <ul id="postLists">

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
                        $user_id = $_SESSION['id'];

                        $sql_query = "SELECT * FROM `posts` WHERE userID = :ID"; //sql commands
                        $stm = $pdo->prepare($sql_query); //call pdo object, pass the query, extends the method of prepare
                        $stm->execute([':ID' => $user_id]); //execute sql syntax
                            
                        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) { //iterate individually until the record finishes
                            echo '<li data-id="' . $row['id'] . '"> Book ID No. ' . $row['id'] . '</li>';
                        } 
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>

            </ul>
        </div>
    </div>
</body>

<script>
    // Redirect to 3rd.php with the ID of the clicked post
document.addEventListener("DOMContentLoaded", function() {
    const postLists = document.getElementById("postLists");
    postLists.addEventListener("click", function (event) {
        if (event.target.tagName === "LI") {
            const id = event.target.getAttribute("data-id");
            window.location.href = `3rdPage.php?id=${id}`;
        }
    });
});
</script>

</html>