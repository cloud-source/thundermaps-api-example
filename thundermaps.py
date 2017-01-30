#!/usr/bin/env python3
#
# Example Python script that sends a report to ThunderMaps using the ThunderMaps API.
#
# This script requires the Requests library (http://www.python-requests.org/en/master/) but this can
# be replaced by another HTTP library if needed.
#
# Requests can usually be installed via `pip install requests`.
#

import hashlib
import json

import requests

THUNDERMAPS_API_KEY = "YOUR API KEY HERE"
THUNDERMAPS_CHANNEL_ID = "YOUR CHANNEL ID HERE"

class ThunderMaps(object):
	def __init__(self, key):
		self.key = key

	def send_report(self, report):
		url = "https://www.thundermaps.com/api/v4/reports/upsert"
		data = json.dumps({"report": report})
		headers = {
			"Authorization": "Token token=%s" % self.key,
			"Content-Type": "application/json",
            "X-AppID": "com.thundermaps.main",
            "X-InstallationID": "thundermaps-api-%s" % hashlib.sha1(self.key.encode("utf-8")).hexdigest(),
		}
		try:
			response = requests.post(url, data=data, headers=headers)
			response.raise_for_status()
		except requests.exceptions.HTTPError as e:
			raise Exception("Error sending report: received HTTP %d from server" % e.response.status_code)

if __name__ == "__main__":
	# Send a sample report to ThunderMaps.
	thundermaps = ThunderMaps(THUNDERMAPS_API_KEY)
	thundermaps.send_report({
        "account_id": THUNDERMAPS_CHANNEL_ID,
        "location": {
            "latitude": 33.747252,
            "longitude": -112.633853,
        },
		"address": "N Ogden Rd, Wittmann, AZ 85361",
		"description": "A giant triangle in the desert of Arizona",
		"source_id": "triangle001",
	})
