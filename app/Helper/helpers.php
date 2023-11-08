<?php

use App\Models\User;
use App\Models\ClaimProfit;
use \Illuminate\Support\Str;
use App\Models\ReferralBonus;
use Carbon\Carbon;
use App\Models\Investment;

use App\Models\Transaction;

function template($asset = false)
{
    $activeTheme = config('basic.theme');
    if ($asset) return 'assets/themes/' . $activeTheme . '/';
    return 'themes.' . $activeTheme . '.';
}


function recursive_array_replace($find, $replace, $array)
{
    if (!is_array($array)) {
        return str_replace($find, $replace, $array);
    }
    $newArray = [];
    foreach ($array as $key => $value) {
        $newArray[$key] = recursive_array_replace($find, $replace, $value);
    }
    return $newArray;
}

function menuActive($routeName, $type = null)
{
    $class = 'active';
    if ($type == 3) {
        $class = 'selected';
    } elseif ($type == 2) {
        $class = 'has-arrow active';
    } elseif ($type == 1) {
        $class = 'in';
    }
    if (is_array($routeName)) {
        foreach ($routeName as $key => $value) {
            if (request()->routeIs($value)) {
                return $class;
            }
        }
    } elseif (request()->routeIs($routeName)) {
        return $class;
    }
}


function getFile($image, $clean = '')
{
    return file_exists($image) && is_file($image) ? asset($image) . $clean : asset(config('location.default'));
}

function removeFile($path)
{
    return file_exists($path) && is_file($path) ? @unlink($path) : false;
}

function loopIndex($object)
{
    return ($object->currentPage() - 1) * $object->perPage() + 1;
}

function getAmount($amount, $length = 0)
{
    if (0 < $length) {
        return number_format($amount + 0, $length);
    }
    return $amount + 0;
}


