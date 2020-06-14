<?php

namespace App\Controller;

use Exception;
use App\Entity\Reviews;
use App\Repository\ReviewsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewsController extends AbstractController
{
    public $reviewsRepository;

    public function __construct(ReviewsRepository $reviewsRepository)
    {
        $this->reviewsRepository = $reviewsRepository;
    }

    /**
     * @Route("/", name="get_reviews")
     * @Method({"GET"})
     */
    public function index()
    {
        try {
            $reviews = $this->reviewsRepository->findAll();
        } catch (Exception $exception) {
            //TODO: Handle exception(hint: may be show a 404 page)
            throw new Exception("Error occured in fetching the reviews");
        }
        
        return $this->render('reviews/index.html.twig', compact('reviews'));
    }

    /**
     * @Route("/review/{id}", name="get_review")
     * @Method({"GET"})
     */
    public function getReview($id)
    {
        try {
            $review = $this->reviewsRepository->getReview($id)[0];
        } catch (Exception $exception) {
            //TODO: Handle exception(hint: may be show a 404 page)
            throw new Exception("Error occured in fetching the review of $id");
        }

        return $this->render('reviews/show.html.twig', compact('review'));    }
}