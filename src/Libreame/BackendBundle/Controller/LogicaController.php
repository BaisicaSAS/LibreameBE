<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogicaController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LibreameBackendBundle:Default:index.html.twig', array('name' => $name));
    }
}
