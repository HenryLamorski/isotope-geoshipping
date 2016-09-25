# isotope-geoshipping
geobased Shippingmethod for isotope ecommerce for contao.

## Behavior

The extension calculates the distance (kilometers) of two postalcodes (only germany yet) and
multiply the result with the price configured in backend.

Be aware: this distance calculation differs from results of a routing planer tool (open streetmaps,google maps). 
The reason for this is we use the airline distance without streets. So i recommend to calculate the price correspondingly.

## Features

- minimum- and maximum prices configurable
- multpiple postalcodes for each goods warehouse/branch for distance calculation

## Useage

- Setup a new shippingmethod, use "geoShipping".
- Optional set a minimum and maximum price
- Optional set postalcodes for multiple goods warehouse/branch
- Set a price/km
