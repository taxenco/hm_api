# PHP - Technical Test

> Please do not spend too long on this test, 2 hours should be more than sufficient. You may
choose to create a full application with a basic front-end to upload the CSV, or a simple class
that loads the CSV from the filesystem.
>

This task is a chance to show off your OOP PHP programming skills. You may use any package and/or framework you feel suitable.

You have been provided with a CSV from a building operator containing an export of their
property data. The CSV contains both property and room data, our system should only store property and room types. 

Our system stores property data in the following format:

### Data

- id
- property_name
- property_postcode
- rooms
    - id
    - room_name
    - price_per_week
    - rating

Write a program that can accept the CSV and outputs a JSON array in the desired format. 


An example JSON output would be

```
{
	"id": 1,
	"property_name": "Foo",
	"property_postcode": "Bar",
	"rooms": [{
          "id": 2,
          "room_name": "baz",
          "price_per_week": "£100",
          "rating": 5
	}]
}
```
