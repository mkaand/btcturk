<?php
/*
BTCTürk Order/Withdraw/Deposit RSS Feed v1.0
Credits: CryptoYakari @CryptoYakari
Reqierments :
PHP Host
Demo Page: https://robostopia.com/btcturk/

This script generates an RSS Feed for your latest BTCTürk Order/Withdraw/Deposit
You can use this RSS feed with IFTTT.com and easily integrate
RSS -> Telegram or RSS->Email
Once your order completed you will get notification.
*/
include("src/Client.php");

$key = 'YOUR_API_KEY';
$secret = 'YOUR_API_SECRET';
$b = new Client ($key, $secret);
$transactions = json_decode(json_encode($b->getUserTransactions()), True);
$recordcount = Count($transactions);
//var_dump ($transactions);
header('Content-type: application/xml');
echo 
'<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
		<channel>
		<title>Robostopia Spam Check Feed</title>
		<description>BTCTurk Transactions RSS Feed</description>
		<link>https://robostopia.com/btcturk/</link>
		<copyright>Kaan Dogan</copyright>
		<atom:link href="https://robostopia.com/btcturk/" rel="self" type="application/rss+xml" />
			';

		For ($i = 0; $i < $recordcount; $i++) {	// CHECK ALL ENTRIES

			$amount = $transactions[$i]["amount"];
			$currency = $transactions[$i]["currency"];
			$transaction_date = strtotime($transactions[$i]["date"]);
			$id = $transactions[$i]["id"];
		
			If ($amount > 0){$buysell = ' alış';}Else {$buysell = ' satış';}
		
			If ($transactions[$i]["operation"] === "deposit"){$operation = ' yatırma işlemi gerçekleşti.';$desc = 'İşleminiz ';}
			If ($transactions[$i]["operation"] === "withdraw"){$operation = ' çekme işlemi gerçekleşti.';$desc = 'İşleminiz ';}
			If ($transactions[$i]["operation"] === "trade"){$operation = $buysell . ' emriniz gerçekleşti.';$desc = 'İşleminiz ' . $transactions[$i]["price"] . ' birim fiyatından ';}
			
Echo 		'<item>
				<title>BTCTürk '. abs($amount) . ' ' . $currency . $operation .'</title>
				<description>'.$desc.date('d.m.Y H:i:s',$transaction_date).' tarihinde gerçekleşmiştir.</description>
				<link>https://robostopia.com/btcturk/'.$amount.'</link>
				<pubDate>'.date(DATE_RSS,$transaction_date).'</pubDate>
				<guid isPermaLink="false">'.$amount.'</guid>
			</item>
			';



		}	Echo 	
'
		</channel>
</rss>';
?>