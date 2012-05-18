<?php
$date = date("Y-m-d");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=320, user-scalable=no, initial-scale=1, maximum-scale=1">
<script src="../src/jquery-1.6.1.min.js"></script>
<link href="../css/style.css" rel="stylesheet" type="text/css">
<title>Mi espacio</title>
</head>
<body>
<div id="content">
	<div id="form" style="color:white; padding:10px 10px 0px 10px; height:450px;">
	<form method="post" action="config.php">
	name <input type="text" name="name" class="register"><br>
	Comment<br>
	<textarea name="comment" cols="40" rows="5" class="register"></textarea><br>
	address   <input type="text" name="address" id="address" size="40"><br>
	<input type="button" value="geocoding" onclick="geocode()"><br><br>

	Latitude  <input type="text" name="latitude" id="latitude" value="" class="register"><br>
	Longitude <input type="text" name="longitude" id="longitude" value=""><br>
	<input type="button" value="現在地緯度経度取得" onclick="run()"><br><br>

	date     <input type="text" name="date" value="<?php echo $date; ?>" class="register"><br>
	password <input type="password" name="password" size="10"><br>
	<input type="submit" value="送信">
	</form>
	</div><!-- end of form -->
</div>
<script type="text/javascript">
function run() {
        navigator.geolocation.getCurrentPosition(callback);
    }
 
    function callback(position) {
        lat = position.coords.latitude
        lng = position.coords.longitude;
        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
    }
    function geocode(){
    	var xml;
    	var originalURL="http://maps.google.com/maps/api/geocode/xml?address=" + encodeURIComponent(document.getElementById("address").value) + "&sensor=true";

		getXML("geocoding.php?url=" + escape(originalURL));

		function getXML(url){
  			xml = objXML();
  			xml.open('GET',url,true);
  			xml.onreadystatechange = function(){
    			if(xml.readyState == 4){
      			geocodingData = xml.responseXML;//xmlのレスポンス
      			geometry = geocodingData.getElementsByTagName("geometry");
      			lat = geometry[0].getElementsByTagName("location")[0].getElementsByTagName("lat")[0].textContent;
      			lng = geometry[0].getElementsByTagName("location")[0].getElementsByTagName("lng")[0].textContent;
      		document.getElementById("latitude").value = lat;
      		document.getElementById("longitude").value = lng;
    }
  };
  xml.send(null);
}
function objXML(){
  try{
    return new XMLHttpRequest();
  }catch(e){
    try{
      return new ActiveXObject('Msxml2.XMLHTTP');
    }catch(e){
      try{
        return new ActiveXObject('Microsoft.XMLHTTP');
      }catch(e){
        return null;
      }
    }
  }
}
    }
</script>
</body>
</html>