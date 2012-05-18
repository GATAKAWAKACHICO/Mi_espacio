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

//フォロワーリスト(user_id)を取得
$req = $to->OAuthRequest("http://api.twitter.com/1/followers/ids.xml","GET",array("screen_name"=>"nenshu_bot"));

//フォロワーリストの最新の人のIDを取得する。
$xml = simplexml_load_string($req);
$new_follower_id = $xml->ids->id[0];

//フォロワーリストの最新の人とのfriendshipを調べる。(こちらがフォローしているかどうか)
$req2 = $to->OAuthRequest("http://api.twitter.com/1/friendships/show.xml","GET",array("source_screen_name"=>"nenshu_bot", "target_id"=>"$new_follower_id"));
	$xml_show = simplexml_load_string($req2);
	$new_follower_screen_name = $xml_show->target->screen_name;
	$follow_bool = $xml_show->source->following;
	$followed_by_bool = $xml_show->source->followed_by;
	
	if($followed_by_bool == "true" && $follow_bool == "false"){
				//ファイルのオープン
				$filename = '/home/wktk/www/Mi_espacio/twitter/2011-11-25/last_follower.txt';
				$fp = fopen($filename,'r+');
				flock($fp, LOCK_EX);
				$last_follower_id = fgets($fp, '20');//最後にフォローしてくれた人のID
				
			if($last_follower_id != $new_follower_id){
				//ファイルポインタを先頭に移動
				rewind($fp);
				//ファイルに新しくフォローしてくれた人のIDを書きこみ
				fwrite($fp, $new_follower_id);
				//ロックの開放
				flock($fp, LOCK_UN);
				//ファイルのクローズ
				fclose($fp);
				//フォローしてくれた人にお礼
				$hour = date("H");
				$thx_main_mes = "こちらは年収botです。フォローして頂きまして、ありがとうございます。私はただのbotです。私には年収をつぶやくことしかできません。めざせ年収１０００万円。";
				$greeting0 = "遅くまでおつかれさまです。";
				$greeting1 = "おはようございます。";
				$greeting2 = "こんにちは。";
				$greeting3 = "こんばんは。";

if($hour == "00"||$hour == "01"){
				$thx_mes = $greeting0.$thx_main_mes;
				}else if($hour == "07"||$hour == "08"||$hour == "09"||$hour == "10"){
				$thx_mes = $greeting1.$thx_main_mes;
}else if($hour == "11"||$hour == "12"||$hour == "13"||$hour == "14"||$hour == "15"||$hour == "16"||$hour == "17"){
	 $thx_mes = $greeting2.$thx_main_mes;
}else if($hour == "18"||$hour == "19"||$hour == "20"||$hour == "21"||$hour == "22"||$hour == "23"){
	 $thx_mes = $greeting3.$thx_main_mes;
}

				$req3 = $to->OAuthRequest("http://api.twitter.com/1/statuses/update.xml","POST",array("status"=>"@$new_follower_screen_name $thx_mes", "in_reply_to_user_id"=>"$new_follower_id"));
				//フォローしていない人をフォローする(現在は使用停止中)
				/*$req4 = $to->OAuthRequest("http://api.twitter.com/1/friendships/create.xml","POST",array("user_id"=>"$new_follower"));*/
			}
	}else{
			//ロックの開放
			flock($fp, LOCK_UN);
			//ファイルのクローズ
			fclose($fp);
	}
	
/*$req = $to->OAuthRequest("http://api.twitter.com/1/friendships/create.xml","POST",array("user_id"=>"$new_follower"));*/

/*$req = $to->OAuthRequest("http://api.twitter.com/1/statuses/update.xml","POST",array("status"=>"reply", "in_reply_to_user_id"=>"$new_follower"));*/
// TwitterへPOSTするときのパラメーターなど詳しい情報はTwitterのAPI仕様書を参照してください

header("Content-Type: application/xml");
echo $req2;

?>
