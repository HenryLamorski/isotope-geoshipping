# isotope-geoshipping
geobased Shippingmethod for isotope ecommerce for contao.

## Behavior

The extension calculates the distance (kilometers) of two postalcodes based on google-maps-api results and
multiply the result with the price configured in backend. 

Be aware: if you use the buildin distantcalculation (not the google-distance-matrix-api) the distance calculation differs from results of a routing planer tool (open streetmaps,google maps). 
The reason for this is we use the airline distance without streets. So i recommend to calculate the price correspondingly or use the google-distance-matrix-api.

## Features

- minimum- and maximum prices configurable
- multpiple postalcodes for each goods warehouse/branch for distance calculation
- supports google-distance-matrix-api

## Useage

- Setup a new shippingmethod, use "geoShipping".
- Optional set a minimum and maximum price
- Optional set postalcodes for multiple goods warehouse/branch
- Set a price/km
