<?php
use Fogg\Google\CustomSearch\CustomSearch;
require 'CustomSearch.php';

//Initialize the search class
$cs = new CustomSearch();

//Perform a simple search
$response = $cs->simpleSearch('whole foods');

//Perform a search with extra parameters
$response2 = $cs->search('whole foods', ['excludeTerms'=>'tomato']);