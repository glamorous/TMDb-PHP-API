# TMDb PHP API #

## Why this class ##

Because of the lack of a general and recent php class (api 2.1) for TMDb. The CakePHP class is outdated and doesn't provide you to search for people. With this class you can search and get Movie and People information.  
The second reason why this class is made is very simple: I love the work they do at [TMDb](http://themoviedb.org). They provide a great API so everyone can use there database to make cool applications.

## How to use ##

### Initialize the class ###

    <?php
	    include('TMDb.php');
	    
	    //'json' is set as default return format
	    $tmdb = new TMDb('API-key'); //change 'API-key' with yours
	    
	    //if you prefer using 'xml'
	    $tmdb_xml = new TMDb('API-key',TMDb::XML);
	    
	    //or even 'yaml'
	    $tmdb_yaml = new TMDb('API-key',TMDb::YAML);
	?>

### Search a Movie ###

    <?php
		//Title to search for
		$title = 'Orphan';
		
		//Search Movie with default return format
		$xml_movies_result = $tmdb_xml->searchMovie($title);
		
		//Search Movie with other return format than the default
		$json_movies_result = $tmdb_yaml->searchMovie($title,TMDb::JSON);
    ?>

### Get a Movie ###

    <?php
	    //TMDb id for a movie
		$tmdb_id = 187; //or $tmdb_id = '187';
		//IMDb id for a movie
		$imdb_id = 'tt0137523';
		
		//Get Movie with default return format and with TMDb-id
		$xml_movie_result = $tmdb_xml->getMovie($tmdb_id);
		
		//Get Movie with other return format than the default and with an IMDb-id
		$json_movie_result = $tmdb_yaml->getMovie($imbd_id,TMDb::IMDB,TMDb::JSON);
    ?>

### Get a Movie by Hash ###

You can find more information about movie-hashes on the website from [opensubtitles](http://trac.opensubtitles.org/projects/opensubtitles/wiki/HashSourceCodes).

    <?php
	    //Hash for a movie
		$hash = '00277ff46533b155';
	
      	//Search Movie by hash with default return format
      	$json_moviehash_result = $tmdb->getMovieByHash($hash);
    ?>

### Get Images from a Movie ###

    <?php
	    //TMDb id for a movie
		$tmdb_id = 187; //or $tmdb_id = '187';
		//IMDb id for a movie
		$imdb_id = 'tt0137523';
		
		//Get Images with default return format and with TMDb-id
		$xml_movie_result = $tmdb_xml->getImages($tmdb_id);
		
		//Get Images with other return format than the default and with an IMDb-id
		$json_movie_result = $tmdb_yaml->getImages($imbd_id,TMDb::JSON);
    ?>

### Search a Person ###

	<?php
		//Name of an actor/actress or production member
		$name = 'Jack Black';
		
		//Search Person with default return format
		$json_persons_result = $tmdb->searchPerson($name);
		
		//Search Person with other return format than the default
		$xml_persons_result = $tmdb_yaml->getMovie($name,TMDb::XML);
	?>

### Get a Person ###

	<?php
		//ID in TMDb of an actor/actress or production member
		$person_id = 500;
		
		//Get Person with default return format
		$json_persons_result = $tmdb->getPerson($person_id);
		
		//Search Person with other return format than the default
		$xml_persons_result = $tmdb_yaml->getPerson($person_id,TMDb::XML);
	?>

## Issues/Bugs ##

We didn't find any bugs (yet). If you find one, please inform us with the issue tracker on [github](http://github.com/glamorous/TMDb-PHP-API/issues).

## Changelog ##

**TMDb 0.9.1 - 27/02/2009**

- [feature] Added support for servers without cURL

**TMDb 0.9 - 19/11/2009**

- [feature] Added new API-method: 'Hash.getInfo'

**TMDb 0.8 - 12/11/2009**

- [feature] Added new API-method: 'Movie.getImages'

**TMDb 0.7**

- [bug] Calling unknown methods
- [bug] Changed cURL options
- tested with success

**TMDb 0.6**

- [bug] Fixed some bugs: calling unknown variables
- Provided inline documentation
- Added a README file
- Added a license.txt
- Still not tested
  
**TMDb 0.5**

- This is the first version of the class without inline documentation or testing   

## Feature Requests / To come ##

- Add a debug-variable to check all the steps in the progress
- Add a error/exception when the API returns nothing or has an error

If you want something to add on this plugin, feel free to fork the project on [github](http://github.com/glamorous/TMDb-PHP-API) or add an [issue](http://github.com/glamorous/TMDb-PHP-API/issues) as a feature request.

## License ##

This plugin has a [BSD License](http://www.opensource.org/licenses/bsd-license.php). You can find the license in license.txt that is included with class-package