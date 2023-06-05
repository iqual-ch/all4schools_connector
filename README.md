# all4schools_connector
This module deals with retrieving data, error management and support
for webform data submission to All4Schools.

## About All4Schools
All4Schools is a course and students management software with an interface
to retrieve/send data about courses and participants.
The data is transmitted as JSON in both directions.

## Module configuration
The module can be configured in drupal under the following path:
/admin/config/services/All4Schools

The following parameters are required:
1. Base url: the API endpoint for your project.
For some project an additional test endpoint can be available.
Use your local settings file to overwrite it.
2. Request id: A unique id pro client.
This should be communicated byt the client / owner of the API.
3. Additionnaly, some implementations might require
an AppUserId for POST requests.
This should be communicated byt the client / owner of the API.
