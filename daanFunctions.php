<?php
    // Test afbeeldingen:
    // echo getImg("https://i.imgur.com/8G3NXcW.gif");
    // echo getImg("https://i.imgur.com/m6lSnfO.png");
    
    // Slaat berichten op in een variabel
    // Checkt of bericht geen code is
    // Vereist geen afbeelding als input
    // Slaat berichten in volgorde op
    // Geeft delete button weer
    function messageBoard() {
        if (isset($_POST["message"])) {
            $message = htmlspecialchars($_POST["message"]);
            $image = htmlspecialchars($_POST["image"]);
            $imagePost = "";
            if ($image != "") {
                $imagePost = getImg($image);
            }
            $post = '<div id="' . getHeighestID() . '">' . $_SESSION["username"] . ' | ' .  $message . $imagePost . ' | <form action="guestbook.php" method="post"><button name="delete" value="' . getHeighestID() . '">delete</button></form></div>' . "\r\n";
            $messageFile = fopen("messages.txt", "r");

            // Leest bericht
            $content = "";
            while(! feof($messageFile))
                $content .= fgets($messageFile);
            fclose($messageFile);

            // Slaat bericht op in nieuw bestand
            $archive = fopen("messages.txt", "w");
            fwrite($archive, $content . $post);
            fclose($archive);
        }
    }
?> 
