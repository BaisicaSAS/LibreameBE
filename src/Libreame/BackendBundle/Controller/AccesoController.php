<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/*
 * Controlador que contiene las funciones que validan, controlan y despachan 
 * el acceso a todas las url. Esto implica la generacion y validacion de Tokens
 * Las funciones involucradas:
 * GenerarSesion / EliminarSesion / VerificarAcceso / DespacharOpcion / Cifrar-Descifrar comunicaciones
 * Alta y Bja de usuarios / Recuperacion y cambio de clave
 *  
 */
class AccesoController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LibreameBackendBundle:Default:index.html.twig', array('name' => $name));
    }
}
