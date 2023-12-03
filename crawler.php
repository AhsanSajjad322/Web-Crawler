<?php
    // PHP variables to store data like depth variable to specify the depth to which the crawler crawles
    $urlQueue = [];
    $urlCrawled = [];
    $depth = 2;
    array_push($urlQueue, $seedURL);
    $fileId = 0;

    // Specify the maximum time in seconds to which the crawler can crawl
    set_time_limit(60);

    if(isValidURL($seedURL)){
        // Use parse_url to break down the URL into components i-e https part, hostname, filePaths with quries
        $seedURLComponents = parse_url($seedURL);
        $seedhostname = $seedURLComponents['host'];
        echo "<h3>Seed URL Crawled</h3>";
    }
    elseif (!isValidURL($seedURL)){
        echo "<h1><i>Not a valid URL !</i></h1>";
        return;
    }

    // Check whether the URL is valid or not using regular expressions and returns true or false
    function isValidURL($url) {
        $pattern = '/^(https?|ftp):\/\/[^\s\/$.?#].[^\s]*$/i';
        return preg_match($pattern, $url) === 1;
    }

    /*
     Function that takes a full webpage content as input and returns a array having pageTitle, text 
     of that page and a object of DOMDocument that parses HTML
    */ 
    function getTitleAndText($content){
        // Use DOMDocument to parse HTML
        $dom = new DOMDocument;

        // To clear errors
        libxml_use_internal_errors(true);
        $dom->loadHTML($content);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);
        $titleTags = $dom->getElementsByTagName('title');

        if ($titleTags->length > 0) {
            $pageTitle = $titleTags->item(0)->nodeValue;
        }

        $textNodes = $xpath->query('//h1 | //h2 | //p');
        return [$pageTitle,$textNodes,$dom];
    }

    
    /*
     A resursive function that takes depth as input and start crawling the seedURL and has a base 
     case when depth is zero.
     It saves the data to files in specified format when the data is extracted.
     It also sees for the href attribute of anchor tags and when found populate them in urlQueue
    */ 
    function crawl($depth){
        global $urlQueue, $urlCrawled, $seedhostname,$fileId,$seedURL;

        // Base Case
        if($depth == 0){
            // Getting contents of a specified url, thus sending a request to that URL
            $content = file_get_contents($seedURL);
            if($content !== false){
                $pageTitleAndText = getTitleAndText($content);
                $pageTitle = $pageTitleAndText[0];
                $textNodes = $pageTitleAndText[1];
                return;
            }    
            
        }

        // Array to hold the url's from the current page
        $urlFetched = [];

        foreach($urlQueue as $url){
            if(isValidURL($url)){
                $content = file_get_contents($url);

                if ($content !== false) {
                    $pageTitleAndText = getTitleAndText($content);
                    $pageTitle = $pageTitleAndText[0];
                    $textNodes = $pageTitleAndText[1];
                    
                    $dom = $pageTitleAndText[2];
                    // Get all anchor tags of the current page 
                    $anchors = $dom->getElementsByTagName('a');       

                    // Extract  href attribute from each anchor tag
                    foreach ($anchors as $anchor) {
                        $href = $anchor->getAttribute('href');

                        if (isValidURL($href) && !in_array($href, $urlQueue)) {

                            // Use parse_url to break down the URL into components and extract host from components
                            $urlComponents = parse_url($href);
                            $hostname = $urlComponents['host'];

                            // Condition to minimize the crawling to the seedURL hostname only and not the other pages
                            if($hostname == $seedhostname){
                                array_push($urlFetched, $href);

                                // Mark the current URL as crawled by pushing it in urlCrawled array
                                $poppedURL = array_shift($urlQueue);
                                array_push($urlCrawled,$poppedURL);
                            }
                        }
                    }      
                }
            }
        }
        
        // Push all the fetched URL from the current page to the urlQueue
        foreach($urlFetched as $value){
            array_push($urlQueue,$value);
        }
        // recursive step
        return crawl($depth - 1);
    }
    
    // call to crawl function
    crawl($depth);
?>