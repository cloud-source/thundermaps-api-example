#!/usr/bin/env ruby
#
# Example Ruby script that sends a report to ThunderMaps using the ThunderMaps API.
#
# This script requires the HTTParty library (http://johnnunemaker.com/httparty/) but this can be
# replaced by another HTTP library if needed.
#
# HTTParty can usually be installed via `gem install httparty`.
#

require 'httparty'

THUNDERMAPS_API_KEY = 'YOUR API KEY HERE'
THUNDERMAPS_CHANNEL_ID = 'YOUR CHANNEL ID HERE'

class ThunderMaps
  def initialize(key, channel_id)
    @key = key
    @channel_id = channel_id
  end

  def send_report(report)
    url = 'https://www.thundermaps.com/api/v2/reports'
    data = { reports: [report] }.to_json
    params = { account_id: @channel_id }
    headers = { 'Authorization' => "Token token=#{@key}", 'Content-Type' => 'application/json' }
    response = HTTParty.post(url, query: params, body: data, headers: headers)
	if response.code >= 400
      raise "Error sending report: received HTTP #{response.code} from server"
    end
  end
end

if __FILE__ == $0
  # Send a sample report to ThunderMaps.
  thundermaps = ThunderMaps.new(THUNDERMAPS_API_KEY, THUNDERMAPS_CHANNEL_ID)
  thundermaps.send_report({
    latitude: 33.747252,
    longitude: -112.633853,
    address: 'N Ogden Rd, Wittmann, AZ 85361',
    title: 'Giant Triangle',
    description: 'A giant triangle in the desert of Arizona',
    category_name: 'Shape',
    occurred_on: '2016-04-25T12:00:00Z',
    source_id: 'triangle001',
  })
end
