### Info
Example took me about 5-6 hours. As I am not used to Laravel and was looking for options to avoid `Facades` and other static/magic stuff anywhere else apart from config.
There was high possibility that two or more quotes will be same in group of five. As external API is called 5 times. This is avoided by using `while` loop.

As while loop can run up to memory full or time limit of script if no original item is found, there is a counter to prevent this and throw exception. This behaviour can be altered to lessen on increase tries or to return whatever quotes we have.

Manual refresh endpoint is OK for less heavy API.
But with most APIs I would rather go with combination of Last-Modified/If-Modified-Since Or at least inform client with Cache-Control header and refresh data in specific times. 


### Installation
Instructions are for Ubuntu and may not be correct for Windows/Mac, check Sail docs for those systems in case of any problems running the server.

1. Run composer
```shell
composer install
```

2. Build and run Laravel Sail
```shell
./vendor/bin/sail build
./vendor/bin/sail up -d
```

3.Add [.env](.env) file by copying [.env.example](.env.example) file.

4. Populate `APP_KEY`:
```shell
./vendor/bin/sail artisan key:generate
```
And also `API_KEY` and `KAYNE_WEST_URL` keys.

5. Run tests
```shell
./vendor/bin/sail artisan test
```

6. Check browser
- on [http://0.0.0.0](http://0.0.0.0) for homepage.
- on [http://0.0.0.0/api/quotes?apiKey=YOUR_API_KEY](http://0.0.0.0/api/quotes?apiKey=YOUR_API_KEY) for quotes
- on [http://0.0.0.0/api/quotes/refresh?apiKey=YOUR_API_KEY](http://0.0.0.0/api/quotes/refresh?apiKey=YOUR_API_KEY) to refresh cached quotes
