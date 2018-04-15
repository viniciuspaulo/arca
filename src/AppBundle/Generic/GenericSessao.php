<?php

namespace AppBundle\Generic;
use Symfony\Component\HttpFoundation\Request;

class GenericSessao{

    public function validarSessao(Request $request){
        $session = $request->getSession();
        $logado = $session->get('usuario');
        if(!$logado){
            header('Location: ../login');
        }
    }


    public function excluirSessao(Request $request){
        $session = $request->getSession();
        $logado = $session->clear();
    }

}