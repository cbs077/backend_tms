<?php 

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
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
        $session = session();
        $session->get('isLoggedIn');
        $val = $session->get('isLoggedIn');
        log_message('debug', json_encode($val)); 
        log_message('debug', json_encode($val));

        if ($session->get('isLoggedIn') == 'false' || $session->get('isLoggedIn') == null)
        {
            log_message('info', "AuthGuard1_fail"); 
            return Services::response()
                ->setJSON(
                    [
                        'error' => "HTTP_AUTHORIZATION"
                    ]
                )
                ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}