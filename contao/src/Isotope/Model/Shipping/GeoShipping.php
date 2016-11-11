<?php
/**
 * GeoShipping extension for Isotope eCommerce provides an shipping-method that calculates the shippingprice based on kilometers between shop-postalcode and shipping-postalcode
 *
 * Copyright (c) 2016 Henry Lamorski
 *
 * @package GeoShipping
 * @author  Henry Lamorski <henry.lamorski@mailbox.org>
 */


namespace Isotope\Model\Shipping;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Haste\Http\Response\Response;
use Isotope\Interfaces\IsotopeProductCollection;
use Isotope\Interfaces\IsotopeShipping;
use Isotope\Isotope;
use Isotope\Model\Shipping;


/**
 * Class RadioImage
 * @property integer $radioImageGallery The gallery to parse the image label
 * @package Isotope\Model\Attribute
 */
class GeoShipping  extends Shipping implements IsotopeShipping
{
    private $fileData;
    const OGDB_EARTH_RADIUS = 6371;

    protected function ogdbGetData()
    {
        if(!$this->fileData)
        {
    		$this->fileData = file_get_contents(
                dirname(__FILE__).'/../../../../assets/plugins/ogdb_distance_lib/DE.tab'
            );
        }
     	return $this->fileData;
	}

    protected function ogdbDataStructure($explodedRow) 
    {
        $dataStructure = FALSE;
    	if ( count($explodedRow) == 5 ) 
        { // PLZ.tab
    		$dataStructure = array('zip_pos' => 1, 'lon_pos' => 2, 'lat_pos' => 3);
    	}
    	if ( count($explodedRow) == 16 ) {
    		$dataStructure = array('zip_pos' => 7, 'lon_pos' => 5, 'lat_pos' => 4);
    	}
    	return $dataStructure;
    }

    protected function ogdbDistance($origin,$destination)
    {
    	$fileData = explode("\n",$this->ogdbGetData());

       	foreach ( $fileData as $fileRow ) 
        {
    		$fileRow = explode("\t",$fileRow);
    		$dataStructure = $this->ogdbDataStructure($fileRow);
		    if ( $dataStructure ) 
            {
    			if 
                ( 
                    isset($fileRow[$dataStructure['zip_pos']]) && 
                    isset($fileRow[$dataStructure['lon_pos']]) && 
                    isset($fileRow[$dataStructure['lat_pos']]) 
                ) 
                {
	    			if ( substr_count($fileRow[$dataStructure['zip_pos']],$origin) == 1 ) 
                    {
	    				$origin_lon = deg2rad($fileRow[$dataStructure['lon_pos']]);
	    				$origin_lat = deg2rad($fileRow[$dataStructure['lat_pos']]);
	    			}
	    			if ( substr_count($fileRow[$dataStructure['zip_pos']],$destination) == 1 ) 
                    {
	    				$destination_lon = deg2rad($fileRow[$dataStructure['lon_pos']]);
	    				$destination_lat = deg2rad($fileRow[$dataStructure['lat_pos']]);
	    			}
    			}
    		}
	    	unset($dataStructure,$fileRow);
    	}
        $distance = FALSE;
    	if ( isset($origin_lon) && isset($origin_lat) && isset($destination_lon) && isset($destination_lat) ) 
        {
    		$distance = acos(sin($destination_lat)*sin($origin_lat)+cos($destination_lat)*cos($origin_lat)*cos($destination_lon - $origin_lon))*self::OGDB_EARTH_RADIUS;
	    }
    	return $distance;
    }

