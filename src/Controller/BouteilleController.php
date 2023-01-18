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
    
    #[Route('/liste_bouteilles_all', name: 'liste_bouteilles')]
    public function listeBouteilleAll(ManagerRegistry $doctrine): Response {
        $bouteilles = $doctrine->getRepository(Bouteille::class)->findAll();
        $resultat = "";
        $alerte = "";

        foreach($bouteilles as $bouteille) {
            if ($bouteille->getQuantity() < 10) {
               $alerte = "<i style='color:red'> Stock très faible</i>";
            } elseif ($bouteille->getQuantity() >= 10 && $bouteille->getQuantity() < 50) {
                $alerte = "<i style='color:orange'> Stock faible</i>";
            } else {
                $alerte = "<i style='color:green'> Stock bon</i>";
            }
            $resultat .= $bouteille->getName() . " " .$bouteille->getQuantity() . " " .$alerte . "<br>";
        }

        return new Response("Quantités en stock : <br>" . $resultat);
    }

    #[Route('/liste_bouteilles/{price}', name: 'liste_bouteilles_price')]
    public function findByPrice(ManagerRegistry $doctrine, BouteilleRepository $bouteilleRepo, int $price): Response {
        $bouteilles = $bouteilleRepo->findByPricePlus($price);
        $resultat = "";

        foreach($bouteilles as $bouteille) {
            $resultat .= $bouteille->getName() . " " .$bouteille->getPrice() . "<br>";
        }

        return new Response("Quantités en stock : <br>" . $resultat);
    }

    #[Route('/liste_bouteilles/orderByCritere/{critere}', name: 'liste_bouteilles_critere')]
    public function orderByCritere(ManagerRegistry $doctrine, BouteilleRepository $bouteilleRepo, string $critere): Response {
        $bouteilles = $bouteilleRepo->orderByCritere($critere);
        $resultat = "";

        foreach($bouteilles as $bouteille) {
            $resultat .= $bouteille->getName() . ", Marque : " .$bouteille->getMarque() . ", Type : " .$bouteille->getAlcoholType() . ", Prix : " .$bouteille->getPrice() . "<br>";
        }

        return new Response("Liste de bouteilles rangé par" . $critere . " :<br>" . $resultat);
    }

    
    #[Route('/liste_bouteilles/orderByCritereWhereSup/{critere}/{numb}', name: 'liste_bouteilles_numb')]
    public function orderByCritereWhereSup(ManagerRegistry $doctrine, BouteilleRepository $bouteilleRepo, string $critere, string $numb): Response {
        $bouteilles = $bouteilleRepo->orderByCritereWhereSup($critere, $numb);
        $resultat = "";

        foreach($bouteilles as $bouteille) {
            $resultat .= $bouteille->getName() . ", Marque : " .$bouteille->getMarque() . ", Type : " .$bouteille->getAlcoholType() . ", Prix : " .$bouteille->getPrice() . "<br>";
        }

        return new Response("Liste de bouteilles rangé par " . $critere . " :<br>" . $resultat);
    }

}