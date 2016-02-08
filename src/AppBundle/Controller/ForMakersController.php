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
        $em = $this->getDoctrine();

        if($this->checkIfLoginExist($login)) {
            //Check password
            if($em->getRepository("AppBundle:User")->checkIfUserExist($login, $password)){
                // IS REGISTERED
                return new JsonResponse(true);
            } else {
                return new JsonResponse(false);
            }
        } else {

            $date = new \DateTime();
            // Create a user
            $user = new User();
            $user->setLogin($login)
                ->setPassword($password)
                ->setInscriptionDate($date);

            $em = $em->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse(true);
        }

    }

    private function checkIfLoginExist($login)
    {
        $em = $this->getDoctrine()->getRepository("AppBundle:User");
        return $em->findOneBy([
            "login" => $login
        ]);
    }
}
