
        Setup
        1) for basic third party calling used curl library
        2) for implementing redis used library file of redis for windows
           for that used predis with composer setup
        3) as windows dosnt gives update for its redis software
           i used memurai tool which gives us redis for windows
        4) used memurai cli to check redis client and server connection
           which gives redis port number means its connected
        5) to connect our php codeigniter app with redis we need an package named predis
           from packagist.org through composer and for codeigniter predice package 
           stored in libraries of codeigniter.
        4) imported that library in my Weathermap controller
        5) created client object of library config file
        6)  written logic menntioned according to scenarioes in my controller and ouputed it
        7) used xampp for php codeigniter project. 

         
         Scenarioes mentioned in mail
         1) Redis is nosql type memory cache so instead of storing large data comes from external apis
            in database and retriving it requires time and slow down our operation
            but because of redis instead of database we used cached memory which is ultra fast
            and store data for some amount of time in memory and sebsequesnt request by client get data stored
            in memory instead of calling external api for every client request.
         2) To improve performance futher ,redis use unique identification keys on that keys we can identify user
            if identify user we can calculate how many third party request it made in given time
            and we restrict user after some requests
            for that we used client ip address
            for 1st request it store ip single time
            then subsequest request it increment it 
            so we can calculate request made
            after 1 st request we set expiry for ip variable for 20 sec
            and on request count we set diffrent scenarioes
            if request count is greater than 6 we stopped user for some time $ttl is time
         3) by ip restriction in above point we implement rate limit on request
            by this we improved our performance further this process can done on 
            database operations also also we improve it further 
            as same ip can be used by employees in one organisation which also 
            improved by instead of ip we can set an unique api key in redis cache
            and used it ,as api key is secrative and it used by very few clients which haved keys.
        