function strRandom($length = 12)
{
    $characters = 'ABCDEFGHJKMNOPQRSTUVWXYZ123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function diffForHumans($date)
{
    $lang = session()->get('lang');
    \Carbon\Carbon::setlocale($lang);
    return \Carbon\Carbon::parse($date)->diffForHumans();
}

function dateTime($date, $format = 'd M, Y h:i A')
{
    return date($format, strtotime($date));
}
if (!function_exists('putPermanentEnv')) {
    function putPermanentEnv($key, $value)
    {
        $path = app()->environmentFilePath();
        $escaped = preg_quote('=' . env($key), '/');
        file_put_contents($path, preg_replace(
            "/^{$key}{$escaped}/m",
            "{$key}={$value}",
            file_get_contents($path)
        ));
    }
}

function checkTo($currencies, $selectedCurrency = 'USD')
{
    foreach ($currencies as $key => $currency) {
        if (property_exists($currency, strtoupper($selectedCurrency))) {
            return $key;
        }
    }
}

function code($length)
{
    if ($length == 0) return 0;
    $min = pow(10, $length - 1);
    $max = 0;
    while ($length > 0 && $length--) {
        $max = ($max * 10) + 9;
    }
    return random_int($min, $max);
}
function invoice(){

    return time().code(4);
}
function wordTruncate($string, $offset = 0, $length = null): string
{
    $words = explode(" ", $string);
    isset($length) ? array_splice($words, $offset, $length) : array_splice($words, $offset);
    return implode(" ", $words);
}

function linkToEmbed($string)
{
    if (strpos($string, 'youtube') !== false) {
        $words = explode("/", $string);
        if (strpos($string, 'embed') == false) {
            array_splice($words, -1, 0, 'embed');
        }
        $words = str_ireplace('watch?v=', '', implode("/", $words));
        return $words;
    }
    return $string;
}


function slug($title)
{
    return \Illuminate\Support\Str::slug($title);
}
function title2snake($string)
{
    return Str::title(str_replace(' ', '_', $string));
}

function snake2Title($string)
{
    return Str::title(str_replace('_', ' ', $string));
}

function kebab2Title($string)
{
    return Str::title(str_replace('-', ' ', $string));
}

function getLevelUser($id)
{
    $ussss = new \App\Models\User();
    return $ussss->referralUsers([$id]);
}

function getPercent($total, $current)
{
    if ($current > 0 && $total > 0) {
        $percent = (($current * 100) / $total) ?: 0;
    } else {
        $percent = 0;
    }
    return round($percent, 0);
}

function flagLanguage($data)
{
    return  '{'.rtrim($data, ',').'}';
}

function getIpInfo()
{
    $ip = null;
    $deep_detect = TRUE;

    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

    $country = @$xml->geoplugin_countryName;
    $city = @$xml->geoplugin_city;
    $area = @$xml->geoplugin_areaCode;
    $code = @$xml->geoplugin_countryCode;
    $long = @$xml->geoplugin_longitude;
    $lat = @$xml->geoplugin_latitude;


    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $os_platform = "Unknown OS Platform";
    $os_array = array(
        '/windows nt 10/i' => 'Windows 10',
        '/windows nt 6.3/i' => 'Windows 8.1',
        '/windows nt 6.2/i' => 'Windows 8',
        '/windows nt 6.1/i' => 'Windows 7',
        '/windows nt 6.0/i' => 'Windows Vista',
        '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
        '/windows nt 5.1/i' => 'Windows XP',
        '/windows xp/i' => 'Windows XP',
        '/windows nt 5.0/i' => 'Windows 2000',
        '/windows me/i' => 'Windows ME',
        '/win98/i' => 'Windows 98',
        '/win95/i' => 'Windows 95',
        '/win16/i' => 'Windows 3.11',
        '/macintosh|mac os x/i' => 'Mac OS X',
        '/mac_powerpc/i' => 'Mac OS 9',
        '/linux/i' => 'Linux',
        '/ubuntu/i' => 'Ubuntu',
        '/iphone/i' => 'iPhone',
        '/ipod/i' => 'iPod',
        '/ipad/i' => 'iPad',
        '/android/i' => 'Android',
        '/blackberry/i' => 'BlackBerry',
        '/webos/i' => 'Mobile'
    );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform = $value;
        }
    }
    $browser = "Unknown Browser";
    $browser_array = array(
        '/msie/i' => 'Internet Explorer',
        '/firefox/i' => 'Firefox',
        '/safari/i' => 'Safari',
        '/chrome/i' => 'Chrome',
        '/edge/i' => 'Edge',
        '/opera/i' => 'Opera',
        '/netscape/i' => 'Netscape',
        '/maxthon/i' => 'Maxthon',
        '/konqueror/i' => 'Konqueror',
        '/mobile/i' => 'Handheld Browser'
    );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser = $value;
        }
    }

    $data['country'] = $country;
    $data['city'] = $city;
    $data['area'] = $area;
    $data['code'] = $code;
    $data['long'] = $long;
    $data['lat'] = $lat;
    $data['os_platform'] = $os_platform;
    $data['browser'] = $browser;
    $data['ip'] = request()->ip();
    $data['time'] = date('d-m-Y h:i:s A');

    return $data;
}



function resourcePaginate($data,$callback){
    return $data->setCollection($data->getCollection()->map($callback));
}


