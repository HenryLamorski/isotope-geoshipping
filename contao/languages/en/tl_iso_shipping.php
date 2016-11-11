<?php
/**
 * GeoShipping extension for Isotope eCommerce provides an shipping-method that calculates the shippingprice based on kilometers between shop-postalcode and shipping-postalcode
 *
 * Copyright (c) 2016 Henry Lamorski
 *
 * @package GeoShipping
 * @author  Henry Lamorski <henry.lamorski@mailbox.org>
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_iso_shipping']['geoshipping_legend'] = 'geobased calculation of shippingcosts';

$GLOBALS['TL_LANG']['tl_iso_shipping']['price'][0] = 'price/km';
$GLOBALS['TL_LANG']['tl_iso_shipping']['price'][1] = 'price per distancekilometer';

$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_maxprice'][0] = 'max. grossprice';
$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_maxprice'][1] = 'maximum price: e.g.: lets assume you charge 1 Euro/km, therefore for 1000km your calculation would be 1000 Euro. Further in our mindgame, the maximum Shipping-Charge is limited to 800 Euro. To achive this behavior, you can Enter 800 in this Field.';

$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_minprice'][0] = 'minimum grossprice';
$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_minprice'][1] = 'minimum price: e.g.: letz assume you charge 1 Euro/km, therfore for 10km your calculation would be 10 Euro. Further in out mindgame, the minimum Shipping-Charge has a minimum of 49 Euro. To controll such a example, you can enter a minimum price here (e.g. 49 Euro).';

$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_postalcodes'][0] = 'different postalcodes';
$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_postalcodes'][1] = 'use this field for different postalcodes of your company. The cheapest postalcode (nearest to shipping-target) will be used for calculation. Enter as CSV: e.g. 06749, 06808, 06193.';
