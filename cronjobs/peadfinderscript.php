<?php
set_include_path('/home/adoptape/public_html/');
include_once('simple_html_dom.php');

$context = stream_context_create(
    array(
        "http" => array(
            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
        )
    )
);

include_once('HIDDEN/DB_CONNECTIONS.php');
$conn = OpenMainCon();

$sql = "SELECT * FROM peadfinder ORDER BY lastupdated, pageid;";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['pageid']."<br>";
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
        $html = file_get_html($row['pageurl'], $context);
        $firstComment = $html->find('div#gmi-CComment',0);
        $firstCommentText = $firstComment->find('div.text-ii', 0)->plaintext;
        $firstCommentURL = $firstComment->find('span.cc-time a', 0)->href;
        $updatesql = "UPDATE peadfinder SET lastupdated=".time()." WHERE pageid=".$row['pageid'].";";
        $updateresult = mysqli_query($conn, $updatesql);
        if ($firstCommentURL != $row['lastcacheurl']) {
            $updatesql = "UPDATE peadfinder SET lastcacheurl='".$firstCommentURL."',lastupdated=".time()." WHERE pageid=".$row['pageid'].";";
            $updateresult = mysqli_query($conn, $updatesql);

            define('SLACK_WEBHOOK', 'https://hooks.slack.com/services/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');
            $messagetext = '<'.$firstCommentURL.'|New Bagbeans Comment!> - "'.str_replace("world","Peter",$firstCommentText).'"';
            $message = array('payload' => json_encode(array('text' => $messagetext, 'username' => 'Peadfinder', 'icon_url' => 'https://orig00.deviantart.net/57cb/f/2017/256/2/a/untitled_2_by_griffsnuff_dbcvarv_by_bankofgriffia-dbncczg.png')));
            $c = curl_init(SLACK_WEBHOOK);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, $message);
            curl_exec($c);
            curl_close($c);
        }
        sleep(20);
    }
}

CloseCon($conn);
?>
