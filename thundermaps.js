#!/usr/bin/env node
//
// Example NodeJS script that sends a report to ThunderMaps using the ThunderMaps API.
//
// This script requires the Request library (https://github.com/request/request) but this can be
// replaced by another HTTP library if needed.
//
// Request can usually be installed via `npm install request`.
//

var request = require("request");
var sha1 = require("sha1");

const THUNDERMAPS_API_KEY = "YOUR API KEY HERE"
const THUNDERMAPS_CHANNEL_ID = "YOUR CHANNEL ID HERE"

function ThunderMaps(key) {
	this.key = key;
}

ThunderMaps.prototype.sendReport = function(report) {
    var options = {
        uri: "https://www.thundermaps.com/api/v4/reports/upsert",
        method: "POST",
        headers: {
            "Authorization": "Token token=" + this.key,
            "Content-Type": "application/json",
            "X-AppID": "com.thundermaps.main",
            "X-InstallationID": "thundermaps-api-" + sha1(this.key),
        },
        json: {
            report: report,
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

if (require.main === module) {
    // Send a sample report to ThunderMaps.
    var thundermaps = new ThunderMaps(THUNDERMAPS_API_KEY);
    thundermaps.sendReport({
        account_id: THUNDERMAPS_CHANNEL_ID,
        location: {
            latitude: 33.747252,
            longitude: -112.633853,
        },
        address: "N Ogden Rd, Wittmann, AZ 85361",
        description: "A giant triangle in the desert of Arizona",
        source_id: "triangle001",
    });
}
