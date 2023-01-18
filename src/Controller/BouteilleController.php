<?php
// src/Controller/CoreController.php
namespace App\Controller;

use App\Entity\Bouteille;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BouteilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BouteilleController extends AbstractController {
    
    #[Route('/liste_bouteilles', name: 'liste_bouteilles')]
    public function listeBouteille(ManagerRegistry $doctrine): Response {
        $bouteilles = $doctrine->getRepository(Bouteille::class)->findAll();
        $resultat = "";

        foreach($bouteilles as $bouteille) {
            $resultat .= $bouteille->getName() . " " .$bouteille->getQuantity() . "<br>";
        }

        return new Response("Quantités en stock : <br>" . $resultat);
    }

    #[Route('/liste_bouteilles/{price}', name: 'liste_bouteilles')]
    public function findByPrice(ManagerRegistry $doctrine, BouteilleRepository $bouteilleRepo, int $price): Response {
        $bouteilles = $bouteilleRepo->findByPricePlus($price);
        $resultat = "";

        foreach($bouteilles as $bouteille) {
            $resultat .= $bouteille->getName() . " " .$bouteille->getPrice() . "<br>";
        }

        return new Response("Quantités en stock : <br>" . $resultat);
    }

    #[Route('/liste_bouteilles/orderByCritere/{critere}', name: 'liste_bouteilles')]
    public function orderByCritere(ManagerRegistry $doctrine, BouteilleRepository $bouteilleRepo, string $critere): Response {
        $bouteilles = $bouteilleRepo->orderByCritere($critere);
        $resultat = "";

        foreach($bouteilles as $bouteille) {
            $resultat .= $bouteille->getName() . ", Marque : " .$bouteille->getMarque() . ", Type : " .$bouteille->getAlcoholType() . ", Prix : " .$bouteille->getPrice() . "<br>";
        }

        return new Response("Liste de bouteilles rangé par" . $critere . " :<br>" . $resultat);
    }

    
    #[Route('/liste_bouteilles/orderByCritereWhereSup/{critere}/{numb}', name: 'liste_bouteilles')]
    public function orderByCritereWhereSup(ManagerRegistry $doctrine, BouteilleRepository $bouteilleRepo, string $critere, string $numb): Response {
        $bouteilles = $bouteilleRepo->orderByCritereWhereSup($critere, $numb);
        $resultat = "";

        foreach($bouteilles as $bouteille) {
            $resultat .= $bouteille->getName() . ", Marque : " .$bouteille->getMarque() . ", Type : " .$bouteille->getAlcoholType() . ", Prix : " .$bouteille->getPrice() . "<br>";
        }

        return new Response("Liste de bouteilles rangé par " . $critere . " :<br>" . $resultat);
    }
}