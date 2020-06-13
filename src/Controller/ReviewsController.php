<?php

namespace App\Controller;

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
        $reviews = ['Some gibberish', 'Some other gibberish'];
        return $this->render('reviews/index.html.twig', compact('reviews'));
    }

    /**
     * @Route("article/create")
     */
    public function create()
    {
        $reviews = $this->reviewsRepository->create();

        return $this->json(
            ['message'   =>  "The article is saves" . $reviews->getTitle()]
        );
    }
}