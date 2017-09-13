# google-custom-search-api
Google Search API PHP Example Tutorial with Demo to Get the First Web Pages and Images as a JSON Array


Appearing in the Google Search results is very important these days but it is not that easy. The competition is very high and your pages need to rank with the right keywords.

Finding if you are ranking with the right keywords is very difficult. You need to take every keyword and test it against a search, then look for your site in the search results list. However, Google blocks scripts that scrape the search result pages.

Fortunately there is an official API from Google that lets you search for certain keywords and you can use it from PHP or any other language.

# Simple Example

With this class the work becomes very easy. You do not need to create any search URLs and process any hard JSON responses.
```
<?php 
use Fogg\Google\CustomSearch\ CustomSearch; 
require 'CustomSearch.php'; 

//Initialize the search class 
$cs = new CustomSearch(); 

//Perform a simple search 
$response = $cs->simpleSearch( 'whole foods' ); 
```

## Instructions

Open the **CustomSearch.php** file and replace **searchEngineId**, **GoogleApiKey** and **YourIP** address variables with your owns and yeah you are good to go that's it.