function clean($string) {
    $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function camelToWord($str) {
    $arr =  preg_split('/(?=[A-Z])/',$str);
    return trim(join(' ',$arr));
}


function in_array_any($needles, $haystack) {
    return (bool) array_intersect($needles, $haystack);
}



function adminAccessRoute($search) {
    $list = collect(config('role'))->pluck('access')->flatten()->intersect(auth()->guard('admin')->user()->admin_access);


    if (is_array($search)) {
        $list = $list->intersect($search);
        if(0 < count($list)){
            return true;
        }
        return  false;
    } else {

        return $list->search(function($item) use ($search) {
            if($search == $item){
                return true;
            }
            return false;
        });
    }
}


function ProfitClaimed($invest_id,$plan_id,$userId) {
    $data =  ClaimProfit::where('status','active')->where('invest_id',$invest_id)->where('plan_id',$plan_id)->where('user_id',$userId)->sum('profit_amount');
    return $data;
}




function LevelOneTotal($id){

    $users_id = User::where('referral_id', $id)->pluck('id');

    $ref_level_1 = LevelOneMember($id);


    $total_ref = User::where('referral_id', $id)->count('id');


    return $total_ref ;
}


function LevelTwoTotal($id){

    $level_1 = User::where('referral_id', $id)->pluck('id');

    $total_user_lvl_2 = User::whereIn('referral_id', $level_1)->get();

    $ref_level_2 = LevelTwoMember($id);

    $total = count($total_user_lvl_2);

    return $total;


}
function LevelThreeTotal($id){

    $level_1 = User::where('referral_id', $id)->pluck('id');
    $level_2 = User::whereIn('referral_id', $level_1)->pluck('id');

    $total_user_lvl_3 = User::whereIn('referral_id', $level_2)->get();

    $ref_level_3 = LevelThreeMember($id);

    $total = count($total_user_lvl_3);

    return $total;

}




function LevelOneMember($id){

    $total_ref = User::where('referral_id', $id)->pluck('id');

    $ref_level_1 = Investment::groupBy('user_id')
    ->whereIn('user_id', $total_ref)
    ->get();

    return count($ref_level_1);
}
function LevelOneMemberDetails($id){

    $total_ref = User::where('referral_id', $id)->pluck('id');

    $ref_level_1 = Investment::groupBy('user_id')
    ->whereIn('user_id', $total_ref)
    ->get();

    return $ref_level_1;
}

function LevelOneMemberAllDetails($id){

    $total_ref = User::where('referral_id', $id)->paginate(config('basic.paginate'));
    return $total_ref;
}

function LevelTwoMember($id){
    $level_1 = User::where('referral_id', $id)->pluck('id');
    $level_2 = User::whereIn('referral_id', $level_1)->pluck('id');

    $ref_level_2 = Investment::groupBy('user_id')
    ->whereIn('user_id', $level_2)
    ->get();

    return count($ref_level_2);

}
function LevelTwoMemberDetails($id){
    $level_1 = User::where('referral_id', $id)->pluck('id');
    $level_2 = User::whereIn('referral_id', $level_1)->pluck('id');

    $ref_level_2 = Investment::groupBy('user_id')
    ->whereIn('user_id', $level_2)
    ->get();

    return $ref_level_2;
}

function LevelTwoMemberAllDetails($id){
    $level_1 = User::where('referral_id', $id)->pluck('id');
    $level_2 = User::whereIn('referral_id', $level_1)->paginate(config('basic.paginate'));
    return $level_2;
}

function LevelThreeMember($id){

    $level_1 = User::where('referral_id', $id)->pluck('id');
    $level_2 = User::whereIn('referral_id', $level_1)->pluck('id');
    $level_3 = User::whereIn('referral_id', $level_2)->pluck('id');

    $ref_level_3 = Investment::groupBy('user_id')
    ->whereIn('user_id', $level_3)
    ->get();

    return count($ref_level_3);
}

function LevelThreeMemberDetails($id){

    $level_1 = User::where('referral_id', $id)->pluck('id');
    $level_2 = User::whereIn('referral_id', $level_1)->pluck('id');
    $level_3 = User::whereIn('referral_id', $level_2)->pluck('id');

    $ref_level_3 = Investment::groupBy('user_id')
    ->whereIn('user_id', $level_3)
    ->get();

    return $ref_level_3;
}

function LevelThreeMemberAllDetails($id){

    $level_1 = User::where('referral_id', $id)->pluck('id');
    $level_2 = User::whereIn('referral_id', $level_1)->pluck('id');
    $level_3 = User::whereIn('referral_id', $level_2)->paginate(config('basic.paginate'));


    return $level_3;
}

function IsActiveUser($id){

    $ref_level_1 = Investment::groupBy('user_id')
    ->where('user_id', $id)
    ->get();
    return $ref_level_1;
}


function LevelOneInactive($id){

    $users_id = User::where('referral_id', $id)->pluck('id');

    $ref_level_1 = LevelOneMember($id);


    $total_ref = User::where('referral_id', $id)->count('id');


    return $total_ref - $ref_level_1;
}


function LevelTwoInactive($id){

    $level_1 = User::where('referral_id', $id)->pluck('id');

    $total_user_lvl_2 = User::whereIn('referral_id', $level_1)->get();

    $ref_level_2 = LevelTwoMember($id);

    $total = count($total_user_lvl_2) - $ref_level_2;

    return $total;


}
function LevelThreeInactive($id){

    $level_1 = User::where('referral_id', $id)->pluck('id');
    $level_2 = User::whereIn('referral_id', $level_1)->pluck('id');

    $total_user_lvl_3 = User::whereIn('referral_id', $level_2)->get();

    $ref_level_3 = LevelThreeMember($id);

    $total = count($total_user_lvl_3) - $ref_level_3;

    return $total;

}

function TodayProfit($id){

    $bonus = ReferralBonus::where('from_user_id', $id)
    ->where('type', 'invest')
    ->whereDate('created_at', Carbon::today())
    ->sum('amount');

    return number_format((float)$bonus, 2, '.', '');
}
function WeeklyProfit($id){

    $bonus = ReferralBonus::where('from_user_id', $id)
    ->where('type', 'invest')
    ->where( 'created_at', '>', Carbon::now()->subDays(7))
    ->sum('amount');

    return number_format((float)$bonus, 2, '.', '');
}
function AllTOtalProfit($id){

    $bonus = ReferralBonus::where('from_user_id', $id)
    ->where('type', 'invest')
    ->sum('amount');

    return number_format((float)$bonus, 2, '.', '');
}




function getMemberLevel($id){

    $level_1 = User::where('referral_id', $id)->pluck('id');
    $level_2 = User::whereIn('referral_id', $level_1)->pluck('id');


    $total_1 = Investment::whereIn('user_id', $level_1)->groupBy('user_id')->get();

    $total_2 = Investment::whereIn('user_id', $level_2)->groupBy('user_id')->get();

    $final = count($total_1) + count($total_2);

    return $final;
}

function getLevelByTotal($total)
{
    if ($total < 20 && $total >= 0) {
        return 0;
    }else if($total >= 20 &&  $total < 45){
        return 1;
    }else if($total >= 45  && $total < 100){
        return 2;
    }else if($total >= 100 && $total < 225){
        return 3;
    }else if($total >= 225 && $total < 500){
       return 4;
    } else {
        return 5;
    }
}

function getLevelMembers($level)
{
    if ($level == 0) {
        return 0;
    }
    if($level == 1){
        return 20;
    }
    if($level == 2){
        return 45;
    }
    if($level == 3){
        return 100;
    }
    if($level == 4){
        return 225;
    }
    return 500;
}

function getNextLevel($level)
{
    if ($level == 0) {
        return 1;
    }
    if($level == 1){
        return 2;
    }
    if($level == 2){
        return 3;
    }
    if($level == 3){
        return 4;
    }
    if($level == 4){
        return 5;
    }
    return 5;
}

function getLevelName($level)
{
    if ($level == 0) {
        return "Agen Standar";
    }
    if($level == 1){
        return "Agen VIP 1";
    }
    if($level == 2){
        return "Agen VIP 2";
    }
    if($level == 3){
        return "Agen VIP 3";
    }
    if($level == 4){
        return "Agen VIP 4";
    }
    return "Agen Spesial";
}

function getCardImage($level)
{
    return asset('assets/frontend/images/badges/card-'.$level.'.png');
}

function getBadgeImage($level)
{
    return asset('assets/frontend/images/badges/badge-'.$level.'.png');
}