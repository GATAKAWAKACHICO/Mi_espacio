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
	$gyoukai = array("業界","機械","造船重機","工作機械","自動車","自動車部品","建設機械","中古車","バイク・二輪車","プラント","化粧品","家庭用品","教育サービス","経営コンサル","広告","出版","テレビ","携帯コンテンツ","ビール","食品総合","アパレル","清涼飲料水","製薬医薬品","鉄道","銀行","証券","航空","ドラッグストア","電力","ガス","外食総合","ファミレス","高速道路","不動産","総合商社");

	$sheet_num = mt_rand(1,34);
	$filename = "/home/wktk/www/Mi_espacio/twitter/2011-11-25/sheet".$sheet_num.".csv";
	$fp = fopen($filename, "r");
	if(!$fp){
		exit;	
	}
		$inc_arr = array();

		while(!feof($fp)){ 
			$str = fgetcsv($fp);
			array_push($inc_arr,$str); 
		}
	$inc_arr_num = count($inc_arr) - 1;
	$inc_num = mt_rand(0,$inc_arr_num);

	$tweet_text = $gyoukai[$sheet_num]."業界年収".$inc_arr[$inc_num][0]."位、".$inc_arr[$inc_num][1]."の"."平均年収は ".$inc_arr[$inc_num][2]."万円。";
	fclose($fp);

	if(empty($inc_arr[$inc_num][0])){
                $tweet_text = "年収についてつぶやきます。";
        } 

$req = $to->OAuthRequest("http://api.twitter.com/1/statuses/update.xml","POST",array("status"=>$tweet_text));


// TwitterへPOSTするときのパラメーターなど詳しい情報はTwitterのAPI仕様書を参照してください

header("Content-Type: application/xml");
echo $req;

?>
