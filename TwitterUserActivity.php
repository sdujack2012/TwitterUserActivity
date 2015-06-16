<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require "twitteroauth/autoload.php";
require "ConfigReader.php";

use Abraham\TwitterOAuth\TwitterOAuth;
/**
 * Description of TwitterUserActivity
 *
 * @author Kai_Jiang
 */
class TwitterUserActivity {
    
    /**
     * an array containing parsed api paramenters
     */
    private $APIConfig;
    /**
     * api connection
     */
    private $connection;
   /**
     * Time format used by twitter
     */
    private $twitterTimeFormat="D M d h:i:s O Y";
	/**
     * user activity data by hour
     */
    private $userActivityData=array();
	
	
	
    public function __construct() {
		$configReader = new ConfigReader("API.config");
        $this->APIConfig = $configReader->config;
		
        $this->connection = new TwitterOAuth($this->APIConfig->ConsumerKey,
                                        $this->APIConfig->ConsumerSecret,
                                         $this->APIConfig->AccessToken,
                                          $this->APIConfig->AccessTokenSecret);
        
    }
    public function getActivitiesPerHouse() {
		$timeLines = $this->getTimeLinesByUsername("twitterapi");
		foreach ($timeLines as $timeLine) {
			$date = $this->processTimeString($timeLine->created_at);
			$userActivityData[$date->format('h')]++;
		}
                $time  = $this->processTimeString($timeLines[1]->created_at);
		var_dump($time);
    }
   
    public function getTimeLinesByUsername($Username) {
		return $this->connection->get("statuses/user_timeline", array("count" =>500, "screen_name"=>$Username,"exclude_replies" => true));
        
	}
	public function processTimeString($timestring) {
		return date_create_from_format($this->twitterTimeFormat, $timestring );
        
	}
}
