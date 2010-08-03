<?php
/**
 * TMDb PHP API class - API 'themoviedb.org'
 * API Documentation: http://api.themoviedb.org/2.1/
 * Documentation and usage in README file
 *
 * @author Jonas De Smet - Glamorous
 * @since 09.11.2009
 * @date 04.08.2010
 * @copyright Jonas De Smet - Glamorous
 * @version 0.9.4
 * @license BSD http://www.opensource.org/licenses/bsd-license.php
 */

class TMDb
{
	const TMDB = 'Themoviedb.org (TMDb)';
	const IMDB = 'The Internet Movie Database (IMDb)';

	const JSON = 'json';
	const XML = 'xml';
	const YAML = 'yaml';

	const API_URL = 'http://api.themoviedb.org/2.1/';

	const VERSION = '0.9.4';

	/**
	 * The API-key
	 *
	 * @var string
	 */
	private $_apikey;

	/**
	 * The default return format
	 *
	 * @var TMDb::JSON or TMDb::XML or TMDb::YAML
	 */
	private $_format;

	/**
	 * The default language
	 *
	 * @var string
	 */
	private $_lang;

	/**
	 * The available return formats
	 *
	 * @var array
	 */
	private $_formats = array(TMDb::JSON, TMDb::XML, TMDb::YAML);

	/**
	 * Default constructor
	 *
	 * @param string $apikey					API-key recieved from TMDb
	 * @param const[optional] $defaultFormat	Default return format
	 * @param string $defaultLang				Default language
	 * @return void
	 */
	public function __construct($apikey, $defaultFormat = TMDb::JSON, $defaultLang = 'en')
	{
		$this->setApikey($apikey);
		$this->setFormat($defaultFormat);
		$this->setLang($defaultLang);
	}

	/**
	 * Search a movie by title
	 *
	 * @param string $title						Title to search after in the TMDb database
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
	public function searchMovie($title, $format = null)
	{
		return $this->_makeCall('Movie.search', $title, $format);
	}

	/**
	 * Get a movie by TMDb-id or IMDb-id
	 *
	 * @param string $id						TMDb-id or IMDb-id
	 * @param const[optional] $type				For use with IMDb-id you have to change this parameter to TMDb::IMDB
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
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

	/**
	 * Get a movie by hash
	 *
	 * @param string $hash						File hash
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
	public function getMovieByHash($hash, $format = null)
	{
		return $this->_makeCall('Hash.getInfo', $hash, $format);
	}

	/**
	 * Get images by the TMDb-id or IMDb-id
	 *
	 * @param string $id						Movie TMDb-id or IMDb-id
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
	public function getImages($id, $format = null)
	{
		return $this->_makeCall('Movie.getImages', $id, $format);
	}

	/**
	 * Search a person by name
	 *
	 * @param string $name						Name to search after in the TMDb database
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
	public function searchPerson($name, $format = null)
	{
		return $this->_makeCall('Person.search', $name, $format);
	}

	/**
	 * Get a person by his TMDb-id
	 *
	 * @param string $id						Persons TMDb-id
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
	public function getPerson($id, $format = null)
	{
		return $this->_makeCall('Person.getInfo', $id, $format);
	}

	/**
	 * Get a Movie-version by its TMDb-id or IMDB-id
	 *
	 * @param string $id						Movie TMDb-id or IMDB-id
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
	public function getMovieVersion($id, $format = null)
	{
		return $this->_makeCall('Movie.getVersion', $id, $format);
	}

	/**
	 * Get multiple Movie-versions by their TMDb-id or IMDB-id
	 *
	 * @param array $ids						Array with Movie TMDb-id's or IMDB-id's
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
	public function getMovieVersions(array $ids, $format = null)
	{
		return $this->_makeCall('Movie.getVersion', implode(',', $ids), $format);
	}

	/**
	 * Get a Person-version by its TMDb-id
	 *
	 * @param string $id						Person TMDb-id
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
	public function getPersonVersion($id, $format = null)
	{
		return $this->_makeCall('Person.getVersion', $id, $format);
	}

	/**
	 * Get multiple Person-versions by their TMDb-id
	 *
	 * @param array $ids						Array with Person TMDb-id's
	 * @param const[optional] $format			Return format for this function
	 * @return string
	 */
	public function getPersonVersions(array $ids, $format = null)
	{
		return $this->_makeCall('Person.getVersion', implode(',', $ids), $format);
	}

	/**
	 * Makes the call to the API
	 *
	 * @param string $function					API specific function name for in the URL
	 * @param string $param						Unencoded paramter for in the URL
	 * @param const $format						Return format for this function
	 * @return string
	 */
	private function _makeCall($function, $param, $format)
	{
		$type = (!empty($format))? $format : $this->getFormat();

		$url = TMDb::API_URL.$function.'/'.$this->getLang().'/'.$type.'/'.$this->getApikey().'/'.urlencode($param);

		if (extension_loaded('curl'))
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);

			$results = curl_exec($ch);
			$headers = curl_getinfo($ch);

			$error_number = curl_errno($ch);
			$error_message = curl_error($ch);

			curl_close($ch);
		}
		else
		{
			$results = file_get_contents($url);
		}

		return (string) $results;
	}

	/**
	 * Setter for the default return format
	 *
	 * @param const $format
	 * @return void
	 */
	public function setFormat($format)
	{
		if(in_array($format, $this->_formats))
		{
			$this->_format = $format;
		}
		else
		{
			$this->_format = TMDb::JSON;
		}
	}

	/**
	 * Getter for the default return format
	 *
	 * @return const
	 */
	public function getFormat()
	{
		return $this->_format;
	}

	/**
	 * Setter for the default language
	 *
	 * @param string $lang
	 * @return void
	 */
	public function setLang($lang)
	{
		$this->_lang = $lang;
	}

	/**
	 * Getter for the default language
	 *
	 * @return string
	 */
	public function getLang()
	{
		return $this->_lang;
	}

	/**
	 * Setter for the API-key
	 *
	 * @param string $apikey
	 * @return void
	 */
	public function setApikey($apikey)
	{
		$this->_apikey = (string) $apikey;
	}

	/**
	 * Getter for the API-key
	 *
	 * @return string
	 */
	public function getApikey()
	{
		return $this->_apikey;
	}


}
?>