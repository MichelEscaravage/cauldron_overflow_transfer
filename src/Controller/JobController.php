<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Job;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class JobController extends AbstractController
{
    /**
     * @Route("/job", name="app_job")
     */
    public function index(Environment $twigEnvironment, EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Job::class);
        $jobs = $repository->findAll();

        return $this->render('job/index.html.twig', [
            'jobs' => $jobs,
        ]);

    }

    /**
     * @Route("/job/{slug}", name="app_job_show")
     */
    public function show($slug, EntityManagerInterface $entityManager)
    {
        $repository = $entityManager->getRepository(Job::class);
        $job = $repository->findOneBy(['slug' => $slug]);



        return $this->render('job/show.html.twig', [
            'job' => $job,
        ]);

    }
}