<?php

namespace App\Controller;

use App\Entity\Pdf;
use App\Entity\File;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Author;
use App\Services\GiftsService;
use App\Services\DefaultService;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    public function __construct($logger, GiftsService $GiftsService, DefaultService $defaultService)
    {
       // $GiftsService->setGifts(['a','b','c']);

       dump($defaultService);
    }

    /**
     * @Route("/", name="root-default")
     */
    public function root(GiftsService $GiftsService, Request $request, SessionInterface $session): Response
    {
        /**
         * @var UserRepository $repository
         */
        $repository = $this->getDoctrine()->getRepository(User::class);

        $users = $repository->findAll();

        $files = $this->getDoctrine()->getRepository(File::class)->findAll();

        $author = $this->getDoctrine()->getRepository(Author::class)->findByIdWithPdf(3);


       $files = $author->getFiles();

       foreach($files as $file){
        dump($author);
       }



        // $pdfs = $this->getDoctrine()->getRepository(Pdf::class)->findAll();
        // $images = $this->getDoctrine()->getRepository(Image::class)->findAll();

        dump($files);


        // $user2 = $repository->find(2);
        // $user3 = $repository->find(3);
        // $user4 = $repository->find(4);

        // $user1->addFollowed($user2);
        // $user1->addFollowed($user3);
        // $user1->addFollowed($user4);
        // $user2->addFollowed($user1);
        // $user3->addFollowed($user2);

        // $this->getDoctrine()->getManager()->flush();;



       // $users = $this->getDoctrine()->getRepository(User::class)->findall();



        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'gifts' => $GiftsService->getGifts(),
            'users' => $users,
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
