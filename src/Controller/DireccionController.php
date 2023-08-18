<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Auxiliares\Auxiliar;
use App\Entity\Direccion;
use App\Entity\CodigoPostal;
use App\Repository\CodigoPostalRepository;

class DireccionController extends AbstractController
{
    public function crear(Request $req,EntityManagerInterface $em, ValidatorInterface $validator,CodigoPostalRepository $cpr):JsonResponse{

        $datos = json_decode($req->getContent());
        $mensaje = "Algo ha ido mal";
        $id = 0;
        if($datos){
            $direccion = new Direccion();
            $direccion->setCalle($datos->calle ?? null);
            $direccion->setNumero($datos->numero ?? null);
            $direccion->setRestoDatos($datos->resto_datos ?? null);

            $cp = $cpr->find($datos->codigo_postal ?? 0);

            $direccion->setCodigoPostal($cp);

            $errores = $validator->validate($direccion);
            if (count($errores) > 0) {
                $mensaje = ["Hay errores en los campos",[]];
                foreach($errores as $error){
                    $mensaje[1][] = $error->getMessage();
                }
            }else{
                try{
                    $em->persist($direccion);
                    $em->flush();
                    $id = $direccion->getId();
                    $mensaje = "";
                }catch(\Exception $e){
                    $mensaje = $e->getMessage();
                }
            }
        }else{
            $mensaje = "Formato de mensaje incorrecto";
        }
        return $this->json(Auxiliar::generadorRespuesta($mensaje,$id ? "OK" : "KO",$id ? ["id"=>$id] : []));
    }

    public function modificar(Request $req,EntityManagerInterface $em, ValidatorInterface $validator,int $id){
        $datos = json_decode($req->getContent());
        $mensaje = "Algo ha ido mal";
        if($datos){
            $direccion = $em->getRepository(Direccion::class)->find($id);
            if($direccion){
                if(isset($datos->calle)){
                    $direccion->setCalle($datos->calle);
                }
                if(isset($datos->numero)){
                    $direccion->setNumero($datos->numero);
                }
                if(isset($datos->resto_datos)){
                    $direccion->setRestoDatos($datos->resto_datos);
                }
                $errores = $validator->validate($direccion);
                if (count($errores) > 0) {
                    $mensaje = ["Hay errores en los campos",[]];
                    foreach($errores as $error){
                        $mensaje[1][] = $error->getMessage();
                    }
                }else{
                    try{
                        $em->flush();
                        $mensaje = "";
                    }catch(\Exception $e){
                        $mensaje = $e->getMessage();
                    }
                }
            }else{
                $mensaje = "Dirección no encontrada";
            }
        }else{
            $mensaje = "Formato de mensaje incorrecto";
        }
        return $this->json(Auxiliar::generadorRespuesta($mensaje,empty($mensaje) ? "OK" : "KO"));
    }

    public function borrar(Request $req,EntityManagerInterface $em, int $id){
        $datos = json_decode($req->getContent());
        $mensaje = "Algo ha ido mal";
        if($datos){
            $direccion = $em->getRepository(Direccion::class)->find($id);
            if($direccion){
                if (count($direccion->getPersonas())) {
                    $mensaje = "La dirección tiene personas asociadas";
                }else{
                    try{
                        $em->remove($direccion);
                        $em->flush();
                        $mensaje = "";
                    }catch(\Exception $e){
                        $mensaje = $e->getMessage();
                    }
                }
            }else{
                $mensaje = "Dirección no encontrada";
            }
        }else{
            $mensaje = "Formato de mensaje incorrecto";
        }
        return $this->json(Auxiliar::generadorRespuesta($mensaje,empty($mensaje) ? "OK" : "KO"));
    }


}
