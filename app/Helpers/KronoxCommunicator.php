<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Models\Booking;
use App\Models\KronoxSession;

class KronoxCommunicator
{
  public static function httpGet($url, $JSESSIONID)
  {
      $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
            "Cookie: JSESSIONID=" . $JSESSIONID . ";\r\n",
            'method'  => 'GET',
        ));
      $context  = stream_context_create($options);

      try {
          $result = file_get_contents($url, false, $context);
          return $result;
      }
      catch (\Exception $e) {
          return null;
      }
  }

  public static function DOMinnerHTML(\DOMNode $element) 
  {
    $innerHTML = ""; 
    $children  = $element->childNodes;

    foreach ($children as $child) 
    { 
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }

    return $innerHTML; 
  }

  public static function getMyBookings($JSESSIONID)
  {
    $url = 'https://webbschema.mdh.se/minaresursbokningar.jsp?flik=FLIK_0001';
    $url = $url . '&datum=' . substr(Carbon::now(), 2, 8);

    $html = KronoxCommunicator::httpGet($url, $JSESSIONID);
    if(empty($html)){
      return [];
    }

    $dom = new \DOMDocument;
    $dom->loadHTML($html);

    $bookings = [];
    foreach ($dom->getElementsByTagName('div') as $div)
    {

        if($div->getAttribute('style') == 'padding:5px;margin-bottom:10px;margin-top:10px;border:1px solid #E6E7E6;background:#FFF;')
        {
            $divInnerHtml = KronoxCommunicator::DOMinnerHTML($div->getElementsByTagName('div')->item(0));

            $temp = new Booking;
            $temp->bookingID = substr($div->getAttribute('id'), 5, 29);
            $temp->date = '20' . KronoxCommunicator::DOMinnerHTML($div->getElementsByTagName('a')->item(0));
            $temp->time = substr($divInnerHtml, 72, 13);
            $temp->booker = substr($divInnerHtml, 90, 8);
            $temp->room = substr($divInnerHtml, 100, 6);
            $temp->message = KronoxCommunicator::DOMinnerHTML($div->getElementsByTagName('small')->item(0));

            $bookings[] = $temp;
        }
    }

    return $bookings;
  }

  public static function getAllBookings($date)
  {
    $session = KronoxSession::where(['user' => Auth::user()->username, 'sessionActive' => 1])->first();

    if(empty($session)){
      flash('No active session found');
      return [];
    }

    $url = 'https://webbschema.mdh.se/ajax/ajax_resursbokning.jsp?op=hamtaBokningar&flik=FLIK_0001';
    $url = $url . '&datum=' . substr($date, 2, 8);

    $html = KronoxCommunicator::httpGet($url, $session->JSESSIONID);
    if(empty($html) || $html == 'Din användare har inte rättigheter att skapa resursbokningar.'){
      return [];
    }

    // to work with åäö and stuff
    $html = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");
      
    $dom = new \DOMDocument;
    $dom->loadHTML($html);

    $rows;

    $headerRow = $dom->getElementsByTagName('tr')->item(0);
    $dom->getElementsByTagName('tr')->item(0)->parentNode->removeChild($headerRow );


    foreach ($dom->getElementsByTagName('tr') as $tableRow)
    {
      $row = [];

      foreach ($tableRow->getElementsByTagName('td') as $cell) {
        if($cell->getAttribute('class') == "grupprum-kolumn"){
          $text = KronoxCommunicator::DOMinnerHTML($cell->getElementsByTagName('b')->item(0));
          $toltip = KronoxCommunicator::DOMinnerHTML($cell->getElementsByTagName('small')->item(0));
          $row[] = ['text' => $text, 'toltip' => $toltip];
        }
        elseif( strpos($cell->getAttribute('class'), 'grupprum-upptagen') !== false){
          $text = substr(trim(KronoxCommunicator::DOMinnerHTML($cell->getElementsByTagName('center')->item(0)), "\t\n\r"), 0 , -3); //Don't ask, magic!
          $toltip = $cell->getAttribute('title');
          $row[] = ['text' => $text, 'toltip' => $toltip];
        }
        elseif ( $cell->getAttribute('class') == "grupprum-ledig grupprum-kolumn" ) {
          $row[] = ['text' => 'Free'];
        }
        elseif ( $cell->getAttribute('class') == "grupprum-passerad grupprum-kolumn" ) {
          $row[] = ['text' => ''];
        }
      }
      $rows[] = $row;
    }

    $rows = array_reverse($rows); // Get U2 rooms on top!

    return $rows;
  }
}
