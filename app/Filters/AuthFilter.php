<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\SessionInterface;

class AuthFilter implements FilterInterface
{
    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!$this->session->get('is_login')) {
            // Redirect to login page or perform other actions
            return redirect()->to('/');
        }

        // User is logged in, allow the request to proceed
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after the request
        return $response;
    }
}
