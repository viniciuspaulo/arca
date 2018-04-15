<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller{
     /**
     * @Route("/login", name="login")
     */
    public function indexAction(Request $request)
    {   
        $session = $request->getSession();
        if($session->get('usuario')){
            header('Location:empresa');
        }
        
        if ($request->getMethod() == 'POST') {
            $usuario = $request->request->all();

            $em = $this->getDoctrine()->getManager();
            $resultado = $em->getRepository('AppBundle:Usuario')->findOneBy(['email' => $usuario['email'],'password' => $usuario['senha']]);

            if($resultado){
                $logado = $session->set('usuario',$usuario["email"]);
                header('Location:empresa');
            }else{
                return $this->render('login/index.html.twig', array(
                    "problemas" => true
                ));
            }
        }
    
        return $this->render('login/index.html.twig',array(
            "problemas" => false
        ));
    }
}
