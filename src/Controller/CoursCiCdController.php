<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CoursCiCdController extends AbstractController
{
    /**
     * @Route(name="tp_ci_cd", path="/tp_ci_cd")
     */
    public function indexAction(): Response
    {
	    return $this->render('cours-ci-cd/index.html.twig', []);
    }
}
