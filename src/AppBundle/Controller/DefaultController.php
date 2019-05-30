<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Clientes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\MaxDepth;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(Clientes::class)->findAll();


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/pedido", name="homepage")
     * @Method("POST")
     */
    public function postAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(Clientes::class)->findAll();


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
