<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ForMakersController extends Controller
{
    /**
     * @Route("/connect/{login}/{password}", name="homepage")
     */
    public function connectAction(Request $request, $login, $password)
    {
        $em = $this->getDoctrine()->getRepository("AppBundle:User");
        if($em->checkIfUserExist($login, $password)){
            // IS REGISTERED
            return new JsonResponse(true);
        } else {
            // NOT REGISTERED
//            echo "// NOT REGISTERED";
            return new JsonResponse(false);
        }


        return new JsonResponse($user);
    }
//
//    /**
//     * @Route("/", name="add_user")
//     */
//    public function addUser(Request $request)
//    {
//        $user = new User();
//
//
//    }
}
