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
$GLOBALS['TL_LANG']['tl_iso_shipping']['geoshipping_legend'] = 'geobasierte Frachtkostenberechnung';

$GLOBALS['TL_LANG']['tl_iso_shipping']['price'][0] = 'Preis/km';
$GLOBALS['TL_LANG']['tl_iso_shipping']['price'][1] = 'Preis je Entfernungskilometer';

$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_maxprice'][0] = 'max. Gesamtpreis';
$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_maxprice'][1] = 'Höchstpreis: z.B.: es sei 1 Euro/km gegeben, bei 1000km würden 1000 Euro Kosten errechnet werden. Soll jedoch nicht mehr als 800 Euro berechnet werden, dann kann durch Eingabe von 800 die Kosten limitiert werden.';

$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_minprice'][0] = 'mindest Gesamtpreis';
$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_minprice'][1] = 'Mindestpreis: z.B.: es sei 1 Euro/km gegeben, bei 10km würden 10 Euro Kosten errechnet werden. Soll jedoch mindestens 59 Euro berechnet werden, dann kann durch Eingabe von 59 die Kosten als Minimum definiert werden.';

$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_postalcodes'][0] = 'abweichende Postleitzahlen';
$GLOBALS['TL_LANG']['tl_iso_shipping']['gs_postalcodes'][1] = 'Es wird jene Postleitzahl als Berechnungsstartpunkt verwendet, die am nähesten am Zielpunkt (Lieferadresse) liegt. Sinnvoll für Filialsystem mit mehreren Zwischenlägern.Eingabe als CSV: z.B. 06749, 06808, 06193.';
