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
    } // checkImageExt

    function getImg(string $location, int $imgWidth = 128, int $imgHeight = 128) {
        // default image
        $defautImage = "https://media1.tenor.com/images/fbe8b29e01a6b2851449c3a3d28bff52/tenor.gif";

        // gooit parameters uit de link (alles vanaf ?) 
        $filteredLocation = preg_replace("/\?.*/", "", $location);

        if(checkImageExt($filteredLocation) === true) {
            return " <img src='" . htmlspecialchars($filteredLocation) . "' width='{$imgWidth}' height='{$imgHeight}'>";
        } else {
            return " <img src='" . htmlspecialchars($defautImage) . "' width='{$imgWidth}' height='{$imgHeight}'>";
        }
        
    } // getImg

    // || voorbeeldimages ||
    // https://ps.w.org/facebook-conversion-pixel/assets/icon-256x256.png?rev=2278926
    // https://i.imgur.com/8G3NXcW.gif
    // https://i.imgur.com/m6lSnfO.png
    // https://images.all-free-download.com/images/graphicthumb/hd_pictures_of_animals_01_hd_picture_169003.jpg
    // https://dev.w3.org/SVG/tools/svgweb/samples/svg-files/410.svg
    // https://res.cloudinary.com/demo/image/upload/fl_awebp/bored_animation.webp
    // || voorbeeldimages ||


    // pagination gedeelte


    function pagination(int $postsPerPage = 2, int $offset = 2) {

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
            echo "<nav><ul>";

            if($pageLow > 1) {
                echo "<li><a href='guestbook.php?page=1&amount=" . $postsPerPage . "'>&lt;&dash;First Page</a></li>";
                if($pageLow > 2) {
                    echo "<li>...</li>";
                }
            }

            for($i = $pageLow; $i <= $pageHigh; $i++) {
                if($i == $currPage) {
                    echo "<li>{$i}</li>";
                } else {
                    echo "<li><a href='guestbook.php?page=" . $i . "&amount=" . $postsPerPage . "'>{$i}</a></li>";
                }
            }

            if($pageHigh < $totalPages) {
                if($pageHigh < ($totalPages - 1)) {
                    echo "<li>...</li>";
                }
                echo "<li><a href='guestbook.php?page=" . $totalPages . "&amount=" . $postsPerPage . "'>Last Page&dash;&gt;</a></li>";
            }
            echo "</ul></nav>";

        } else {
            // messages.txt does not exist
            echo "FILE NOT FOUND";
            return false;
        }
    } // pagination
?>