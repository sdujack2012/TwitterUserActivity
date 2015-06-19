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
     * user activity data by hour
     */
    private $userActivityData;

    /**
     * user name
     */
    private $username;

    /**
     * maximum number of timelines to get
     */
    private $maxCount = 500;
     /**
     * maximum number of timelines to get per request
     */
    private $maxPerRequest = 200; //define by twitter API

    /**
     * stores the number of timelines
     */
    private $count;

    public function __construct($username) {
        $this->username = $username;
        $configReader = new ConfigReader("API.config");
        $this->APIConfig = $configReader->config;
        $this->userActivityData = array_fill(0, 24, 0);
        $this->connection = new TwitterOAuth($this->APIConfig->ConsumerKey, $this->APIConfig->ConsumerSecret, $this->APIConfig->AccessToken, $this->APIConfig->AccessTokenSecret);
    }

    public function getActivitiesPerHouse() {
        $timeLines = $this->getTimeLinesByUsername($this->username);
        $this->count = count($timeLines);
        foreach ($timeLines as $timeLine) {

            $hour = $this->getHourFromTimeString($timeLine->created_at);
            if ($hour != -1) {
                $this->userActivityData[$hour] ++;
            }
        }
    }

    public function render() {
        $this->getActivitiesPerHouse();
        // set dimensions
        $w = 520;
        $h = 520;
        $barW = 10;
        $barGap = 20;
        $maxBarHeight = 400 ;

        $font = './arial.ttf';
        // create image
        $im = imagecreate($w, $h);
        // set colours to be used
        $bg = imagecolorallocate($im, 0xE0, 0xE0, 0xE0);
        $black = imagecolorallocate($im, 0x00, 0x00, 0x00);
        $red = imagecolorallocate($im, 0xFF, 0x00, 0x00);
        $green = imagecolorallocate($im, 0x50, 0xB6, 0x30);
        $blue = imagecolorallocate($im, 0x00, 0x00, 0xFF);

        //define origin x,y
        $origin_X = 20;
        $origin_Y = $h-35;
        // draw border
        imagerectangle($im, 0, 0, $w - 2, $h - 2, $black);                      // border uses background colur also
        imagecolortransparent($im, $bg);                             // now make bg colour transparent
        //draw X_axis
        imageline($im, $origin_X, 5, $origin_X, $origin_Y, $green);
        imagettftext($im, 10, 0, $w / 2, $h - 5, $black, $font, "Hour");
        //draw Y_axis
        imageline($im, $origin_X, $origin_Y, $w - 10, $origin_Y, $green);
        imagettftext($im, 10, 90, 15, $h / 2, $black, $font, "Number of Twitters");
        //draw title
        imagettftext($im, 10, 0, $w / 2 - 50, 15, $black, $font, $this->username . "'s Acititiy In Twitter ");


        // define X, Y of the first bar
        $initial_X_axis = 30;
        $initial_Y_axis = $h-40;
        //draw the bars
        for ($i = 0; $i < 24; $i++) {
            $barcolor = $blue;
            $leftCornerX = $initial_X_axis;
            $leftCornerY = $initial_Y_axis - $maxBarHeight * $this->userActivityData[$i] / $this->count;
            $rightCornerX = $initial_X_axis + $barW;
            $rightCornerY = $initial_Y_axis;
            $currentBarMiddleX = ($initial_X_axis + $initial_X_axis + $barW) / 2-5;
            
            imagefilledrectangle($im, $leftCornerX, $leftCornerY, $rightCornerX, $rightCornerY, $barcolor);
            imagettftext($im, 10, 0, $currentBarMiddleX, $initial_Y_axis + 20, $red, $font, $i);
            imagettftext($im, 10, 0, $currentBarMiddleX, $leftCornerY-10, $red, $font, $this->userActivityData[$i]);
    
            $initial_X_axis +=$barGap;
        }
        // send image header
        header("content-type: image/png");
        // send png image
        imagepng($im);
        imagedestroy($im);
    }

    public function getTimeLinesByUsername($Username) {

		$max = $this->maxPerRequest; //define by twitter API
		$timeslines=array();
		$remaining=$this->maxCount;
		
                
                //get timelines
		$temptimes=$this->connection->get("statuses/user_timeline", array("count" => $max, "screen_name" => $Username, "exclude_replies" => false));
		$fecthedCount = count($temptimes);
		$isFinished = ($fecthedCount!=$max);
		$remaining -= $fecthedCount;
		$timeslines=array_merge($timeslines,$temptimes);
                //loop until we get 500 timelines or  no more than 500 are found
		while(!$isFinished&&$remaining>0){
			
			$nextFetchcount = ($remaining>$max?$max:$remaining);
			
			$max_id = $temptimes[$fecthedCount-1]->id;
			$temptimes=$this->connection->get("statuses/user_timeline", array("count" => $nextFetchcount, "max_id"=>$max_id, "screen_name" => $Username, "exclude_replies" => false));
			$fecthedCount = count($temptimes);
			if($nextFetchcount != $fecthedCount){
				$isFinished = true;
			}
			$remaining -= $fecthedCount;
			$timeslines=array_merge($timeslines,$temptimes);		
		}
		return $timeslines;
    }

    public function getHourFromTimeString($timestring) {
        try {
            $temp = explode(" ", $timestring);
            $temp = explode(":", $temp[3]);
            return intval($temp[0]);
        } catch (Exception $e) {
            return -1;
        }
    }

}
