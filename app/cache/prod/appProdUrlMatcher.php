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

        // ex4read_ingresarSistema
        if ($pathinfo === '/ingreso') {
            if ($this->context->getMethod() != 'POST') {
                $allow[] = 'POST';
                goto not_ex4read_ingresarSistema;
            }

            return array (  '_controller' => 'Libreame\\BackendBundle\\Controller\\AccesoController::ingresarSistemaAction',  '_format' => 'json',  '_route' => 'ex4read_ingresarSistema',);
        }
        not_ex4read_ingresarSistema:

        if (0 === strpos($pathinfo, '/re')) {
            // ex4read_confirmarRegistro
            if (0 === strpos($pathinfo, '/registro') && preg_match('#^/registro/(?P<id>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_ex4read_confirmarRegistro;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ex4read_confirmarRegistro')), array (  '_controller' => 'Libreame\\BackendBundle\\Controller\\RegistroController::confirmarRegistroAction',));
            }
            not_ex4read_confirmarRegistro:

            // ex4read_resetUsuario
            if (0 === strpos($pathinfo, '/reset') && preg_match('#^/reset/(?P<usuario>[^/]++)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_ex4read_resetUsuario;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ex4read_resetUsuario')), array (  '_controller' => 'Libreame\\BackendBundle\\Controller\\PruebasController::resetUsuarioAction',));
            }
            not_ex4read_resetUsuario:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}
