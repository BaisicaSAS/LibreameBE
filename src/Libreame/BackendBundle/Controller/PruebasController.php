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
            echo $usuario;
            if ($usuario == "CONVERTIRIMAGENES"){
                $em = $this->getDoctrine()->getManager();
                $imagenes = $em->createQueryBuilder()
                    ->select('a')
                    ->from('LibreameBackendBundle:LbEjemplares', 'a')
                    ->Where('a.txejeimagen IS NOT NULL AND a.inejemplar >= 800')
                    //->Where('a.txejeimagen IS NOT NULL')
                    ->getQuery()->getResult();
                $imagen = new \Libreame\BackendBundle\Entity\LbEjemplares();
                
                foreach($imagenes as $imagen){
                    ///home/baisicasas/public_html/www.ex4read.co/  exservices/web/img/p/
                            
                    //http://ex4read.co/  exservices/web/img/p/8/1/3/813.jpg
                        
                    $archivoOri = str_replace("http://ex4read.co/","/home/baisicasas/public_html/www.ex4read.co/",$imagen->getTxejeimagen());  //Obtiene el nombre del archivo en modo directorio
                    $archivoOpt = $archivoOri;  //Obtiene el nombre del archivo 
                    echo " - [ARCHIVO: ".$archivoOri."]"."\n";

                    rename($archivoOri,$archivoOri.".OLD"); //Renombra el archivo actual
                    echo " - [RENOMBRA ARCHIVO: ".$archivoOri.".OLD]"."\n";

                    $fileimagen = imagecreatefromjpeg($archivoOpt.".OLD"); //Instacia el archivo actual
                    echo " - [INSTANCIA LA IMAGEN: ".$archivoOpt.".OLD]"."\n";
                    
                    imagejpeg($fileimagen, $archivoOpt, 30);    //Optimiza y guarda el archivo
                    echo " - [OPTIMIZA LA IMAGEN: ".$archivoOpt."]"."\n";
                    
                    //unlink($archivoOri.".OLD");
                    echo " - [BORRÓ ".$archivoOri.".OLD]"."\n";
                    echo "-------------------------------------------------------"."\n";
                }

                $em->flush();
                return  new RESPONSE("PROCESO FINALIZADO"."\n");
            } else {
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
            
        }            
        catch (Exception $ex) {
            return new RESPONSE(-1500);
        }
             
    }
    
  
}