    // $sort = "asc", "desc" or "" for nothing
    protected function ogdbRadius($zip,$km,$sort='asc') 
    {
    	$fileData = explode("\n",$this->ogdbGetData());
	    foreach ( $fileData as $fileRow ) 
        {
	    	$fileRow = explode("\t",$fileRow);
	    	$dataStructure = $this->ogdbDataStructure($fileRow);
    		if ( 
                isset($fileRow[$dataStructure['zip_pos']]) && 
                isset($fileRow[$dataStructure['lon_pos']]) && 
                isset($fileRow[$dataStructure['lat_pos']]) 
            ) 
            {
	    		if ( substr_count($fileRow[$dataStructure['zip_pos']],$zip) == 1 ) 
                {
	    			$origin_lon = $fileRow[$dataStructure['lon_pos']];
	    			$origin_lat = $fileRow[$dataStructure['lat_pos']];
	    			$id = $fileRow[0];
	    		}
    		}
    		unset($dataStructure, $fileRow);
    	}

    	$lambda = $origin_lon * pi() /180;
	    $phi = $origin_lat * pi() / 180;
    	// Umwandlung der Kurgelkoordinaten ins kartesische Koordinatensystem
    	$geoKoordX = self::OGDB_EARTH_RADIUS * cos($phi) * cos($lambda);
	    $geoKoordY = self::OGDB_EARTH_RADIUS * cos($phi) * sin($lambda);
	    $geoKoordZ = self::OGDB_EARTH_RADIUS * sin($phi);
    	$data = array();
    	if ( isset($origin_lon) && isset($origin_lat) && isset($id) ) 
        {
    		foreach ( $fileData as $fileRow ) 
            {
    			$fileRow = explode("\t",$fileRow);
	    		$dataStructure = $this->ogdbDataStructure($fileRow);
	    		if 
                ( 
                    isset($fileRow[$dataStructure['zip_pos']]) && 
                    isset($fileRow[$dataStructure['lon_pos']]) && 
                    isset($fileRow[$dataStructure['lat_pos']]) 
                ) 
                {
    				$distance =  2*self::OGDB_EARTH_RADIUS * asin(
    					SQRT(
        					pow($geoKoordX - (OGDB_EARTH_RADIUS * cos($fileRow[$dataStructure['lat_pos']]*pi()/180) * cos($fileRow[$dataStructure['lon_pos']]*pi() /180)),2)
        					+pow($geoKoordY - (OGDB_EARTH_RADIUS * cos($fileRow[$dataStructure['lat_pos']]*pi()/180) * sin($fileRow[$dataStructure['lon_pos']]*pi() /180)),2)
		        			+pow($geoKoordZ - (OGDB_EARTH_RADIUS * sin($fileRow[$dataStructure['lat_pos']]*pi()/180)),2)
	        			) / (2*self::OGDB_EARTH_RADIUS)
                    );
    				if( $distance < $km && $id <> $fileRow[0]  ) 
                    {
    					$data[$distance] = array('loc_id'=>$fileRow[0],'name'=>$fileRow[3],'zip'=>$fileRow[$dataStructure['zip_pos']],'distance'=>$distance);
	    			}
    				unset($distance);
    			}
	    		unset($dataStructure, $fileRow);
    		}
    	}
    	switch ( $sort ) 
        {
    		case 'asc':
	    		ksort($data);
	    		break;
	    	case 'desc':
	    		krsort($data);
	    		break;
	    }
	    return $data;
    }


	public function callGoogleApi()
	{
		$strOrigins = str_replace(","," ",Isotope::getConfig()->postal." ".Isotope::getConfig()->city);
		$strDest    = str_replace(",","",Isotope::getCart()->getShippingAddress()->postal." ".Isotope::getCart()->getShippingAddress()->city);

        $body = file_get_contents('php://input');
        $url  = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$strOrigins.'&destinations='.$strDest.'&key='.$this->gs_apikey;

            if (class_exists('GuzzleHttp\Client')) {
                $request = new Client(
                    [
                        RequestOptions::TIMEOUT         => 5,
                        RequestOptions::CONNECT_TIMEOUT => 5,
                        RequestOptions::HTTP_ERRORS     => false,
                    ]
                );

                $response = $request->get($url, [RequestOptions::BODY => $body]);

                if ($response->getStatusCode() != 200) {
                    throw new \RuntimeException($response->getReasonPhrase());
                }

				$result = json_decode($response->getBody()->getContents());

				if(!isset($result->rows[0]->elements[0]->distance->value))
					return 1;
				else
					return $result->rows[0]->elements[0]->distance->value/1000;

            } else {
                $request = new \RequestExtended();
                $request->send($url, $body, 'get');

				file_put_contents("/var/www/contao.log",print_r($request->response,true),FILE_APPEND);

            }


	}

    /**
     * @inheritdoc
     */
    public function getPrice(IsotopeProductCollection $objCollection = null)
    {
        $arrPostalCodes = array();
        $fromPostal = Isotope::getConfig()->postal;
        $tillPostal = Isotope::getCart()->getShippingAddress()->postal;

		/**
	 	 * calculate/retrieve distance in kilometers (km)
	 	 */
		if($this->gs_useGoogleDistanceMatrixApi)
		{
			$distanceKM  = $this->callGoogleApi();

		}
		else
		{
	        // find cheapest distance
    	    if($this->gs_postalcodes)
    	        $arrPostalcodes = explode(",", $this->gs_postalcodes);
    	    if($arrPostalcodes)
    	    {
    	        $arrDistances=array();
    	        foreach($arrPostalcodes as $postalcode)
    	            $arrDistances[$postalcode] = $this->ogdbDistance(trim($postalcode),$tillPostal);
    	        $distanceKM = min($arrDistances);
    	    }
    	    else
    	    {
    	        $distanceKM = $this->ogdbDistance($fromPostal,$tillPostal);
    	    }
		}

        $fltPrice = (float) $this->arrData['price'];
        $fltPrice = $distanceKM*$fltPrice;

        if($this->gs_minprice > 0 && $this->gs_minprice > $fltPrice)
            $fltPrice = $this->gs_minprice;
        if($this->gs_maxprice > 0 && $this->gs_maxprice < $fltPrice)
            $fltPrice = $this->gs_maxprice;

        return Isotope::calculatePrice($fltPrice, $this, 'price', $this->arrData['tax_class']);
    }
}
