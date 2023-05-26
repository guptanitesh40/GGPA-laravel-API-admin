<?php
use App\Models\Notification;
use App\Models\FCMUser;
	

define('API_ACCESS_KEY', 'AAAAmywYKGs:APA91bHlYUzpDZgnumTl7av-dHvx7X7OrmVCvX81NaIZKF4dsBX-HrGOxFvBx76yVW7M3hqitMGNxOp57D3v_Qc9L0GAikeLW0teOL-RN2S6EXKO3pvrFJk0UCH47JGMjttC87D52iDX');

function seo_friendly_url($string) {
	$string = strtolower($string);
	$string = str_replace(" ", "-", $string);
	$string = str_replace("--", "-", $string);
	return $string;

}	

function getSortName($name) {
	$nameArr = explode(" ", $name);
	$name = '';
	for($i = 0; $i < count($nameArr); $i++){
	    $name = $name.substr($nameArr[$i], 0, 1); 
	}
	return $name;
}

function s3_asset($filepath) {
	return env('CLOUD_FRONT_URL') . $filepath;
}

function generateRandomString($length=8, $number = false)
{
    if($number) {
        $characters="0123456789";
    } else {
        $characters="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    }
	$charactersLength=(strlen($characters));
	$randomString="";
	for ($i=0; $i <$length ; $i++) 
	{
		$randomString.=$characters[rand(0,$charactersLength-1)];
	}	
	return $randomString;
}

function time_elapsed_string($ptime,$withoutAgo=false)
{
  $etime = time() - $ptime;
  if($withoutAgo) $etime = $ptime - time();
  
    if ($etime < 1)
    {
        return 'Just Now';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'Year',
                 30 * 24 * 60 * 60  =>  'Month',
                      24 * 60 * 60  =>  'Day',
                           60 * 60  =>  'Hour',
                                60  =>  'Minute',
                                 1  =>  'Second'
                );
    $a_plural = array( 'Year'   => 'Years',
                       'Month'  => 'Months',
                       'Day'    => 'Days',
                       'Hour'   => 'Hours',
                       'Minute' => 'Minutes',
                       'Second' => 'Seconds'
                );


    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            if($withoutAgo==true)
              return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);

            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}

function uploadImage($public_path,$image) {

    $image_name=time().md5(rand(100,999)).'.'.$image->getClientOriginalExtension();
    $destinationPath=public_path($public_path);
    $imagePath=$destinationPath.'/'.$image_name;
    $status=$image->move($destinationPath,$image_name);
    if(!$status) return false;
    return $image_name;
}

function addNotification($user_id, $blog_id, $title, $description, $type) {
    $objNotification = new Notification();
    $objNotification->blog_id = $blog_id;
    $objNotification->user_id = $user_id;
    $objNotification->title = $title;
    $objNotification->description = $description;
    $objNotification->type = $type;
    $objNotification->save();
}

function cleanString($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
 
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function addFCMUser($user_id, $fcm_id, $device_id, $type) {
  FCMUser::where([['device_id', '=', $device_id]])->delete();
  $objFCMUser = new FCMUser();
  $objFCMUser->user_id = $user_id;
  $objFCMUser->device_id = $device_id;
  $objFCMUser->fcm_id = $fcm_id;
  $objFCMUser->type = $type;
  return $objFCMUser->save();
}

function send_notification($fcmToken,$msg) {
    try {
      $modualName="send_notification";
      global $con;
      $androidList=array();
      $iosList=array();
  
      foreach ($fcmToken as $key => $value) {
        if($value->type==1) array_push($androidList,$value->fcm_id);
        if($value->type==2) array_push($iosList,$value->fcm_id);
      }

      foreach (array_chunk($iosList, 1000) as $key => $registration_ids) {
        call_msg_ios_notification($registration_ids, $msg); 
      }
  
      foreach (array_chunk($androidList, 1000) as $key => $registration_ids) {
        call_msg_notification($registration_ids, $msg); 
      }
    } catch (\Exception $e) {
      return false;
    }
  }
  
  
  function call_msg_notification($registration_ids, $message){
    
    $url = 'https://fcm.googleapis.com/fcm/send';
    $fields = array(
    'registration_ids' => $registration_ids,
    'notification' => $message,
    'data' => $message
    );


    $headers = array('Authorization: key='.API_ACCESS_KEY,'Content-Type: application/json');
    
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
  
    $result = curl_exec($ch);
    
    curl_close($ch);
  } 
  
  function call_msg_ios_notification($registration_ids, $message){
    
    
    $fields = array(
      'registration_ids' => $registration_ids,
      'notification' => $message,
    );
  
    $headers = array(
      'Authorization: key=' . API_ACCESS_KEY,
      'Content-Type: application/json'
    );
  
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
    $result = curl_exec($ch);
    curl_close( $ch );
  }

  function sendSMS($phone, $message) {

	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=smoVDrQmAEiUEgsjijGUNQ&senderid=VPLPTL&channel=2&DCS=0&flashsms=0&number=91'.$phone.'&text='.urlencode($message).'&route=clickhere&EntityId=1501405420000042426&dlttemplateid=1507165547323241649',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	));

	$response = curl_exec($curl);
	curl_close($curl);
	return json_decode($response);
  }
 
?>