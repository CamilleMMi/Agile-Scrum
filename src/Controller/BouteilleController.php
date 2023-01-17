<?php
// src/Controller/CoreController.php
namespace App\Controller;

use App\Entity\Bouteille;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BouteilleController extends AbstractController {
    
    #[Route('/liste_bouteilles', name: 'liste_bouteilles')]
    public function listeBouteille(ManagerRegistry $doctrine): Response {
        $bouteilles = $doctrine->getRepository(Bouteille::class)->findAll();
        $resultat = "";

        foreach($bouteilles as $bouteille) {
            $resultat += "bouteilles " . $bouteille;
        }

        return new Response("liste : " + $resultat);
    }
}