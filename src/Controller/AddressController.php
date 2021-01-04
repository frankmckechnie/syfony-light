<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Address;
use App\Entity\User;

class AddressController extends AbstractController
{
    /**
     * @Route("/address", name="address")
     */
    public function index(): Response
    {

        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();

        $user->setName('mike');

        $address = new Address();

        $address->setStreet('12 walker street');
        $address->setNumber(12);

        $user->setAddress($address);

        $entityManager->persist($user);
       // $entityManager->persist($address);

        $entityManager->flush();

        dump($user->getAddress()->getStreet());


        return $this->render('address/index.html.twig', [
            'controller_name' => 'AddressController',
        ]);
    }
}
