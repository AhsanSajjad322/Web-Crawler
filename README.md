# Web-Crawler

# How to setup
Following are the steps to run this web crawler
1) First download this repository or else clone it in the folder that is placed in htdocs folder of xampp files, where you installed the xampp.

### To clone it write command : 
    git clone https://github.com/AhsanSajjad322/Web-Crawler.git

Note : If you download then, the downloaded repository must be placed in htdocs folder of xampp files. 

3) Then start Apache server from xampp control panel.
2) Then write http://localhost/directoryName/Web-Crawler-main/Web-Crawler-main/index.php in web browser to run the Web Crawler index.php file.

Note : The directoryName should be the name of folder in which you placed code in htdocs directory. If directory placed the downloaded repository in htdocs folder, then write this in web browser: http://localhost/Web-Crawler-main/Web-Crawler-main/index.php

# About Crawler
* The code is the implementation of the crawler in which user enters the seed URL (base URL) and starts crawling, when the crawling is finished the user searches for a specific data and then the search module displays the searched results from the data stored in files

* The crawler does crawling to a depth of 2, considering the seedURL level as 0.

* The crawler does crawling to a maximum time limit of 60s and then the crawler stops and user searches for data. 

# Technologies used
* PHP for crawling a website and form handling on submission when user enters a data to be search.
* HTML to structure the content shown on webpage.
* CSS to style the content.

# Directory Structure
* Web-Crawler is the root directory and it contains php scripts to run.
* CSS directory inside Web-Crawler has style.css file.
* output directory inside Web-Crawler to place all the files created when a particular url is crawled, and thus it contains all files that store's data.

# About Code
## index.php file
* Contains the code that is displayed when user run this crawler. 
* It also contains code to handle to requests when user submits input fields.

## crawler.php file
This files holds the main logic of crawling a url. It has following functions:
* isValidURL to check whether a URL entered is valid or not. It uses regular expressions for this purpose.
* saveToFile to save the data extracted from a webpage to flat files in a specified format i-e URL:url of webpage, it is the first line of every file. The second line is the Title:title of the webpage and from third line the data of the webpage is placed.
* getTitleAndText this function is used to extract meta data like title of the webpage and the raw text of the webpage.
* isNotAllowedByRobotsTxt this functions checks which url paths are allowed by robots.txt path of the website and if a url matches url from this path, that url is not added to url queue.
* crawl it is a recursive function with a base case i-e depth = 0 and just stores the data of the current page if base case is reached. Else this function crawls the webpage and extracts urls from a webpage and place them in url queue from which furthur URL's are taken to extract data from.   


## search.php
* It searches the String provided to it within all the files in the output directory and returns a associative array with url, lineNo, lineContent, title in key-value pairs which is diplayed to user on screen.

# Functionalities
* A url queue to placed all urls to be queued.
* Crawling - by crawl function that sends HTTP requests to the URLs in the queue, retrieves the HTML content, and saves it.
* HTML parsing - It is done by using DOMDocument class of php.
* URL Extraction - It is done using getElementsByTagName of DOMDocument.
* Depth Limit - It is set to 2.
* Output - The page title is displayed whenever users search for some text
* Content Search Module - Whenever user searches for a content, the title of the page as the link to the original webpage along with the Line no in which the data is found and the complete sentence is also displayed to user.
* Robots.txt Compliance - a function in crawler.php files deals with these rules of the website.
* Error Handling - It is achieved using libxml_clear_errors of DOMDocument and also by validating URL's. 
* Filtering - The crawler functions holds a logic that when crawling url's in a specified page, and url in anchor tag is encountered that belongs to some other website(hostname), a scheme is defined to not include that url in urlQueue.

# Search Engine Interface
![search engine image](/WebCrawler/Web-Crawler/images/image.png)
![search engine image](/WebCrawler/Web-Crawler/images/image2.png)
