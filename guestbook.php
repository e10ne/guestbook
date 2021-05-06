<?php
session_start();
?>
<html>
    <head>
        <title>Guest Book</title>
        <meta charset="UTF-8">
        <?php include "etienneFunctions.php" ?>
        <?php include "daanFunctions.php" ?>
        <?php include "gavinFunctions.php" ?>
       <link rel="stylesheet" href="styles.css">
    </head>
    <body>
    <?php session();?>
        <?php loggedIn();?>
        <div id="loginForm" style="<?php display("login")?>">
            <form action="guestbook.php" method="post">
                <label for="username">Username: </label><input type="text" name="username"><br>
                <label for="password">Password: </label><input type="password" name="password"><br>
                <input type="submit"><br>
            </form>
        </div>
        <div id="messageForm" style="<?php display("form")?>">
            <h1>Welkom in het gastenboek</h1>       
            <form action="guestbook.php" method="post">
                <label>Laat een bericht achter:</label><br>
                <input type="text" name="message"><br>
                <label>Link naar afbeelding:</label><br>
                <input type="text" name="image"><br>
                <input type="submit"><br>
            </form> 
        </div>
        <h2>Berichtenarchief:</h2>
        <?php
            pagination();
            messageBoard();
            gavinTest();
        ?>
        <form action="guestbook.php" method="post">
            <input type="hidden" name="reset">
            <button type="submit">Log-out</button>
        </form>
        <img src="https://sites.imsa.edu/acronym/files/2019/03/advertising-777x437.png" width="300" height="200">
    </body>
</html>