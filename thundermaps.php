#!/usr/bin/env php
<?php
//
// Example PHP script that sends a report to ThunderMaps using the ThunderMaps API.
//
// This script requires the php-curl module.
//

define("THUNDERMAPS_API_KEY", "YOUR API KEY HERE");
define("THUNDERMAPS_CHANNEL_ID", "YOUR CHANNEL ID HERE");

class ThunderMaps {
	private $key;

	public function __construct($key) {
		$this->key = $key;
	}

	function sendReport($report) {
		$url = "https://www.thundermaps.com/api/v4/reports/upsert";
		$data = json_encode(array("report" => $report));
		$headers = array(
            "Authorization: Token token=" . $this->key,
            "Content-Type: application/json",
            "X-AppID: com.thundermaps.main",
            "X-InstallationID: thundermaps-api-" . sha1($this->key),
        );

		$ch = curl_init($url);
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
	$thundermaps = new ThunderMaps(THUNDERMAPS_API_KEY);
	$thundermaps->sendReport(array(
        "account_id" => THUNDERMAPS_CHANNEL_ID,
        "location" => array(
            "latitude" => 33.747252,
            "longitude" => -112.633853,
        ),
		"address" => "N Ogden Rd, Wittmann, AZ 85361",
		"description" => "A giant triangle in the desert of Arizona",
		"source_id" => "triangle001",
	));
}
?>
