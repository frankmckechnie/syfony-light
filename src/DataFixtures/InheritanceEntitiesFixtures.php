<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Image;
use App\Entity\Pdf;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InheritanceEntitiesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i=1; $i < 3; $i++) { 
            $author = new Author();
            $author->setName('name' . $i);
            $manager->persist($author); 
            
            for ($j=1; $j < 3; $j++) {
                $pdf = new Pdf();
                $pdf->setFilename('pdf file name' . $j);
                $pdf->setDescription('Test pdf descp');
                $pdf->setAuthor($author);
                $pdf->setPages($j);
                $pdf->setSize(12*$j);
                $manager->persist($pdf);
            }

            for ($k=1; $k < 3; $k++) {
                $img = new Image();
                $img->setFilename('pdf file name' . $k);
                $img->setDescription('Test pdf descp');
                $img->setAuthor($author);
                $img->setExt('.jpg');
                $img->setSize(12*$k);
                $manager->persist($img);
            }

        }


        $manager->flush();
    }
}
