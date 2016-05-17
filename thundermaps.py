#!/usr/bin/env python
#
# Example Python script that sends a report to ThunderMaps using the ThunderMaps API.
#
# This script requires the Requests library (http://www.python-requests.org/en/master/) but this can
# be replaced by another HTTP library if needed.
#
# Requests can usually be installed via `pip install requests`.
#

import json

import requests

THUNDERMAPS_API_KEY = "YOUR API KEY HERE"
THUNDERMAPS_CHANNEL_ID = "YOUR CHANNEL ID HERE"

class ThunderMaps(object):
	def __init__(self, key, channel_id):
		self.key = key
		self.channel_id = channel_id

	def send_report(self, report):
		url = "https://www.thundermaps.com/api/v2/reports"
		data = json.dumps({"reports": [report]})
		params = {"account_id": self.channel_id}
		headers = {"Authorization": "Token token=%s" % self.key, "Content-Type": "application/json"}
		try:
			response = requests.post(url, params=params, data=data, headers=headers)
			response.raise_for_status()
		except requests.exceptions.HTTPError as e:
			raise Exception("Error sending report: received HTTP %d from server" % e.response.status_code)

if __name__ == "__main__":
	# Send a sample report to ThunderMaps.
	thundermaps = ThunderMaps(THUNDERMAPS_API_KEY, THUNDERMAPS_CHANNEL_ID)
	thundermaps.send_report({
		"latitude": 33.747252,
		"longitude": -112.633853,
		"address": "N Ogden Rd, Wittmann, AZ 85361",
		"title": "Giant Triangle",
		"description": "A giant triangle in the desert of Arizona",
		"category_name": "Shape",
		"occurred_on": "2016-04-25T12:00:00Z",
		"source_id": "triangle001",
	})
