<?php

namespace App\Controller;

use App\Services\MyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MyController extends AbstractController
{   

    private $myService;

    public function __construct(MyService $myService)
    {
        $this->myService = $myService;
    }

    /**
     * @Route("/")
     */
    public function doItAllAction()
    {
        $text = $this->myService->doItAll();
        return $this->render("my.html.twig", ["data" => ["text" => $text]]);

    }
}