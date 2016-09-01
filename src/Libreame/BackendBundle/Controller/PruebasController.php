<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Libreame\BackendBundle\Entity\LbUsuarios;



/*
 * Controlador que permite ejecutar funciones para pruebas:
 *  Resetear información  
 */
class PruebasController extends Controller
{   


    public function resetUsuarioAction($usuario)
    {   
        try {
            $rand = rand(1, 15000000);
            $msg = "";
            echo "INGRESA ";

            $em = $this->getDoctrine()->getManager();
            //echo "<script>alert('validaSesionUsuario :: ingreso')</script>";
            $userOb = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $usuario));
            
            if ($userOb == null) {
                $msg = "No existe el usuario ".$usuario;
            } else {
                $userOb->setTxusuemail($rand."_".$usuario);
                $userOb->setTxusutelefono($rand."_".$userOb->getTxusutelefono());
                $em->persist($userOb);
                        
                $msg = "Usuario [".$usuario."] Reseteado!.";
            }
            
            $em->flush();
            
            return  new RESPONSE($msg);
            
        }            
        catch (Exception $ex) {
            return new RESPONSE(-1500);
        }
             
    }
    
  
}