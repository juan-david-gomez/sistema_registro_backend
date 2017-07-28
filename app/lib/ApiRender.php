<?php  

final class ApiRenderer
{
    /**
     * Renderer constructor.
     *
     * @param $config
     */
    public function __construct()
    {
        
    }

    /**
     * @param Response $response
     * @param int      $statusCode
     * @param string   $data
     *
     * @return Response
     */
    public static function jsonResponse($response, $statusCode = 200, $data = '')
    {
        $jsonResponse = $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, PUT, PATCH, POST, DELETE, OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
            ->withHeader('Content-Type', 'application/vnd.api+json')
            ->withStatus($statusCode);
        
        if (!self::isJson($data)) {
            $data = json_encode($data);
        }
        
        $jsonResponse->getBody()->write($data);


        return $jsonResponse;
    }
    public static function isJson($string) {
     if (is_string($string)) {         
         @json_decode($string);
         return (json_last_error() == JSON_ERROR_NONE);
     }else{
        return false;
     }
    }
}