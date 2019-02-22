<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Request;
use App\Libraries\RestProxy;
use App\Libraries\CurlWrapper;

class RestProxyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    function makeRequest() {
        
        $BASE_NAME          = 'jsonplaceholder';
        $BASE_URL           = 'https://jsonplaceholder.typicode.com/todos';
        $REQUESTURI         = $_SERVER['REQUEST_URI'];
        $REMOVE_BASE_URI    = str_replace('/sample','',$REQUESTURI);
        $FULL_URI           = $BASE_URL . $REMOVE_BASE_URI;
        
        // echo $FULL_URI;

        // Create Instansiet
        $client = new RestProxy(Request::createFromGlobals(), new CurlWrapper());
        // Create Your Proxy (Register Name And URL)
        $client->register($BASE_NAME, $FULL_URI);

        // Run The Proxy
        $client->run();

        // Create Header
        // foreach($client->getHeaders() as $header) {
        //     header($header);
        // }
        // Return request
        $data = json_decode($client->getContent());
        return response()->json($data);
        // echo $request->getUri();
    }
}
