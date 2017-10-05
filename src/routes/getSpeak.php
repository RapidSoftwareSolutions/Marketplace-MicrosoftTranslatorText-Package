<?php

$app->post('/api/MicrosoftTranslatorText/getSpeak', function ($request, $response) {

    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey','text','language']);

    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }

    $requiredParams = ['apiKey'=>'apiKey','text'=>'text','language'=>'language'];
    $optionalParams = ['format'=>'format','quality'=>'quality','voice'=>'voice','contentType'=>'contentType'];
    $bodyParams = [
       'query' => ['language','format','options','text']
    ];

    $data = \Models\Params::createParams($requiredParams, $optionalParams, $post_data['args']);

    

    $client = $this->httpClient;
    $query_str = "https://api.microsofttranslator.com/V2/Http.svc/Speak";
    $format = '.wav';
    if(!empty($data['format']) || $data['format'] == 'audio/mp3')
    {
        $format = '.mp3';
    }
    

    $requestParams = \Models\Params::createRequestBody($data, $bodyParams);
    $requestParams['headers'] = ["Ocp-Apim-Subscription-Key"=>"{$data['apiKey']}"];
     

    try {
        $resp = $client->get($query_str, $requestParams);
        $responseBody = $resp->getBody()->getContents();

        if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {

            $uploadUrl = 'http://104.198.149.144:8080/';

            $size = $resp->getHeader('Content-Length')[0];
            $contentDisposition = $resp->getHeader('Content-Disposition');
            //If name is not specified,by default send an empty value.
            $fileName = 'voice'.$format;
            //If the file name is not specified, we try to get it from the header.
            if(!empty($contentDisposition))
            {
                $fileHeaderPattern = '/filename=".+"/';
                preg_match($fileHeaderPattern, $contentDisposition, $result);
                $fileNamePattern = '/"(.*)"/';
                preg_match($fileNamePattern, $result[0], $fileName);
                if(!empty($fileName[0]))
                {
                    $fileName = $fileName[0];
                }
            }
            if(!empty($fileParams['fileName']))
            {
                $fileName = $fileParams['fileName'];
            }
            $uploadServiceResponse = $client->post($uploadUrl, [
                'multipart' => [
                    [
                        'name' => 'length',
                        'contents' => $size
                    ],
                    [
                        "name" => "file",
                        "filename" => $fileName,
                        "contents" => $responseBody
                    ]
                ]
            ]);
            $responseBody = $uploadServiceResponse->getBody()->getContents();




            $result['callback'] = 'success';
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