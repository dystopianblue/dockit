## Dockit REST API

The Dockit REST API is a web service that provides routes to a destination using Toronto's Bike Share system.  It finds the best walking-cycling paths based on bike/dock availability, and returns 5 useful stats for each route: distance, time, calories burned, CO2 offset and gas money saved from cycling.  Points are earned for every bike trip and a scoring system was devised based on the 5 metrics.  The API leverages the Google Maps API to find optimal directions and routes.  User data, such as profile info, stats and trip history, are also accessible through the Dockit API.  Built with the Laravel PHP framework during the Bike Share Toronto Hackathon (4th place winners).


### API calls
All REST API calls can be tested using the server at http://dockit.dystopianblue.com/ (ie. http://dockit.dystopianblue.com/api/v1/stations)


##### GET /api/v1/stations
* Retrieves all Bike Share stations in Toronto with real-time bike/dock availability and lat,lng coords

#####  GET /api/v1/legs/start/{start}/end/{end}
Response:  
```
{  
  "startLeg": {data for walking from start to start station},  
  "stationLegs": [  
     {route #1 data},  
     {route #2 data},  
     {route #3 data}  
  ],  
  "endLeg": {data for walking from ending station to destination},  
  "walking": {data for walking from start to destination only}  
}  
```

* Retrieves all routes from {start} to {end}
* {start} and {end} can be strings or lat,lng coords
* Accounts for 16,790 total possible route variations between Bike Share Toronto docks
* Metrics:
  - distance: m
  - duration: sec
  - caloriesMen or caloriesWomen: C
  - carbonOffset: g of CO2
  - gasPrice: $

#####  GET /api/v1/users/{id}
* Based on fake data generated from trips data set provided by Bike Share Toronto
* Assuming each unique postal code represents a unique Bike Share member
* Returns profile info, such as username and gender
* Currently 3,884 total fake users created

#####  GET /api/v1/users/{id}/trips
* Based on fake data generated from trips data set provided by Bike Share Toronto
* Returns a user's trip history ordered from most recent to oldest
* Currently 682,890 total sample trips stored in the system

#####  GET /api/v1/users/{id}/dailyTotals
#####  GET /api/v1/users/{id}/weeklyTotals
#####  GET /api/v1/users/{id}/monthlyTotals
#####  GET /api/v1/users/{id}/allTimeTotals
* Based on fake data generated from trips data set provided by Bike Share Toronto
* Daily, weekly, monthly and all-time statistics for a user

#####  GET /api/v1/scoreboard/dailyTotals/{month}-{day}-{year}
#####  GET /api/v1/scoreboard/weeklyTotals/{week number (1-52)}
#####  GET /api/v1/scoreboard/monthlyTotals/{month}-{year}
#####  GET /api/v1/scoreboard/allTimeTotals
* Daily, weekly, monthly and all-time scoreboard for all Bike Share members

#####  GET /api/v1/users/{id}/badges
* Return all badges earned by user


### Dockit Scoring System
* Every 100m cycled = 1 point
* Every 30 secs cycled = 1 point
* Every 10 C burned = 1 point
* Every 125 g CO2 offset = 1 point
* Every $0.10 of gas money saved = 1 point


### Assumptions Made for Stats
* Assume average man is 170lbs and woman is 145lbs and average bike speed at 15-17km/h (10mph)
* Average man burns 8 calories/min and woman burns 7 calories/min (http://www.bicycling.com/training-nutrition/training-fitness/cycling-calories-burned-calculator)
* Assume 250g of CO2e/km (0.25g of CO2e/m) is saved bicycling vs driving (http://www.ecf.com/news/how-much-co2-does-cycling-really-save/)
* Assume 7.9L/100 km (0.000079L/m) gas saved from bicycling vs driving at $1.30/L for regular gas


### Developer

Ray Yick, Dystopian Blue (ray@dystopianblue.com)
