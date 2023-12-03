<?php

    /*
     Search the String provided to it within all the files in the output directory
     Format of each file is that the first line is a URL with the url to the page and 
     the second line of each file is Title with the original title of that page
     returns : a associative array with url, lineNo, lineContent, title in key-value pairs. 
    */ 
    function searchModule($searchString) {
        $searchResults = []; 
    
        $files = glob('output/*.txt');
    
        foreach ($files as $file) {
            $lines = file($file, FILE_IGNORE_NEW_LINES);
            $url = isset($lines[0]) ? trim(substr($lines[0], 4)) : '';
            $title = isset($lines[1]) ? trim(substr($lines[1], 6)) : '';
    
            foreach ($lines as $lineNumber => $line) {
                if (stripos($line, $searchString) !== false) {
                    $searchResults[] = [
                        'url' => $url,
                        'lineNumber' => $lineNumber + 1,
                        'lineContent' => $line,
                        'title' => $title,
                    ];
                }
            }
        }
    
        return $searchResults;
    }
?>
