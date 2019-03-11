<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Init class for Radium_Tweets.
 *
 * Loads all of the necessary components for the radium tweets plugin.
 *
 * @since 1.0.0
 *
 * @package Radium_Tweets
 * @author  Franklin Gitonga
 */

class Radium_Tweets_Functions {

    public static function getConnectionWithAccessToken( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret ) {
        $connection = new TwitterOAuth( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );
        return $connection;
    }

    // MAKE LINKS CLICKABLE
    public static function convert_links( $status, $targetBlank = true, $linkMaxLen = 250 ){

        // TARGET
        $target=$targetBlank ? " target=\"_blank\" " : "";

        // CONVERT LINK TO URL
        $status = preg_replace("/((http:\/\/|https:\/\/)[^ )]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);

        // CONVERT @ TO FOLLOW
        $status = preg_replace("/(@([_a-z0-9\-]+))/i","<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>",$status);

        // CONVERT # TO SEARCH
        $status = preg_replace("/(#([_a-z0-9\-]+))/i","<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>",$status);

        // RETURN THE STATUS
        return $status;
    }

    // CONVERT DATES TO RELATIVE TIME
    public static function relative_time($a) {

        // GET CURRENT TIMESTAMP
        $b = strtotime("now");
        // GET TWEET TIMESTAMP
        $c = strtotime($a);
        // GET DIFFERENCE
        $d = $b - $c;
        // GET TIME VALUES
        $minute = 60;
        $hour = $minute * 60;
        $day = $hour * 24;
        $week = $day * 7;

        if(is_numeric($d) && $d > 0) {
            // IF LESS THAN 3 SECONDS
            if($d < 3) return "right now";
            // IF LESS THAN 1 MINUTE
            if($d < $minute) return floor($d) . " seconds ago";
            // IF LESS THAN 2 MINUTES
            if($d < $minute * 2) return "about 1 minute ago";
            // IF LESS THAN 1 HOUR
            if($d < $hour) return floor($d / $minute) . " minutes ago";
            // IF LESS THAN 2 HOURS
            if($d < $hour * 2) return "about 1 hour ago";
            // IF LESS THAN 1 DAY
            if($d < $day) return floor($d / $hour) . " hours ago";
            // IF MORE THEN 1 DAY, BUT LESS THEN 2 DAYS
            if($d > $day && $d < $day * 2) return "yesterday";
            // IF LESS THAN 1 YEAR
            if($d < $day * 365) return floor($d / $day) . " days ago";
            // ELSE RETURN OVER A YEAR AGO
            return "over a year ago";
        }

    }

}
