<?php

function my_asset($path, $secure = null)
{
    return app('url')->asset('public/' . $path, $secure);
}

function format_price($amount)
{
    return env('APP_CURRENCY') . number_format($amount, 2);
}

function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    if (($lat1 == $lat2) && ($lon1 == $lon2)) {
        return 0;
    } else {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }
}

if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if (($asset = \App\Models\Attachment::find($id)) != null) {
            return my_asset('uploads/'.$asset->attachment);
        }
        return "";
    }
}

// Firebase notification generator
function send_firebase_notification($array)
{
    $tokens = [];
    $device_token = $array['device_token'];
    foreach ($device_token as $value) {
        $tokens[] = $value->token;
    } 
    if (count($tokens)) {
        $postfields = array(
            "registration_ids" => $tokens,
            "priority" => "high",
            "importance" => "max",
            "notification" => array(
                "body" => $array['title'],
                "title" => env('APP_NAME')
            ));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($postfields),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . env('FIREBASE_NOTIFICATION_API'),
                'Content-Type: application/json'
            ),
        ));

        // $response = curl_exec($curl);
        curl_exec($curl);
        curl_close($curl);
    }
}
