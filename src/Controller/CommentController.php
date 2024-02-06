<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Job;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Request;

class CommentController extends AbstractController
{

    /**
     * @Route ("/comment/create/{id}", name="create_comment")
     */
    public function createComment(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $job = $entityManager->getRepository(Job::class)->find($id);

        if (!$job) {
            throw $this->createNotFoundException('The job does not exist');
        }
        return $this->render('comment/create.html.twig',['job' => $job]);
    }


    /**
     * @Route("/job/{id}/comment", name="submit_comment", methods={"POST"})
     */
    public function submitComment(Request $request, $id): Response
    {
        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        $commentTitle = $request->request->get('title');
        $commentText = $request->request->get('description');
        $username = $request->request->get('username');
        $name = $request->request->get('name');

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        if (!$user) {
            $user = new User();
            $user->setUsername($username);
            $user->setName($name);
            $entityManager->persist($user);
        }

        $comment = new Comment();
        $comment->setTitle($commentTitle);
        $comment->setDescription($commentText);
        $comment->setUser($user);
        $comment->setJob($job);

        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('app_job_show', ['slug' => $job->getSlug()]);
    }


    /**
     * @Route("/comment/{id}/edit/{slug}", name="edit_comment")
     */
    public function editComment(Request $request, $id, $slug): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comment::class)->find($id);
        $job = $entityManager->getRepository(Job::class)->findOneBy(['slug' => $slug]);

        if (!$comment || !$job) {
            throw $this->createNotFoundException('The comment or job does not exist');
        }

        return $this->render('comment/edit.html.twig', ['comment' => $comment, 'job' => $job]);
    }


    /**
     * @Route("/comment/{id}/update", name="update_comment")
     */
    public function updateComment(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comment::class)->find($id);

        if(!$comment)
        {
            throw $this->createNotFoundException('The comment does not exist');
        }

        $title = $request->request->get('title');
        $description = $request->request->get('description');

        $comment->setTitle($title);
        $comment->setDescription($description);

        $entityManager->flush();

        return $this->redirectToRoute('app_job_show', ['slug' => $comment->getJob()->getSlug()]);

    }


    /**
     * @Route("comment/delete", name="delete_comment", methods={"POST"})
     */
    public function deleteComment(Request $request)
    {
        $commentId = $request->request->get('comment_id');
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Comment::class)->find($commentId);

        if (!$comment) {
            throw $this->createNotFoundException('the comment does not exist');
        }

        $slug = $comment->getJob()->getSlug();

        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('app_job_show', ['slug' => $slug]);
    }




    /**
     * @Route("/comments/{id}/vote/{direction<up|down>}", methods="POST")
     */
    public function commentVote($id, $direction, LoggerInterface $logger)
    {
        // todo - use id to query the database

        // use real logic here to save this to the database
        if ($direction === 'up') {
            $logger->info('Voting up!');
            $currentVoteCount = rand(7, 100);
        } else {
            $logger->info('Voting down!');
            $currentVoteCount = rand(0, 5);
        }

        return $this->json(['votes' => $currentVoteCount]);
    }
}
