<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * appProdUrlMatcher
 *
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appProdUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    /**
     * Constructor.
     */
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        // libreame_ingresarSistema
        if ($pathinfo === '/ingreso') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_libreame_ingresarSistema;
            }

            return array (  '_controller' => 'Libreame\\BackendBundle\\Controller\\AccesoController::ingresarSistemaAction',  '_format' => 'json',  '_route' => 'libreame_ingresarSistema',);
        }
        not_libreame_ingresarSistema:

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
