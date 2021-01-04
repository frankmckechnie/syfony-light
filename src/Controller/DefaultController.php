<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\GiftsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{

    public function __construct($logger, GiftsService $GiftsService)
    {
       // $GiftsService->setGifts(['a','b','c']);
    }

    /**
     * @Route("/", name="root-default")
     */
    public function root(GiftsService $GiftsService, Request $request, SessionInterface $session): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        
        $user1 = $repository->findWithVideos(11);
        // $user2 = $repository->find(2);
        // $user3 = $repository->find(3);
        // $user4 = $repository->find(4);

        // $user1->addFollowed($user2);
        // $user1->addFollowed($user3);
        // $user1->addFollowed($user4);
        // $user2->addFollowed($user1);
        // $user3->addFollowed($user2);

        // $this->getDoctrine()->getManager()->flush();;

        dump($user1);


       // $users = $this->getDoctrine()->getRepository(User::class)->findall();



        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'gifts' => $GiftsService->getGifts(),
            'users' => [$user1],
        ]);

    }

    /**
     * @Route("/default", name="default")
     */
    public function index(GiftsService $GiftsService, Request $request, SessionInterface $session): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findall();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'gifts' => $GiftsService->getGifts(),
            'users' => $users,
        ]);

    }

    /**
     * @Route("/forward-to-controller", name="forward-to")
     */
    public function forwardToController(){
        $response = $this->forward(
            self::class . '::methodToForwardTo',
            ['param' => 1]
        );

        return $response;
    }

    /**
     * @Route("/forward-to-controller/{param?}", name="methodToForwardTo")
     */
    public function methodToForwardTo($param){
        dd('Testing controller forwarding', $param);
    }


    

    /**
     * @Route("/download", name="download")
     */
    public function download(){
        $path = $this->getParameter('download_directory');
        return $this->file($path.'file.pdf');
    }

    /**
     * @Route("/generate", name="generate_url")
     */
    public function generate_url(){
        exit(
            $this->generateUrl('download', ['param', 'test'], UrlGeneratorInterface::ABSOLUTE_URL )
        );
    }

    /**
     * @Route("/blog/{page?}", name="long_article", requirements={"page"="\d+"})
     */
    public function index2(): Response
    {

        $users = $this->getDoctrine()->getRepository(User::class)->findall();

        $this->addFlash("notice", "test");

        $this->addFlash("warning", "two");


        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'users' => $users,
            'gifts' => $GiftsService->getGifts()
        ]);
    }

    /**
     * @Route(
     *      "/article/{_locale}/{year}/{slug}/{category}",
     *      defaults={"category":"computers"},
     *      name="blog_lists", 
     *      requirements={
     *          "_locale": "en|fr",
     *          "category": "computers|rtv",
     *          "year"="\d+"
     *      }
     * )
     */
    public function index3(): Response
    {
        $cookie = $request->cookies->get('PHPSESSID');

        $session->set('name', 'value');

        if($session->has('name')){
            dd($session->get('name'), $cookie);
        }


        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'gifts' => $GiftsService->getGifts()
        ]);
    }

    /**
     * @Route({
     *      "nl": "/over-ons",
     *      "en": "/about-us"}, name="about-us"
     * )
     */
    public function index4(): Response
    {
        return new Response('Translate');
    }


    public function mostPopularPosts(int $number = 3){
        $posts = ['post 1', 'post 2', 'post 3'];

       return $this->render('default/most_popular_posts.html.twig', ['posts' => $posts]);
    }
}
