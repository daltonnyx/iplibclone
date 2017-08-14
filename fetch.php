<?php
session_start();
function get($idx, $SESSID) {
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "http://iplib.noip.gov.vn/WebUI/WDetail.php?ref=&HitListViewMode=Text&intRecNum=".$idx,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
		"cookie: QueryValue=%20; QueryValue1=%20; PHPSESSID=$SESSID"
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	return $response; 
}

function post($field, $SESSID) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://iplib.noip.gov.vn/WebUI/WSearch.php",
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "clkButton=submit&hidLang=vi&hidQueryContent=%2B%24%7C%24%7CTN%24%7C%09&slbField1=AN&slbOper1=%3D&txtField1=*".$field."*&slbBool2=AND&slbField2=NC&slbOper2=%3D&txtField2=&slbBool3=AND&slbField3=Vienna&slbOper3=%3D&txtField3=&slbBool4=AND&slbField4=GS&slbOper4=%3D&txtField4=&btnSubmit=T%C3%ACm%2Bki%E1%BA%BFm&=",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "cookie: QueryValue=%20; QueryValue1=%20; PHPSESSID=$SESSID",
        "origin: http://iplib.noip.gov.vn",
        "referer: http://iplib.noip.gov.vn/WebUI/WSearch.php",
        "upgrade-insecure-requests: 1",
        "user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36"
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    return $response;
}

function fetch($SESSID) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://iplib.noip.gov.vn/WebUI/WHitList.php",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_COOKIE => "PHPSESSID=$SESSID",
      CURLOPT_HTTPHEADER => array(
        "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
        "accept-encoding: gzip, deflate",
        "accept-language: en-US,en;q=0.8,vi;q=0.6",
        "connection: keep-alive",
        "cookie: QueryValue=%20; QueryValue1=%20; PHPSESSID=$SESSID;",
        "host: iplib.noip.gov.vn",
        "referer: http://iplib.noip.gov.vn/WebUI/WSearch.php",
        "user-agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.78 Safari/537.36"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);
    return $response;
}

if(!$argv[1])
    die("enter start year");
if(!$argv[2])
    die("enter end year");
$session_id = session_id();
for($year = $argv[1]; $year <= $argv[2]; $year++) {
    if(post($year,$session_id)) {
        echo "fetching $year using $session_id \r\n";
        $response = fetch($session_id);
        $matches = [];
        echo $response;
        preg_match_all("/(\d+) bản ghi/",$response, $matches);
        $total = intval($matches[1][0]);
        for($i = 1; $i < $total; $i++) {
            if(file_exists("./data/$year-$i.html")) {
                echo "skip $year-$i \r\n";
                continue;
            }
            echo "get $i/$total in $year using $session_id \r\n";
            while(!$data = get($i,$session_id)) {
                usleep(1000);
                echo "try getting $i/$total in $year using $session_id \r\n";
            }
            $doc = new DOMDocument();
            @$doc->loadHTML($data);
            $tables = $doc->getElementsByTagName("table");
            $list_data = $tables->item(6);
            $item_table = $list_data->ownerDocument->saveHTML($list_data);
            $file = fopen("./data/".$year.'-'.$i.'.html',"w");
            echo "writing to ./data/$year-$i.html \r\n";
            fwrite($file, $item_table);
            fclose($file);
        }
    }
    else {
        echo "faile to fetch $year";
    }
}
