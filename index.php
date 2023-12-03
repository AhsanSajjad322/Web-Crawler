<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Engine</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

    <section class="search-section">
        <h1>Search Engine</h1>
        <form action="" method="GET">
            <input type="text" id="seedURL" class="search" name="seedUrl" placeholder="https://www.vox.com/">
            <button class="btn" type="submit">Crawl</button>
        </form>
        <p>Crawling might takes several seconds <br><i> Max crawling time is 60s</i></p>
    </section>

    <section class="search-section">
        <form action="" method="GET">
            <input type="text" id="search" class="search" name="search" placeholder="Search...">
            <button class="btn" type="submit">Search</button>
        </form>
    </section>
    <section class="results-section">
        <!-- The search results will be displayed here -->
    </section>
    <section class="results">
        <h2>Searched Results: </h2>
        <?php

            /*
             Handles the GET request by the form with input field of name seedURL settled
             If so then crawl the seedURL provided in seedURL input field
            */
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if (isset($_GET['seedUrl'])) {
                    $seedURL = $_GET['seedUrl'];
                    include 'crawler.php';
                }
            }

            /*
             Handles the GET request by the form with search input field settled
             If so then run the search file to search for the text specified 
            */
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if (isset($_GET['search'])) {
                    $searchURLArray = [];
                    $toSearchData = $_GET['search'];

                    include 'search.php';
                    $searchedData = searchModule($toSearchData);
                    if(!$searchedData){
                        echo "<p>No Data Found</p>";
                        return;
                    }
                    /*
                     Displaying Searched Data on Screen in a specified format such that the page title
                     from which the data in found on top which is a hyperlink to then original page and
                     then the Line No's with text, specifying the lines in which the search result is 
                     found in that file.
                    */ 
                    echo "<ul>";
                    foreach($searchedData as $result){
                        $url = $result['url'];
                        if(!in_array($url,$searchURLArray)){
                            array_push($searchURLArray, $url);
                            $title = $result['title'];
                            echo "<h3><a href=$url>$title</a></h3>";
                        }
                        $lineContent = $result['lineContent'];
                        $lineNumber = $result['lineNumber'];

                        echo "<li><b>Line $lineNumber</b> : $lineContent </li>"; 
                    }
                    echo "</ul>";

                } else {
                    echo "No search parameter provided.";
                }
            }
        ?>
    </section>
    
</body>
</html>
