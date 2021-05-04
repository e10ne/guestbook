<?php
    // get external image gedeelte

    function checkImageExt(string $filePath) {
        
        // pakt de extentie uit de link
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        
        // switch case om te kijken of de extentie van een image type is
        switch($ext) {
            // nog andere extenties nodig?
            case "jpg":
            case "jpeg":
            case "png":
            case "gif":
            case "svg":
            case "webp":
                return true;
            default:
                return false;
        }
    }

    function getImg(string $location, int $imgWidth = 64, int $imgHeight = 64) {
        // default image
        $defautImage = "";

        // gooit parameters uit de link (alles vanaf ?) 
        $filteredLocation = preg_replace("/\?.*/", "", $location);

        if(checkImageExt($filteredLocation) === true) {
            return "<img src='" . htmlspecialchars($filteredLocation) . "' width='{$imgWidth}' height='{$imgHeight}'>";
        } else {
            return "<img src='" . htmlspecialchars($defautImage) . "' width='{$imgWidth}' height='{$imgHeight}'>";
        }
        
    }

    // || voorbeeldimages ||
    // echo getImg("https://ps.w.org/facebook-conversion-pixel/assets/icon-256x256.png?rev=2278926");
    // echo getImg("https://i.imgur.com/8G3NXcW.gif");
    // echo getImg("https://i.imgur.com/m6lSnfO.png");
    // echo getImg("https://images.all-free-download.com/images/graphicthumb/hd_pictures_of_animals_01_hd_picture_169003.jpg");
    // echo getImg("https://dev.w3.org/SVG/tools/svgweb/samples/svg-files/410.svg");
    // echo getImg("https://res.cloudinary.com/demo/image/upload/fl_awebp/bored_animation.webp");
    // echo getImg("https://i.guim.co.uk/img/media/26392d05302e02f7bf4eb143bb84c8097d09144b/446_167_3683_2210/master/3683.jpg?width=1200&height=1200&quality=85&auto=format&fit=crop&s=49ed3252c0b2ffb49cf8b508892e452d"); // word niet ingeladen (parameters verplicht?)
    // || voorbeeldimages ||


    // pagination gedeelte


    function pagination(int $postsPerPage = 2, int $offset = 2) {
        // get full site link
        $actual_link = "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = preg_replace("/\?.*/", "", $actual_link);

        if (file_exists("messages.txt")) {
            $etienneMessages = file("messages.txt");
             // set $_GET["page"] if it does not exist
            if(!isset($_GET["page"])) {
                $_GET["page"] = 1;
                $currPage = 1;
            } else {
                $currPage = $_GET["page"];
            }

            if(!isset($_GET["amount"])) {
                $_GET["amount"] = $postsPerPage;
            } else {
                $postsPerPage = $_GET["amount"];
            }

            $totalPages = ceil(count($etienneMessages) / $postsPerPage);            

            if(($currPage - $offset) < 1) {
                $pageLow = 1;
            } else {
                $pageLow = $currPage - $offset;
            }
    
            if(($currPage + $offset) > $totalPages) {
                $pageHigh = $totalPages;
            } else {
                $pageHigh = $currPage + $offset;
            }


            // display page links with parameter page
            // some styling needed
            echo "<nav><ul>";

            if($pageLow > 1) {
                echo "<li><a href='" . htmlspecialchars($actual_link) . "?page=1&amount=" . $postsPerPage . "'>&lt;&lt;&lt; First Page</a></li>";
                if($pageLow > 2) {
                    echo "...";
                }
            }

            for($i = $pageLow; $i <= $pageHigh; $i++) {
                echo "<li><a href=\"" . htmlspecialchars($actual_link) . "?page=" . $i . "&amount=" . $postsPerPage . "\">{$i}</a></li>";
            }

            if($pageHigh < $totalPages) {
                if($pageHigh < ($totalPages - 1)) {
                    echo "...";
                }
                echo "<li><a href='" . htmlspecialchars($actual_link) . "?page=" . $totalPages . "&amount=" . $postsPerPage . "'>&gt;&gt;&gt; Last Page</a></li>";
            }
            echo "</ul></nav>";

           

        } else {
            // messages.txt does not exist
            echo "FILE NOT FOUND";
            return false;
        }
    }


    function etienneTest(){
        pagination();
    }
    

?>