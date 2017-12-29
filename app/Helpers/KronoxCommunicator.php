<?php

namespace App\Helpers;

use Carbon\Carbon;

use App\Models\Booking;

class KronoxCommunicator
{
    public static function httpGet($url, $JSESSIONID){
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

    $dom = new \DOMDocument;
    $dom->loadHTML($html);

    $bookings;
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
}
