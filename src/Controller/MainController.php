<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class MainController
{
    public function indexAction()
    {
        return new Response(
            '<html><body>Hello Symfony 5</body></html>'
        );
    }
}
