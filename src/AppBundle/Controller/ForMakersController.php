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
    public function connectAction($login, $password)
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

    /**
     * @Route("/addVideo/{name}/{video}", name="homepage")
     */
    public function addVideoAction($name, $video)
    {

        return new JsonResponse($name, $video);
    }

    /**
     * @Route("/getVideos", name="get_videos")
     */
    public function getVideosAction()
    {
        $em = $this->getDoctrine()->getManager()->getRepository("AppBundle:Video");
        $videos = $em->findBy([],[
            "id"=>"DESC",
        ]);

//        var_dump($videos);
        $allVideos = [];

        foreach ($videos as $video) {
            $allVideos[] = [
                "id" => $video->id,
                "id_groupe" => $video->idGroupe,
                "creator_name" => $video->creatorName,
                "link" => $video->link,
                "publish_date" => $video->addDate
            ];
        }

        return new JsonResponse($allVideos);
    }


    private function checkIfLoginExist($login)
    {
        $em = $this->getDoctrine()->getRepository("AppBundle:User");
        return $em->findOneBy([
            "login" => $login
        ]);
    }
}
