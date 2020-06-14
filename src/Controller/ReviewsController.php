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
    public $reviewsRespository;

    public function __construct(ReviewsRepository $reviewsRepository)
    {
        $this->reviewsRepository = $reviewsRepository;
    }

    /**
     * @Route("/", name="get_aticles")
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
}