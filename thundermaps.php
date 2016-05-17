#!/usr/bin/env php
<?php
//
// Example PHP script that sends a report to ThunderMaps using the ThunderMaps API.
//

define("THUNDERMAPS_API_KEY", "YOUR API KEY HERE");
define("THUNDERMAPS_CHANNEL_ID", "YOUR CHANNEL ID HERE");

class ThunderMaps {
	private $key;
	private $channel_id;

	public function __construct($key, $channel_id) {
		$this->key = $key;
		$this->channel_id = $channel_id;
	}

	function sendReport($report) {
		$url = "https://www.thundermaps.com/api/v2/reports";
		$data = json_encode(array("reports" => array($report)));
		$params = array("account_id" => $this->channel_id);
		$headers = array("Authorization: Token token=" . $this->key, "Content-Type: application/json");

		$ch = curl_init($url . "?" . http_build_query($params));
		curl_setopt_array($ch, array(
			CURLOPT_POST => TRUE,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POSTFIELDS => $data,
		));
		$response = curl_exec($ch);
		if ($response === FALSE) {
			throw new Exception("Error sending report: " . curl_error($ch));
		}
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if ($status_code >= 400) {
			throw new Exception("Error sending report: received HTTP $status_code from server");
		}
	}
}

if (!debug_backtrace()) {
	// Send a sample report to ThunderMaps.
	$thundermaps = new ThunderMaps(THUNDERMAPS_API_KEY, THUNDERMAPS_CHANNEL_ID);
	$thundermaps->sendReport(array(
		"latitude" => 33.747252,
		"longitude" => -112.633853,
		"address" => "N Ogden Rd, Wittmann, AZ 85361",
		"title" => "Giant Triangle",
		"description" => "A giant triangle in the desert of Arizona",
		"category_name" => "Shape",
		"occurred_on" => "2016-04-25T12:00:00Z",
		"source_id" => "triangle001",
	));
}
?>
