<?php
require "TwitterUserActivity.php";

$username = $_POST["username"];
$twitterActivity = new TwitterUserActivity($username);
$twitterActivity->render();
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

