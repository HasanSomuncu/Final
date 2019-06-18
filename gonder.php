<?php
$curl = curl_init();
$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiIyYjQzNDU4MC1mMzU2LTRjZjMtYmU1Zi1iOTA1YTYyYWMyYzAifQ.mUPqv1O1x8B9vMzTvPIDEbWgL87I_6rSEDkPQ5Dmc-4";
$vars='{
    "tokens": ["e6cmmfX3kkk:APA91bGhQAtve1aT5N5NCIc5NKF9lLei9g11Sn4vc6tzpvFKMdA4wRlrZnP0IBoGVbvM1hu8Q7iIuKohXSk2BBZvsSBUgfdVvralonRglOWl_F7Y3LSesGCK5j9vgwPLVRvWhag23AlO"],
    "profile":"test",
    "notification": {
        "message":"This is my demo push!"
    }

}';

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://api.ionic.io/push/notifications",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_POSTFIELDS => $vars,
	CURLOPT_HTTPHEADER => array(
		"Authorization: Bearer $token",
		"Content_Type: application/json"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if($err){
	echo "cURL Error #:" . $err;

}else {
	echo $response;
}

?>