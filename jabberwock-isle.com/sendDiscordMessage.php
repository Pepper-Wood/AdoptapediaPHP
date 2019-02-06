<?php
include_once('../HIDDEN/DISCORD_WEBHOOKS.php');

$usernames = array(
    "bobblehead"=>"Stupid, Sexy Bobblehead",
    "monomi"=>"Monomi",
    "monokuma"=>"Monokuma",
    "mystery"=>"???",
    "tom"=>"Sheriff Texas Tom",
    "confusedtom"=>"Sheriff Texas Tom",
    "feduptom"=>"Sheriff Texas Tom",
    "fredtom"=>"Sheriff Texas Tom",
    "memetom"=>"Sheriff Texas Tom"
);
$usericons = array(
    "bobblehead"=>"https://orig00.deviantart.net/08ef/f/2018/330/9/a/extracharacter_by_pepper_wood-dcsxymc.png",
    "monomi"=>"https://orig00.deviantart.net/dd86/f/2018/330/7/3/286258_202497_by_pepper_wood-dcsxys1.png",
    "monokuma"=>"https://orig00.deviantart.net/5b4b/f/2018/330/c/c/tumblr_oxflkg6gvd1wpkntco1_250_by_pepper_wood-dcsxyrr.png",
    "mystery"=>"https://orig00.deviantart.net/1bae/f/2018/330/3/8/hey____by_pepper_wood-dcsxyno.png",
    "tom"=>"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp7n-0513caa3-a2ba-4d21-b7dc-408f7500c269.png",
    "confusedtom"=>"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp7y-7d54c5b4-35ee-44fb-9b0d-96e20758a897.png",
    "feduptom"=>"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp77-b2cc1623-0d43-4d83-8cce-1318c377d6cc.png",
    "fredtom"=>"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp87-c1177870-124b-4313-9571-7c1c8a911d8c.jpg",
    "memetom"=>"https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/intermediary/f/01ff5c95-4bc2-4441-be8f-87f5d74105a7/dctgp8l-58cc6d1f-ef23-4768-b021-8b5deb13094e.png"
);

echo "webhookindex = ".$_POST['chat']."\n";
echo "webhookurl = ".$webhooks[$_POST['chat']]."\n";
echo "username = ".$usernames[$_POST['user']]."\n";
echo "usericon = ".$usericons[$_POST['user']]."\n";
echo "messagetext = ".$_POST['messagetext']."\n";

postToJabberwockDiscord($webhooks[$_POST['chat']], $usernames[$_POST['user']], $usericons[$_POST['user']], $_POST['messagetext']);
?>
