<?php
$username="xx@xx.xx";
$password="supersercret";

$yale["host"]="https://mob.yalehomesystem.co.uk/yapi";
$yale["key"]="VnVWWDZYVjlXSUNzVHJhcUVpdVNCUHBwZ3ZPakxUeXNsRU1LUHBjdTpkd3RPbE15WEtENUJ5ZW1GWHV0am55eGhrc0U3V0ZFY2p0dFcyOXRaSWNuWHlSWHFsWVBEZ1BSZE1xczF4R3VwVTlxa1o4UE5ubGlQanY5Z2hBZFFtMHpsM0h4V3dlS0ZBcGZzakpMcW1GMm1HR1lXRlpad01MRkw3MGR0bmNndQ==";
$yale["auth"]="/o/token/";
$yale["services"]="/services/";
$yale["mode"]="/api/panel/mode/";
$yale["devicestatus"]="/api/panel/device_status/";
// do auth
$url=$yale["host"].$yale["auth"];
print "Authorizing against: $url\n";
$payload = [
	'username' => $username,
	'password' => $password,
	'grant_type' => "password"
];
$handle = curl_init();
$headers=array("Authorization: Basic ".$yale["key"]);
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_POST, true);
curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_POSTFIELDS, $payload);
curl_setopt($handle, CURLOPT_VERBOSE, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);		// Yale ssl certificate is exipred !! :/
$data = curl_exec($handle);
curl_close($handle);
$response=json_decode($data, true);
print "data:-";
print_r($response);
print "-\n";
if ( !isset($response["access_token"] ) )
		die("Server error\n");
$refresh_token=$response["refresh_token"];
$access_token=$response["access_token"];

// Get device data
$url = $yale["host"].$yale["devicestatus"];
print "Getting data from: $url\n";
$handle = curl_init();
$aheaders=array("Authorization: Bearer ".$access_token);
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_HTTPHEADER, $aheaders);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);		// Yale ssl certificate is exipred !! :/
$raw=curl_exec($handle);
$data=json_decode($raw, true);

print_r($data);
?>