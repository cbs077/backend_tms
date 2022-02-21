<?php 

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;


class AuthGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: X-API-KEY, Origin,X-Requested-With, Content-Type, Accept, Access-Control-Requested-Method, Authorization");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PATCH, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS"){
            die();
        }
        $key = "cskhfuwt48wbfjn3i4utnjf38754hf3yfbjc93758thrjsnf83hcwn8437"; //getenv('TOKEN_SECRET');
        $authHeader = $request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();

        try {
            JWT::decode($authHeader, new Key($key, 'HS256'));
        } catch (\Throwable $th) {
            //log_message('info', "Authorization3:".$th); 
            return Services::response()
                            ->setJSON(['msg' => 'Invalid Token'])
                            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
        // if ($session->get('isLoggedIn') == 'false' || $session->get('isLoggedIn') == null)
        // {
        //     log_message('info', "AuthGuard1_fail"); 
        //     return Services::response()
        //         ->setJSON(
        //             [
        //                 'error' => "HTTP_AUTHORIZATION"
        //             ]
        //         )
        //         ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        // }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}