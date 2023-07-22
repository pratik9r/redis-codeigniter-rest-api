<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  // comments below added by pratik and its explaning the process adopted by me 
  // also comments gives problems mentioned in mail and its solution scenario wise

 class Weathermap extends CI_Controller{
    
    public function index(){
        //loading the redis library
         $this->load->library('redis');
         // create redis object
        $redis = $this->redis->config();

        // for getting info from third party weather api required lattitude and longitude of given city
        // used open weather api which is free to use its required to crete api keys
        date_default_timezone_set("Asia/Kolkata");
        $weather_key ="bc281b8e799773cf79dac165ba82bf62";
        $pune_lat="18.51957";
        $pune_long="73.85535";
        $weather_url = "https://api.openweathermap.org/data/2.5/forecast?lat=".$pune_lat."&lon=".$pune_long."&appid=".$weather_key;
        // https://api.openweathermap.org/data/2.5/weather?lat=44.34&lon=10.99&appid={API key}
        
        
		 /*for limitting the http request to third party api need some unique key 
         based on that unique key we can calculate the given user does how many request in given time
         so for this identification we used clients ip address based on ip we can calculate request by that ip
         and limit the request*/
         
         
         $ip = $_SERVER['REMOTE_ADDR'];
         // redis incr is used for storing ip if present and increment it if not present then it takes value 1 and increment it
         // below variable gives us request count
         $reqCount = $redis->incr($ip);
         //below condition if request count is 1 then expire our unique ip variable after 20 seconds
         if($reqCount == 1) $redis->expire($ip,20);
         /*
           if request count is less than 6 then we will display our main logic of fetching
           the data from third party weather api
         */
         if($reqCount<6){
            $weatherdata =[];
            // created redis get method with an weatherdata variable
            // if redis has this variable in its catche memory then get that data
            $cacheddata =  $redis->get('weatherdata');
            if($cacheddata){
                // gettting get method data and converted it to string
                echo "displaying data from redis cache<br>";
                $weatherdata = json_decode($cacheddata);
            }else{
                echo "displaying data from rest api server<br>";
               /*
                 for obtaining data from third party api
                 we used curl call for it
                 started curl call then placed third party url in it
                 close that call and for https request used CURLOPT_SSL_VERIFYPEER as false
               */
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_URL, $weather_url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_VERBOSE, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                // output data of third party api in json format
                $weatherdata = json_decode($response);
                /*
                 for putting our third party data in redis cache
                 redis have set method 
                 instead of storing data which changes every second in database
                 which gives lots of data and rquires more space 
                 so performing on data consumes lot of time and
                 makes our system slow so instead of that we used cached memory
                 and store data in memory for 10 minutes
                 which improves our performance of system instead of retriving from database
                */
                $redis->set('weatherdata',json_encode($weatherdata));
                $redis->expire('weatherdata',600);
            }

            echo "<h1>Pune Weather</h1><br>";
            //  print_r($weatherdata);
             // stored data in cached memory or call from third party
             // both data are stored weatherdata variable
             // retrived and echoed that data using forloop listed it according to timestamp
             foreach($weatherdata->list as $weatherdata){
                  echo "<strong>Date and Time : </strong> ".date('d/m/Y H:i:s', $weatherdata->dt)."<br>";
                 echo "<strong>City Forcast:   </strong> " .ucwords($weatherdata->weather[0]->description). "<br>";
                 echo "<strong>City Max Temp:  </strong> ". ($weatherdata->main->temp_max)-273.15."&deg;C<br>";
                 echo "<strong>City Min Temp: </strong> ". ($weatherdata->main->temp_min)-273.15."&deg;C<br>";
                 echo "<strong>City Humidity: </strong> ". ($weatherdata->main->humidity)."%<br>";
                 echo "<strong>City Wind Speed: </strong> ". ($weatherdata->wind->speed)."km/h <br><br>";
             }
         }else{
            /* 
             now if we done more than continous request it slow down response time
             which creates traffic on third party api
             so limmitting http request for 20 second for given ip user
             and stop client for making anather request for some time
            */
           $ttl = $redis->ttl($ip);
           echo json_encode(["status"=>"you have used alloted request.try again after {$ttl} seconds..!"]);
         }


        /* 
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
        */

       /*
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
        7) installed and vs code extension of docker.
        8) created and docker-composer.yml file with 
           mentioned ci and php versions and its localhost paths also same for mysql and
           phpmyadmin also mentioned apache in docker-composer file.
        9) after that docker-composed up -d deployed all my local code on docker
           and its localhost port number its running.
        10) used xampp for php codeigniter project. 

       */
          
        
         
        
            

           
        
            
            
    }

    
}

?>