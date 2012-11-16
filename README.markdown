# TMDb PHP API #

## Why this class ##

This class has been started with the old API version (2.1) because of the lack of a general and recent php class for TMDb at the time. The second reason why this class is made is very simple: I love the work they do at [TMDb](http://themoviedb.org). They provide a great API so everyone can use their database to make cool applications. Now there's a new API v3 and it's supported too. The old version you can find on a [different branch at github](https://github.com/glamorous/TMDb-PHP-API/tree/apiv2).

## Requirements ##

- PHP 5.2.x or higher
- cURL
- TMDb API-key

## Available methods ##

All methods are listed here, for use, look into the code, everything is documentated. Optional parameters are between brackets []. Also look into the TMDb-documentation for better unstanding of the possible methods.

### Collection ###

- getCollection($id, [$lang])

### Company ###

- searchCompany($query, [$page])
- getMoviesByCompany($id, [$page], [$lang])

### Genres ###

- getGenres([$lang])
- getMoviesByGenre($id, [$page], [$lang])

### Movies ###

- searchMovie($query, [$page], [$adult], [$lang])
- getMovie($id, [$lang])
- getMovieCast($id)
- getMovieImages($id, [$lang])
- getMovieKeywords($id)
- getMovieReleases($id)
- getMovieTitles($id, [$country])
- getMovieTrailers($id, [$lang])
- getMovieTranslations($id)
- getMoviesByCompany($id, [$page], [$lang])
- getMoviesByGenre($id, [$page], [$lang])
- getLatestMovie()
- getTopRatedMovies([$page], [$lang])
- getPopularMovies([$page], [$lang])
- getUpcomingMovies([$page], [$lang])
- getNowPlayingMovies([$page], [$lang])
- getSimularMovies($id, [$page], [$lang])
- getChangedMovies([$page], [$start_date], [$end_date])
- getMovieChanges($id)

### Persons ###

- searchPerson($query, [$page], [$adult])
- getPerson($id)
- getPersonCredits($id, [$lang])
- getPersonImages($id)
- getChangedPersons([$page], [$start_date], [$end_date])
- getPersonChanges($id)

### Authentication ###

- getAuthToken()
- getAuthSession($token)
- setAuthSession($id)

### Account ###

- addFavoriteMovie($account_id, $session_id, $movie_id, TRUE)
- addMovieRating($session_id, $movie_id, $value)
- addMovieToWatchlist($account_id, $session_id, $movie_id)
- getAccount($session_id)
- getAccountFavoriteMovies($account_id, $session_id, [$page], [$lang])
- getAccountRatedMovies($account_id, $session_id, [$page], [$lang])
- getAccountWatchlistMovies($account_id, $session_id, [$page], [$lang])

### Misc ###

- getAvailableImageSizes($imagetype)
- getConfig()
- getConfiguration()
- getImageUrl($filepath, $imagetype, $size)
- getLang()
- setLang($languague)
- getVersion($uri)

## How to use ##

### Initialize the class ###

    <?php
        include('TMDb.php');

        // Default English language
        $tmdb = new TMDb('API-key');

        // Set-up the class with your own language
        $tmdb_nl = new TMDb('API-key', 'nl');

        // If you want to load the TMDb-config (default FALSE)
        $tmdb_load_config = new TMDb('API-key', 'en', TRUE);
	?>

### Authentication ###

It's important to read the TMDb-documentation about this one. The necessary methods are available to retrieve a valid token and session_id (more information on the [TMDb Knowledge Base](http://help.themoviedb.org/kb/api/user-authentication))

    <?php
        // After initialize the class
        // First request a token from API
        $token = $tmdb->getAuthToken();
    ?>

Then you have to redirect the user to TMDb-website with the `Authentication-Callback` find in the `$token`-variable received from the method `getAuthToken` so the user can autorise your app.

    <?php
		// Request valid session for that particular user from API
		$session = $tmdb->getAuthSession();
    ?>

Store the session_id securely for that particular user and use it for authenticated calls.

IF you have saved the session_id, you can use it (optional) set it with every authenticated request for every user or you can set it globally with the method `setAuthSession`.

### Configuration ###

The configuration is something new in API v3. It's used to retrieve information from TMDb so you only have to request it once. It's your task to save it (or cache) and sometimes retrieve a new version.

    <?php
	    //Retrieve config with initialisation of the class
		$tmdb = new TMDb('API-key', 'en', TRUE);
    ?>

    <?php
	    //Retrieve (cached) config when the class is already initialised
		$config = $tmdb->getConfig();
    ?>

    <?php
	    //Retrieve config when the class is already initialised from TMDb (always new request)
		$config = $tmdb->getConfiguration();
    ?>

### Images ###

The way to retrieve images is a little bit different then before. You retrieve filepaths in you request. To parse an url you need to use the configuration and some extra methods.

    <?php
	    //Filepath retrieved from a method (Backdrop image)
		$filepath = '/eJhymb0SiOd39L3BDe7aO7iQhQx.jpg';

		//Get image URL for the backdrop image in its original size
		$image_url = $tmdb->getImageUrl($filepath, TMDb::IMAGE_BACKDROP, 'original');
    ?>

There are now 3 formats available for the images: `TMDb::IMAGE_BACKDROP`, `TMDb::IMAGE_POSTER`, `TMDb::IMAGE_PROFILE`. To retrieve all available image size for a particular imagetype you can use the method `getAvailableImageSizes`.

    <?php
	    //Get all possible image sizes for backdrop images.
		$array_with_backdrop_sizes = $tmdb->getAvailableImageSizes(TMDb::IMAGE_BACKDROP);
    ?>

### Versions ###

With the new version of the API (v3) there aren't specific methods to track the state of a movie or a person. Like [TMDb suggested](http://help.themoviedb.org/kb/api/content-versioning) you can now use the header information, especially the ETag to check the state of the content of a specific method.

    <?php
	    //Just add some URI to the method to retrieve the ETag of the request.
		$etag = $tmdb->getVersion('movie/550');
    ?>

### HTTPS / SSL ###

With the new version of the API (v3) there's support for SSL. This class supports working with `https` too.

    <?php
	    //Just add a TMDb constant from the class when you initialize the class.
		$tmdb = new TMDb('API-key', 'en', FALSE, TMDb::API_SCHEME_SSL);
    ?>

## Issues/Bugs ##

It's always possible to find some issues. If you find one, please inform us with the issue tracker on [github](http://github.com/glamorous/TMDb-PHP-API/issues). Please don't use this to ask question how to use this class. It's straight forward and easy to understand for everyone with a basic knowledge of PHP.

## Changelog ##

**TMDb 1.5.1 - 16/11/2012**

- [bug] getPersonCredits wasn't working the correct way. Thanks to the github user [caa007](https://github.com/caa007). Closed issue [#11](https://github.com/glamorous/TMDb-PHP-API/issues/11).

**TMDb 1.5.0 - 16/11/2012**

- [feature] Support for SSL

**TMDb 1.4.0 - 11/10/2012**

- [feature] New method for retrieving a movie changes: `getMovieChanges`
- [feature] New method for retrieving all changed movies: `getChangedMovies`
- [feature] New method for retrieving a person changes: `getPersonChanges`
- [feature] New method for retrieving all changed persons: `getChangedPersons`

**TMDb 1.3.0 - 22/08/2012**

- [feature] Get ETag from a method to keep track of state of content, for more information go to [TMDb kb-article](http://help.themoviedb.org/kb/api/content-versioning)

**TMDb 1.2.0 - 21/08/2012**

- [bug][feature] It wasn't possible to use some methods without a language parameter. Now you can pass `FALSE` to it to retrieve all the results without thinking about any language.

**TMDb 1.1.1 - 20/08/2012**

- [bug] Deleted some debugging content

**TMDb 1.1.0 - 12/08/2012**

- [feature] New method for retrieving movie trailers: `getMovieTrailers` It was being forgotten in the first release for the new API (Closed issue #10)

**TMDb 1.0.2 - 07/08/2012**

- [bug] On some recent servers the `&` were replaced with `&amp;` so a `POST` to an old Tomcat java server wouldn't be properly handled. (Closed issue #9)

**TMDb 1.0.1 - 01/08/2012**

- [improvement] `addMovieRating` works better now, whatever you pass trough, it's been casted to `0` or a decent float.

**TMDb 1.0.0 - 30/07/2012**

- The class works now only with API v3.
- All available methods from API v3 are supported by the API
- Old changelog (API v2) is available at [github](https://github.com/glamorous/TMDb-PHP-API/tree/apiv2)

## Handle Errors ##

This class throws an TMDbException when an error is in the class is made by the CURL request or if there's a problem with the TMDb-API).

## License ##

This plugin has a [BSD License](http://www.opensource.org/licenses/bsd-license.php). You can find the license in license.txt that is included with class-package

![githalytics.com alpha](https://cruel-carlota.pagodabox.com/f811fcf46375695910a6d5987d15a55f)