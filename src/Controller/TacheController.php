<?php

namespace App\Controller;

use App\Entity\Tache;
use App\Repository\TacheRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TacheController extends AbstractController
{
    // 1. المسار الأول: /taches -> لعرض قائمة جميع المهام
    #[Route('/taches', name: 'app_taches')]
    public function index(TacheRepository $tacheRepository): Response
    {
        // جلب كل المهام من قاعدة البيانات
        $taches = $tacheRepository->findAll();

        return $this->render('tache/index.html.twig', [
            'taches' => $taches,
        ]);
    }

    // 2. المسار الثاني: /taches/ajouter -> لإضافة مهمة وهمية وتخزينها
    #[Route('/taches/ajouter', name: 'app_tache_ajouter')]
    public function ajouter(EntityManagerInterface $em): Response
    {
        $tache = new Tache();
        $tache->setTitre('Première tâche');
        $tache->setDescription('Ceci est la description de la tâche test.');
        $tache->setTerminee(false);
        $tache->setDateCreation(new \DateTime());

        $em->persist($tache);
        $em->flush();

        return new Response("Tache créée avec l'id : " . $tache->getId());
    }

    // 3. المسار الثالث: /taches/{id} -> لعرض تفاصيل مهمة محددة
    #[Route('/taches/{id}', name: 'app_tache_detail')]
    public function detail(Tache $tache): Response
    {
        // بفضل ParamConverter في Symfony، سيتم جلب المهمة تلقائياً عبر الـ id الموجود في الرابط!
        return $this->render('tache/detail.html.twig', [
            'tache' => $tache,
        ]);
    }
}
