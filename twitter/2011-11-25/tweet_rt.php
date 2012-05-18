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
	$gyoukai = array("業界","機械","造船重機","工作機械","自動車","自動車部品","建設機械","中古車","バイク・二輪車","プラント","化粧品","家庭用品","教育サービス","経営コンサル","広告","出版","テレビ","携帯コンテンツ","ビール","食品総合","アパレル","清涼飲料水","製薬医薬品","鉄道","銀行","証券","航空","ドラッグストア","電力","ガス","外食総合","ファミレス","高速道路","不動産","総合商社","レジャー施設","介護サービス","専門商社","印刷","水産・農林","海運","旅行","繊維","携帯キャリア","ネットメディア","家電・電機");

	$sheet_num = mt_rand(1,45);
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

	$tweet_text = "#本当の年収は？ ".$gyoukai[$sheet_num]."業界年収".$inc_arr[$inc_num][0]."位、".$inc_arr[$inc_num][1]."の"."平均年収は ".$inc_arr[$inc_num][2]."万円。 #年収";
	fclose($fp); 
	if(empty($inc_arr[$inc_num][0])){
		if($sheet_num % 2 == 1){
		$tweet_text = "こちらは年収botです。年収についてつぶやきます。会社選びに迷ったら会社は年収で選びましょう。 #年収";
		}else{
		$tweet_text = "こちらは年収botです。就活にご興味がおありですか？私は年収についてつぶやきます。会社選びの参考にどうぞ。 #年収";
		}
	}
// TwitterへPOSTするときのパラメーターなど詳しい情報はTwitterのAPI仕様書を参照してください

$req = $to->OAuthRequest("http://search.twitter.com/search.json","GET",array("q"=>
"就活"));//$inc_arr[$inc_num][1]));

$json = json_decode($req);

	if(empty($json->results)){
		exit;
	}

	$target_id = $json->results[0]->from_user;
	$tweet_id = $json->results[0]->id;

	if($target_id == "nenshu_bot"){
		exit;
	}

$req = $to->OAuthRequest("http://api.twitter.com/1/statuses/update.xml","POST",array("status"=>"@$target_id $tweet_text","in_reply_to_status_id"=>"$tweet_id"));

header("Content-Type: application/xml");
echo $req;
?>
