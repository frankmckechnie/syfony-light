<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CrudController extends AbstractController
{

    /**
     * @Route("/crud", name="crud-root")
     */
    public function index(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository(User::class);
        
        $user = $repository->find(1);

        $video = $this->getDoctrine()->getRepository(Video::class)->find(1);

        $user->removeVideo($video);

        $entityManager->flush();

        // $users = $repository->findBy(['name' => 'Robert'], ['id'=>'DESC']);

        foreach($user->getVideos() as $video){
            dump($video->getTitle());
        }


        return $this->render('crud/index.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }

    /**
     * @Route("/crud/view/{id}", name="get")
     */
    public function view(Request $request, User $user): Response
    {
        // $repository = $this->getDoctrine()->getRepository(User::class);
        
        // $user = $repository->find(1);

        // $users = $repository->findBy(['name' => 'Robert'], ['id'=>'DESC']);

        foreach($user->getVideos() as $video){
            dump($video->getTitle());
        }

        return $this->render('crud/index.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }

    /**
     * @Route("/crud/raw", name="raw")
     */
    public function raw(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $conn =  $entityManager->getConnection();

        $sql = '
            SELECT * FROM user
        ';

        $stmt = $conn->prepare($sql);

        $stmt->execute();

        dump($stmt->fetchAll());

        return $this->render('crud/index.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }

    /**
     * @Route("/crud/create", name="create")
     */
    public function create(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();

        $user->setName('mike');

        $entityManager->persist($user);

        $entityManager->flush();

        dump($user);


        return $this->render('crud/index.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }

    
    /**
     * @Route("/crud/create/video", name="create/video")
     */
    public function createVideos(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();

        $user->setName('dave');

        for ($i=0; $i < 3; $i++) { 
            $video = new Video();
            $video->setTitle('video title-' . $i);
            $user->addVideo($video);
            $entityManager->persist($video);
        }

        $entityManager->persist($user);

        $entityManager->flush();

        // $video = $this->getDoctrine()->getRepository(Video::class)->find(1);


        // dump($video->getUser()->getName());

        return $this->render('crud/index.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }


    /**
     * @Route("/crud/update", name="update")
     */
    public function update(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository(User::class);
        
        $user = $repository->find(1);

        if(!$user){
            throw $this->createNotFoundException(
                'No id with that'
            );
        }

        $user->setName('robert');

        $entityManager->flush();

        dump($user);

        return $this->render('crud/index.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }

    /**
     * @Route("/crud/delete", name="delete")
     */
    public function delete(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $repository = $this->getDoctrine()->getRepository(User::class);
        
        $user = $repository->find(1);

        $entityManager->remove($user);

        $entityManager->flush();

        return $this->render('crud/index.html.twig', [
            'controller_name' => 'CrudController',
        ]);
    }
}
