<?php
namespace Fogg\Google\CustomSearch;

class CustomSearch {
	/**
	 * The custom search engine id (cx) that can be found from the Custom Search
	 * home: https://www.google.com/cse/all . Click on the custom search engine
	 * then click on the Search engine ID button.
	 *
	 * @var string $searchEngineId
	 */
	private $searchEngineId = '007124194574980033161:dj7n8cmpwry';
	/**
	 * Your Google API key which is found in your Developers Console:
	 * https://console.developers.google.com/project . Click on the project then
	 * APIs & auth -> Credentials. Please note, this API key is tied to your
	 * specified IP addresses.
	 *
	 * @var string $googleApiKey
	 */
	private $googleApiKey = 'yd6oIzvFpSsqABY3wx4gAzIta5qyIHmsSsgz_wv2X';
	/**
	 * The optional IP Address associated with this server and connected to the
	 * above Google Api Key.
	 *
	 * @var string $userIp
	 */
	private $userIp = '43.34.11.92';
	/**
	 * The base URL for the google API.
	 *
	 * @var string $googleApiUrl
	 */
	private $googleApiUrl = 'https://www.googleapis.com/customsearch/v1';

	/**
	 * The constructor allows you to customize the searchEngineId & apiKey at
	 * run-time.
	 *
	 * @param string $searchEngineId The custom search engine id
	 * @param string $googleApiKey Your google api key
	 * @param string $userIp The IP address of your server
	 */
	public function __construct($searchEngineId = null, $googleApiKey = null, $userIp = null){
		if($searchEngineId!==null){
			$this->searchEngineId = $searchEngineId;
		}

		if($googleApiKey!==null){
			$this->googleApiKey = $googleApiKey;
		}

		if($userIp!==null){
			$this->userIp = $userIp;
		}
	}

	/**
	 * Performs the most basic of searches. Pass in the query and it returns the
	 * Google search result as a json string.
	 *
	 * @param string $query The search string.
	 * @return object The json result object for the Google API
	 */
	public function simpleSearch($query){
		$query = urlencode($query);
		return $this->getResult("&q={$query}");
	}

	/**
	 * Performs a search. Pass in the query plus an optional array of advanced
	 * search options. For a list of options and their behaviors, visit:
	 * https://developers.google.com/custom-search/json-api/v1/using_rest#query_parameters
	 *
	 * @param string $query The search string
	 * @param array $queryArr An array of advanced search options
	 * @return object The json result object for the Google API
	 */
	public function search($query, $queryArr = []){
		$querystring = '';
		$parameterArr = [
			'sort' => 'string',
			'orTerms' => 'string',
			'highRange' => 'string',
			'num' => 'integer',
			'cr' => 'string',
			'imgType' => 'string',
			'gl' => 'string',
			'relatedSite' => 'string',
			'searchType' => 'string',
			'fileType' => 'string',
			'start' => 'integer',
			'imgDominantColor' => 'string',
			'lr' => 'string',
			'siteSearch' => 'string',
			'cref' => 'string',
			'dateRestrict' => 'string',
			'safe' => 'string',
			'c2coff' => 'string',
			'googlehost' => 'string',
			'hq' => 'string',
			'exactTerms' => 'string',
			'hl' => 'string',
			'lowRange' => 'string',
			'imgSize' => 'string',
			'imgColorType' => 'string',
			'rights' => 'string',
			'excludeTerms' => 'string',
			'filter' => 'string',
			'linkSite' => 'string',
			'cx' => 'string',
			'siteSearchFilter' => 'string',
		];

		$querystring = "&q=".urlencode($query);


		foreach($parameterArr as $key => $type){
			switch($type){
				case 'string':
					if(
						array_key_exists($key, $queryArr)
						&& !empty($queryArr[$key])
						&& is_string($queryArr[$key])
					){
						$val = urlencode($queryArr[$key]);
						$querystring .= "&{$key}=".urlencode($queryArr[$key]);
					}
					break;
				case 'integer':
					if(
						array_key_exists($key, $queryArr)
						&& !empty($queryArr[$key])
						&& is_int($queryArr[$key])
					){
						$querystring .= "&{$key}=".urlencode($queryArr[$key]);
					}
					break;
			}
		}

		return $this->getResult($querystring);
	}

	/**
	 * Returns the constructed API base URL based on the stored parameters.
	 *
	 * @return string The API base url
	 */
	private function getBaseUrl(){
		return $this->googleApiUrl .
			"?key={$this->googleApiKey}" .
			"&userIp={$this->userIp}" .
			"&cx={$this->searchEngineId}";
	}
	/**
	 * Returns the results from the custom search API as a json string.
	 *
	 * @param string $querystring The full querystring for the google API.
	 * @throws \RuntimeException if the request fails for any reason.
	 * @return object The json object of the Google API result.
	 */
	private function getResult($querystring){
		$requestUrl = $this->getBaseUrl() . $querystring;
		if(($ch = curl_init($requestUrl)) === false){
			throw new \RuntimeException('Unable to initialize request url.');
		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		if(($response = curl_exec($ch)) === false){
			curl_close($ch);
			throw new \RuntimeException('Unable to execute request.');
		}

		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		if($responseCode!=200){
			throw new \RuntimeException('API did not return a valid result: '.$responseCode.' Response: '.$response);
		}

		return json_decode($response);
	}
}
