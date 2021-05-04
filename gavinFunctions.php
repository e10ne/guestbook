<?php
    function session(){
        if (isset($_POST["reset"])){
            session_destroy();
            session_start();
        }
    }

    function loggedIn(){
        if (isset($_POST["username"]))
            $_SESSION["username"] = $_POST["username"];
    }

    function display($divName){
        if ($divName == "login")
            if (isset($_SESSION["username"]))
                echo "display:none;";
            else
                echo "display:inline-block";
        
        if ($divName == "form")
            if (isset($_SESSION["username"]))
                echo "display:inline-block";
            else
                echo "display:none;";
    }

    function isAdmin($user){
        if ($user == "Admin")
            return true;
        return false;
    }

    function noRemovebtn($content){
        return preg_replace('/ \| <form .*?<\/form>/', "", $content);
    }

    function poster($content){
        $newContent = "";
        $regex = '/<div id="\d+">' . $_SESSION["username"] . '/';
        preg_match_all('/<div.*?<\/div>/', $content, $matches);

        foreach ($matches[0] as $match){
            if (!preg_match($regex, $match))
                $match = preg_replace('/ \| <form action="guestbook.php" method="post"><button name="delete" value="\d+">delete<\/button><\/form><\/div>/', '</div>', $match);
            $newContent .= $match;
        }
        return $newContent;
    }

    function messagesPerPage($messages){
        $newContent = "";
        preg_match_all('/<div.*?<\/div>/', $messages, $matches);

        foreach ($matches[0] as $match) 
            if (array_search($match, $matches[0]) >= ($_GET["page"] - 1) * $_GET["amount"] && array_search($match, $matches[0]) < $_GET["page"] * $_GET["amount"])
                $newContent .= $match;
        return $newContent;
    }

    function gavinTest(){
        $messages = file_get_contents('messages.txt');
        if (isset($_GET["page"]))
            $messages = messagesPerPage($messages);
        if (isset($_SESSION["username"]))
            if (!isAdmin($_SESSION["username"]))
                $messages = poster($messages);
        if (!isset($_SESSION["username"]))
            $messages = noRemovebtn($messages);
        echo $messages;
    }

    if (isset($_POST["delete"]))
        delete($_POST["delete"]);

    function delete($id){
        $regex = '/<div id="' . $id . '".*?<\/div>/';
        $content = "";
        $file = file("messages.txt");

        for ($i = 0; $i < count($file); $i++)
            if (!preg_match($regex, $file[$i]))
                $content = $content . $file[$i];
        $messagesFile = fopen("messages.txt", "w");
        fwrite($messagesFile, $content);
        fclose($messagesFile);
    }

    function getHeighestID(){
        $textFile = fopen("messages.txt", "r");
        $id = 0;
        while(! feof($textFile))
            if (preg_match('/\d+/', fgets($textFile), $idFound))
                if ($idFound[0] > $id)
                    $id = $idFound[0];
        fclose($textFile);
        $id++;
        return $id;
    }
?>