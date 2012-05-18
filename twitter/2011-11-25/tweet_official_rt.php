<?php
// twitteroauth.phpを読み込む。パスはあなたが置いた適切な場所に変更してください
require_once("/home/wktk/www/Mi_espacio/twitter/2011-11-25/twitteroauth.php");

// Consumer keyの値
$consumer_key = "1jKh59HClCB2hqWQxWbs4w";
// Consumer secretの値
$consumer_secret = "IokbwDr59EiM9zFrza0HAPTX0cLqDbr9LWqqX9wFsY";
// Access Tokenの値
$access_token = "420515572-E4oWCj0txSaQm0axgeaVVVgSU0cU2UmawKMLKrhO";
// Access Token Secretの値
$access_token_secret = "ZmSwjuoBA2QC9iHIygfEQr3OAS60c92tQUJRbgfR0";

// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

// TwitterへPOSTする。パラメーターは配列に格納する
// in_reply_to_status_idを指定するのならば array("status"=>"@hogehoge reply","in_reply_to_status_id"=>"0000000000"); とする。
	$tweet_text = "年収についてつぶやきます。"; 

$req = $to->OAuthRequest("https://api.twitter.com/1/statuses/mentions.xml","GET",array("include_entities"=>"true"));
	$xml_mentions = simplexml_load_string($req);
	$will_retweet_id = $xml_mentions->status[0]->id;
	//var_dump($will_retweet_id);
	//var_dump($xml_mentions);
// TwitterへPOSTするときのパラメーターなど詳しい情報はTwitterのAPI仕様書を参照してください
$req2 = $to->OAuthRequest("http://api.twitter.com/1/statuses/retweet/".$will_retweet_id.".xml","POST",array("include_entities"=>"true"));

header("Content-Type: application/xml");
echo $req2;
?>
