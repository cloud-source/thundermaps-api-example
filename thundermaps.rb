#!/usr/bin/env ruby
#
# Example Ruby script that sends a report to ThunderMaps using the ThunderMaps API.
#
# This script requires Ruby 1.9 or higher.
#
# This script requires the HTTParty library (http://johnnunemaker.com/httparty/) but this can be
# replaced by another HTTP library if needed.
#
# HTTParty can usually be installed via `gem install httparty`.
#

require 'digest/sha1'
require 'httparty'

THUNDERMAPS_API_KEY = 'YOUR API KEY HERE'
THUNDERMAPS_CHANNEL_ID = 'YOUR CHANNEL ID HERE'

class ThunderMaps
  def initialize(key)
    @key = key
  end

  def send_report(report)
    url = 'https://www.thundermaps.com/api/v4/reports/upsert'
    data = { report: report }.to_json
    headers = {
        'Authorization' => "Token token=#{@key}",
        'Content-Type' => 'application/json',
        'X-AppID' => 'com.thundermaps.main',
        'X-InstallationID' => "thundermaps-api-#{Digest::SHA1.hexdigest @key}",
    }
    response = HTTParty.post(url, body: data, headers: headers)
	if response.code >= 400
      raise "Error sending report: received HTTP #{response.code} from server"
    end
  end
end

if __FILE__ == $0
  # Send a sample report to ThunderMaps.
  thundermaps = ThunderMaps.new(THUNDERMAPS_API_KEY)
  thundermaps.send_report({
    account_id: THUNDERMAPS_CHANNEL_ID,
    location: {
        latitude: 33.747252,
        longitude: -112.633853,
    },
    address: 'N Ogden Rd, Wittmann, AZ 85361',
    description: 'A giant triangle in the desert of Arizona',
    source_id: 'triangle001',
  })
end
