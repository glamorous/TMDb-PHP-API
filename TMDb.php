<?php
/**
 * TMDb PHP API class - API 'themoviedb.org'
 * API Documentation: http://api.themoviedb.org/2.1/
 * Documentation and usage in README file
 * 
 * @author Jonas De Smet - Glamorous
 * @since 09.11.2009
 * @copyright Jonas De Smet - Glamorous
 * @version 0.4
 * @license BSD http://www.opensource.org/licenses/bsd-license.php
 */

class TMDb
{
	const TMDB = 'Themoviedb';
	const IMDB = 'Internet Movie Database';
	const JSON = 'json';
	const XML = 'xml';
	const YAML = 'yaml';

	const API = 'http://api.themoviedb.org/2.1/';

	private $_apikey;
	private $_format;
	private $_lang;
	private $_formats = array(TMDb::JSON, TMDb::XML, TMDb::YAML);
	private $languages = array('en');
	
	public function __construct($apikey, $defaultFormat = TMDb::JSON, $defaultLang = 'en')
	{
		$this->setApikey($apikey);
		$this->setFormat($defaultFormat);
		$this->setLang($defaultLang);
	}

	public function searchMovie($title, $format = null)
	{
		return $this->_makeCall('Movie.search', $title, $format);
	}

	public function getMovie($id, $type = TMDb::TMDB, $format = null)
	{
		if($type == TMDb::IMDB)
		{
			return $this->_makeCall('Movie.imdbLookup', $id, $format);
		}
		else
		{
			return $this->_makeCall('Movie.getInfo', $id, $format);
		}
	}

	public function searchPerson($name, $format = null)
	{
		return $this->_makeCall('Person.search', $name, $format);
	}

	public function getPerson($id, $format = null)
	{
		return $this->_makeCall('Person.getInfo', $id, $format);
	}
	
	private function _makeCall($function, $param, $format)
	{
		$type = (!empty($format))? $format : $this->defaultFormat();
		
		$url = TMDb::API.$function.'/'.$this->getLang().'/'.$type.'/'.$this->getApikey().'/'.urlencode($param);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec();
		curl_close($ch); 
		
		return $data;
	}
	
	public function setFormat($format)
	{
		if(in_array($format, $this->formats))
		{
			$this->_format = $format;
		}
		else
		{
			$this->_format = TMDb::JSON;
		}
	}
	
	public function getFormat()
	{
		return $this->_format;
	}
	
	public function setLang($lang)
	{
		if(in_array($lang, $this->languages))
		{
			$this->_lang = $lang;
		}
		else
		{
			$this->_lang = 'en';
		}
	}
	
	public function getApikey()
	{
		return $this->_apikey;
	}
	
	public function setApikey($apikey)
	{
		$this->_apikey = $apikey;
	}
	
	public function getLang()
	{
		return $this->_lang;
	}
}
?>