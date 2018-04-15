<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Empresa;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Generic\GenericSessao;


class DefaultController extends Controller
{

    protected $sessao;
    public function __construct(GenericSessao $sessao)
    {
        $this->sessao = $sessao;
    }


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $logout = $request->query->get('logout'); 
        if($logout){
            $this->sessao->excluirSessao($request);
        }

        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getManager();
            $empresas = $em->getRepository('AppBundle:Empresa')->findAll();
            $categorias = $em->getRepository('AppBundle:Categoria')->findAll();

            $sql = 'SELECT * FROM empresas_categorias';
            $categorias_empresas = $em->getConnection()->executeQuery($sql)->fetchAll();


            $resultado = array(
                "categorias_empresas" => $categorias_empresas,
                "categorias" => $categorias,
                "empresas" => $empresas
            );
            return new JsonResponse($resultado);
        }

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
    
}
