<?php

require_once('util.php');
require_once('insight.php');

define('BASE_URL','https://www.googleapis.com/customsearch/v1');
//define('API_KEY','AIzaSyAGDmzYmLYwcSPvsGjwanVI0uW1XhnGtCU'); //Google API Key
define('API_KEY','AIzaSyDMwyRQ-K4TPfspp4sEZcm-UqVUcioa7rk'); //Google ASHISHH API Key
define('CX','003497115017727064932:gap6uu3uafg'); //Google Custom Search API Key
		
interface SearchFormatStrategy 
{
	function getData(Google_Search $search);
}

class JSONStrategy implements SearchFormatStrategy {

	// Request JSON formatted search response
	public	function  getData(Google_Search $searchRes) {
		
		$params = array('key' => API_KEY,
						'cx' => CX,
						'q' => $searchRes->getQuery(),
						'alt'=>'json'
						);

		$url = BASE_URL . '?' . http_build_query($params, '', '&');
		
		$response = getSearchResult($url);

		//print_r($response);

		if ($response['errno'] == 0) {

			$responseArr =  json_decode($response['content']);
		}
		else {

			echo 'Error! Trouble somewehre. <br>' . $response['errmsg'];
		}

		if(count($responseArr->items))
		{
			foreach ($responseArr->items as $item) 
			{
				$pagemap = $item->pagemap;
				$thumb = $pagemap->cse_thumbnail;
				if(empty($thumb[0]->src)) 
				{
					$thumbnail = Yii::app()->request->baseUrl.'/assets/buzz/default.png';
				} 
				else 
				{
					$thumbnail = $thumb[0]->src;
				}
				
				if(empty($metatags[0]->posted)) 
				{
					if(empty($metatags[0]->date)) 
					{
						$date = date('Y-m-d');
				  	} 
					else 
					{
						$date = $metatags[0]->date;
				  	}
				} 
				else 
				{
					$date = $metatags[0]->posted;
				}
				
				//starting categorizing
				$sentiment = new Sentiment();
	
				//$score = $sentiment->categorise($item->htmlSnippet);
				if(!empty($language) && $language == 'lang_da') {
				$score = $sentiment->categorise($item->htmlSnippet, 'dictionary_dk');
				}else {
				$score = $sentiment->categorise($item->htmlSnippet, 'dictionary');
				}
				
				$metatags = $pagemap->metatags;
				// $item->htmlTitle, $item->snippet
				$outputArr[] =  array($item->title, $item->link, $item->htmlSnippet, $thumbnail, $date, $score);
			}
		}
		/*else
		{
			foreach ($responseArr->error as $error) 
			{
				$outputArr[] = $error[0]->message;	
			}
		}*/

		return $outputArr;

	}
}

class ATOMStrategy implements SearchFormatStrategy {

	// Request ATOM formatted search response
	public	function  getData(Google_Search $searchRes) {
		$params = array('key' => API_KEY,
						'cx' => CX,
						'q' => $searchRes->getQuery(),
						'alt'=>'atom'
						);

		$url = BASE_URL . '?' . http_build_query($params, '', '&');

		$response = getSearchResult($url);

		if ($response['errno'] == 0) { // no error

			return $this->_blogFeed($response['content']);

		}
		else {

			echo 'Error! Trouble somewehre. <br>' . $response['errmsg'];
		}

	}

    private function _blogFeed($rssXML)
    {
	libxml_use_internal_errors(true);

        $doc = simplexml_load_string($rssXML);
		$xml = explode("\n", $rssXML);

		if (!$doc) {
			$errors = libxml_get_errors();

			foreach ($errors as $error) {
				echo $this->display_xml_error($error, $xml);
			}

			libxml_clear_errors();
		}

        if(count($doc) == 0) return;

		$docArr = json_decode(json_encode($doc),true);
		$entries = $docArr['entry'];

        foreach($entries as $item)
        {

		   $this->title		=	$item['title'];
		   $this->link		=	$item['link']['@attributes']['href'];
		   $this->summary	=	$item['summary'];
		   $this->pagemap	=	$item['pagemap']['cse_thumbnail']['src'];

            $post = array(
				'title'=>		$this->title,
				'link' =>		$this->link,
				'summary' =>	$this->summary,
				'pagemap' =>	$this->pagemap

			);

            $this->posts[] = $post;

        }

		return $this->posts;

    }

       // This I copied from somewhere
	public function display_xml_error($error, $xml)
	{
		$return  = $xml[$error->line - 1] . "\n";
		$return .= str_repeat('-', $error->column) . "^\n";

		switch ($error->level) {
			case LIBXML_ERR_WARNING:
				$return .= "Warning $error->code: ";
				break;
			 case LIBXML_ERR_ERROR:
				$return .= "Error $error->code: ";
				break;
			case LIBXML_ERR_FATAL:
				$return .= "Fatal Error $error->code: ";
				break;
		}

		$return .= trim($error->message) .
				   "\n  Line: $error->line" .
				   "\n  Column: $error->column";

		if ($error->file) {
			$return .= "\n  File: $error->file";
		}

		return "$return\n\n--------------------------------------------\n\n";
	}

}

class Google_Search {


	private $query = ''; 

	public function __construct ($queryTerm_) {

		$this->setQuery($queryTerm_);

	}

	public function getData(SearchFormatStrategy $strategyObject) {

		return $strategyObject->getData($this);

	}

	public function setQuery ($queryTerm_) {

		$this->query = $queryTerm_;

	}

	public function getQuery () {

		return $this->query;

	}

}

?>