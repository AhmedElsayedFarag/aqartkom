<?php

/* For simplicity check our PHP SDK library here https://myfatoorah.readme.io/php-library  */
/* ------------------------ Configurations ---------------------------------- */
//Test
$apiURL = 'https://apitest.myfatoorah.com';
$apiKey = ''; //Test token value to be placed here: https://myfatoorah.readme.io/docs/test-token

//Live
//$apiURL = 'https://api.myfatoorah.com';
//$apiKey = ''; //Live token value to be placed here: https://myfatoorah.readme.io/docs/live-token


/* ------------------------ Call InitiatePayment Endpoint ------------------- */
//Fill POST fields array, check https://myfatoorah.readme.io/docs/initiate-payment#request-model
$ipPostFields = ['InvoiceAmount' => 100, 'CurrencyIso' => 'KWD'];

//Call endpoint
$paymentMethods = initiatePayment($apiURL, $apiKey, $ipPostFields);

//You can save $paymentMethods information in database to be used later
$paymentMethodId = 2;
/*foreach ($paymentMethods as $pm) {
    if ($pm->PaymentMethodEn == 'VISA/MASTER') {
        $paymentMethodId = $pm->PaymentMethodId;
        break;
    }
}*/

/* ------------------------ Call ExecutePayment Endpoint -------------------- */
//Fill customer address array
/* $customerAddress = array(
  'Block'               => 'Blk #', //optional
  'Street'              => 'Str', //optional
  'HouseBuildingNo'     => 'Bldng #', //optional
  'Address'             => 'Addr', //optional
  'AddressInstructions' => 'More Address Instructions', //optional
  ); */

//Fill invoice item array
/* $invoiceItems[] = [
  'ItemName'  => 'Item Name', //ISBAN, or SKU
  'Quantity'  => '2', //Item's quantity
  'UnitPrice' => '25', //Price per item
  ]; */

//Fill suppliers array
/* $suppliers = [
		[
  	'SupplierCode'  => 1,
 	 	'InvoiceShare'  => '2',
  	'ProposedShare' => null,
  	]
  ]; */

//Fill POST fields array, check https://myfatoorah.readme.io/docs/execute-payment#required-fields
$postFields = [
    //Fill required data
    'paymentMethodId' => $paymentMethodId,
    'InvoiceValue'    => '50',
    'CallBackUrl'     => 'https://example.com/callback.php',
    'ErrorUrl'        => 'https://example.com/callback.php', //or 'https://example.com/error.php'
    //Fill optional data
    //'CustomerName'       => 'fname lname',
    //'DisplayCurrencyIso' => 'KWD',
    //'MobileCountryCode'  => '+965',
    //'CustomerMobile'     => '1234567890',
    //'CustomerEmail'      => 'email@example.com',
    //'Language'           => 'en', //or 'ar'
    //'CustomerReference'  => 'orderId',
    //'CustomerCivilId'    => 'CivilId',
    //'UserDefinedField'   => 'This could be string, number, or array',
    //'ExpiryDate'         => '', //The Invoice expires after 3 days by default. Use 'Y-m-d\TH:i:s' format in the 'Asia/Kuwait' time zone.
    //'SourceInfo'         => 'Pure PHP', //For example: (Laravel/Yii API Ver2.0 integration)
    //'CustomerAddress'    => $customerAddress,
    //'InvoiceItems'       => $invoiceItems,
    //Suppliers       		 => $suppliers
];

//Call endpoint
$data = executePayment($apiURL, $apiKey, $postFields);

//You can save payment data in database as per your needs
$invoiceId   = $data->InvoiceId;
$paymentLink = $data->PaymentURL;

//Redirect your customer to the payment page to complete the payment process
//Display the payment link to your customer
echo "Click on <a href='$paymentLink' target='_blank'>$paymentLink</a> to pay with invoiceID $invoiceId.";
die;


/* ------------------------ Functions --------------------------------------- */
/*
 * Initiate Payment Endpoint Function
 */

function initiatePayment($apiURL, $apiKey, $postFields)
{

    $json = callAPI("$apiURL/v2/InitiatePayment", $apiKey, $postFields);
    return $json->Data->PaymentMethods;
}

//------------------------------------------------------------------------------
/*
 * Execute Payment Endpoint Function
 */

function executePayment($apiURL, $apiKey, $postFields)
{

    $json = callAPI("$apiURL/v2/ExecutePayment", $apiKey, $postFields);
    return $json->Data;
}

//------------------------------------------------------------------------------
/*
 * Call API Endpoint Function
 */

function callAPI($endpointURL, $apiKey, $postFields = [], $requestType = 'POST')
{

    $curl = curl_init($endpointURL);
    curl_setopt_array($curl, array(
        CURLOPT_CUSTOMREQUEST  => $requestType,
        CURLOPT_POSTFIELDS     => json_encode($postFields),
        CURLOPT_HTTPHEADER     => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
        CURLOPT_RETURNTRANSFER => true,
    ));

    $response = curl_exec($curl);
    $curlErr  = curl_error($curl);

    curl_close($curl);

    if ($curlErr) {
        //Curl is not working in your server
        die("Curl Error: $curlErr");
    }

    $error = handleError($response);
    if ($error) {
        die("Error: $error");
    }

    return json_decode($response);
}

//------------------------------------------------------------------------------
/*
 * Handle Endpoint Errors Function
 */

function handleError($response)
{

    $json = json_decode($response);
    if (isset($json->IsSuccess) && $json->IsSuccess == true) {
        return null;
    }

    //Check for the errors
    if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
        $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
        $blogDatas = array_column($errorsObj, 'Error', 'Name');

        $error = implode(', ', array_map(function ($k, $v) {
            return "$k: $v";
        }, array_keys($blogDatas), array_values($blogDatas)));
    } else if (isset($json->Data->ErrorMessage)) {
        $error = $json->Data->ErrorMessage;
    }

    if (empty($error)) {
        $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
    }

    return $error;
}

/* -------------------------------------------------------------------------- */
