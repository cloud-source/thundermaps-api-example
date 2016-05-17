#!/usr/bin/env node
//
// Example NodeJS script that sends a report to ThunderMaps using the ThunderMaps API.
//
// This script requires the Request library (https://github.com/request/request) but this can be
// replaced by another HTTP library if needed.
//

var request = require("request");

const THUNDERMAPS_API_KEY = "YOUR API KEY HERE"
const THUNDERMAPS_CHANNEL_ID = "YOUR CHANNEL ID HERE"

function ThunderMaps(key, channel_id) {
	this.key = key;
	this.channel_id = channel_id;
}

ThunderMaps.prototype.sendReport = function(report) {
    var options = {
        uri: "https://www.thundermaps.com/api/v2/reports",
        method: "POST",
        qs: {
            account_id: this.channel_id,
        },
        headers: {
            "Authorization": "Token token=" + this.key,
        },
        json: {
            reports: [report]
        },
    }

    request(options, function(error, response, body) {
        if (error) {
			console.log("Error sending report: " + error);
        } else if (response.statusCode >= 400) {
			console.log("Error sending report: received HTTP " + response.statusCode + " from server");
        }
    });
};

module.exports = ThunderMaps;

// Send a sample report to ThunderMaps.
var thundermaps = new ThunderMaps(THUNDERMAPS_API_KEY, THUNDERMAPS_CHANNEL_ID);
thundermaps.sendReport({
	latitude: 33.747252,
	longitude: -112.633853,
	address: "N Ogden Rd, Wittmann, AZ 85361",
	title: "Giant Triangle",
	description: "A giant triangle in the desert of Arizona",
	category_name: "Shape",
	occurred_on: "2016-04-25T12:00:00Z",
	source_id: "triangle001",
})
