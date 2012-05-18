<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=320, user-scalable=no, initial-scale=1, maximum-scale=1">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<title>Mi espacio</title>
</head>
<body>
<div id="content">
	<div id="header">
	<img src="../images/mi_espacio.png">
	</div>
	<br>
	
	<div style="text-align:center; margin:auto; color:white; height:450px;">
<?php
//ポストされたもの
$name = htmlspecialchars($_POST["name"]);
$comment = htmlspecialchars($_POST["comment"]);
$date = htmlspecialchars($_POST["date"]);
$lat = htmlspecialchars($_POST["latitude"]);
$lng = htmlspecialchars($_POST["longitude"]);
$pw = htmlspecialchars($_POST["password"]);
if($pw != 1990){
	echo "Password doesn't match.";
	exit();
}
$new_place = array('name'=>$name, 'date'=>$date, 'latitude'=>$lat, 'longitude'=>$lng, 'comment'=>$comment );

//JSONファイルを開く
$data = "../places/data.json";
$handle = fopen($data, 'r');
//JSONフォーマットから配列に変換して読み込み
$json_places = json_decode(fread($handle, filesize($data)),true);
fclose($handle);

//データを１階層分分解
foreach ($json_places as $value) {
    $json_arrange_places = $value;
}

//新データを追加
array_push($json_arrange_places, $new_place);

$new_json_places = array('places'=>$json_arrange_places);

$handle = fopen($data, 'w');
$write_result = fwrite($handle,json_encode($new_json_places));
fclose($handle);
if($write_result == true){
echo "Yeah! new place was registered successfully.";
}else{
echo "Woops! An error occured.";
}
?>
	</div>
</div>
</body>
</html>