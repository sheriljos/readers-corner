<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReviewsController extends AbstractController
{
    /**
     * @Route("/", name="get_aticles")
     * @Method({"GET"})
     */
    public function index()
    {
        $reviews = ['Some gibberish', 'Some other gibberish'];
        return $this->render('reviews/index.html.twig', compact('reviews'));
    }
}