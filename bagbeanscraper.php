<?php
include_once('simple_html_dom.php');

$context = stream_context_create(
    array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
    )
);

$url = "https://www.deviantart.com/bagbeans";

// load the list of urls into this page instead
// iterate through all the links
// make sure each call has a 20 second delay
// store the results of the $html into a structure somewhere, either a database, a text file, whatever

ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
$html = file_get_html($url, $context);
$firstComment = $html->find('div#gmi-CComment',0);
echo $firstComment->find('div.text-ii', 0)->innertext;
echo '<a class="btn btn-primary btn-sm" href="'.$firstComment->find('span.cc-time a', 0)->href.'" role="button">Go to Comment</a>';

// similar logic to what's in bagbeanpeadtracker.php:
// if the new result is not a 403 error and it's different from the cache, send a slack message

// NEW PEAD FOUND -> https://deviantart.com/comments/11324j123l4j134
define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
$message = array('payload' => json_encode(array('text' => 'NEW PEAD FOUND -> https://deviantart.com/comments/11324j123l4j134', 'username' => 'Peadfinder', 'icon_url' => 'https://orig00.deviantart.net/57cb/f/2017/256/2/a/untitled_2_by_griffsnuff_dbcvarv_by_bankofgriffia-dbncczg.png')));
$c = curl_init(SLACK_WEBHOOK);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_POSTFIELDS, $message);
curl_exec($c);
curl_close($c);
?>
