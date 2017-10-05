<?php

$app->post('/api/MicrosoftTranslatorText/addTranslateArray', function ($request, $response) {

    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey','texts','to']);

    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }

    $requiredParams = ['apiKey'=>'apiKey','texts'=>'Texts','to'=>'To'];
    $optionalParams = ['from'=>'From','category'=>'Category','contentType'=>'ContentType','profanityAction'=>'ProfanityAction','state'=>'State','uri'=>'Uri','user'=>'User'];
    $bodyParams = [
    ];

    $data = \Models\Params::createParams($requiredParams, $optionalParams, $post_data['args']);


    $xmlElement = array('From','Options','Texts','To');
    $xmlOptions = array(
        'Category' => 'http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2',
        'ContentType' => 'http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2',
        'ProfanityAction' => 'http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2',
        'State' => 'http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2',
        'Uri' => 'http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2',
        'User' => 'http://schemas.datacontract.org/2004/07/Microsoft.MT.Web.Service.V2'
        );

    $xml = new SimpleXMLElement('<TranslateArrayRequest/>');
    $xml->addChild('AppId');
    foreach($xmlElement as $key => $value)
    {
        //Part for option element
        if($value == 'Options')
        {
            $options =  $xml->addChild($value);
            foreach($xmlOptions as $tag => $attr)
            {
                if(!empty($data[$tag]))
                {
                    $newChild = $options->addChild($tag,$data[$tag]);
                    $newChild->addAttribute('xmlns', $attr);
                }

            }
            continue;
        }

        //Part for texts element
        if($value == 'Texts')
        {
            $texts = $xml->addChild($value);
            foreach($data['Texts'] as $text)
            {
                $newChild = $texts->addChild('string',$text);
                $newChild->addAttribute('xmlns', 'http://schemas.microsoft.com/2003/10/Serialization/Arrays');
            }
            continue;
        }

        if(!empty($data[$value]))
        {
            $xml->addChild($value, $data[$value]);
        }
    }

    $xml = $xml->asXML();

    $client = $this->httpClient;
    $query_str = "https://api.microsofttranslator.com/V2/Http.svc/TranslateArray";


 //   $xml = '';
    $requestParams = \Models\Params::createRequestBody($data, $bodyParams);
    $requestParams['headers'] = ["Ocp-Apim-Subscription-Key"=>"{$data['apiKey']}","Content-Type" => "application/xml"];
    $requestParams['body'] = $xml;

 
    try {
        $resp = $client->post($query_str, $requestParams);

        $responseBody = $resp->getBody()->getContents();

        if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {
            $result['callback'] = 'success';
            if(!empty($responseBody))
            {
                $xml = simplexml_load_string($responseBody);
                $json = json_encode($xml);
                $array = json_decode($json,TRUE);
                $responseBody = $array;
            }
            $result['contextWrites']['to'] = is_array($responseBody) ? $responseBody : json_decode($responseBody);
            if(empty($result['contextWrites']['to'])) {
                $result['contextWrites']['to']['status_msg'] = "Api return no results";
            }
        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = json_decode($responseBody);
        }

    } catch (\GuzzleHttp\Exception\ClientException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        if(!empty($out))
        {
            $doc = new DOMDocument();
            $doc->loadHTML($out);
            $tags = $doc->getElementsByTagName('*');
            $out = array();
            foreach ($tags as $tag) {
                if($tag->tagName == 'html' || $tag->tagName == 'body')
                {
                    continue;
                }else {
                    $out[] = $tag->nodeValue;
                }
            }

            $out = implode('||',$out);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ServerException $exception) {

        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;

    } catch (GuzzleHttp\Exception\ConnectException $exception) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Something went wrong inside the package.';

    }

    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);

});