Copyright 2016 Cloudsource Limited. Licenced under the MIT Licence, see COPYRIGHT File for details.

ThunderMaps API Examples
========================

This repository contains examples in several different programming languages that show how to use the ThunderMaps API. To run the examples you will need to obtain a ThunderMaps API key and channel ID.

Obtaining API Key and Channel ID
--------------------------------
You can obtain your API Key and Channel ID for any ThunderMaps channel you are allowed to report to by:

1. Going to https://www.thundermaps.com/control_panel
1. Select the channel you want to send reports to from the drop down box on the right
1. Click the 'Integrations' Tab
1. Click the 'ThunderBot' Intergration

API key
-------
To use any of these examples you will need a ThunderMaps API key. If you do not have one, you will need to create a ThunderMaps account at https://www.thundermaps.com/starts/new.

Once you have your API key you will need to replace any occurence of `YOUR API KEY HERE` in the examples with your API key.

Channel ID
----------
In order to send a report you will need to create a channel to submit it to. You can do this at https://www.thundermaps.com/accounts/new.

Once you have your channel ID you will need to replace any occurence of `YOUR CHANNEL ID HERE` in the examples with your channel ID.

Installation ID
---------------
The installation ID sent in the `X-InstallationID` header should be unique per user per IP address. The examples hash the API key to ensure uniqueness per user but if you are going to access the API on multiple machines using the same API key, you should make sure that it is different on each machine.

Fields
------
The fields that can be specified in a report are:

* `account_id` - The ID of the channel to post the report to.
* `location` - A dictionary containing the `latitude` and `longitude` of the location of the report.
* `address` - A string containing the address of the location of the report.
* `description` - A string containing a description of the report. Requires a "Description" field to be added via the control panel.
* `source_id` - A unique ID for this report. This is what is used to update existing reports.

While only one of `location` or `address` is required, both are recommended.

Contributors
------------
If you would like to contribute to this example code, please fork the repository and send through a pull request.
