<?php

namespace App\Controller;

use Exception;
use App\Entity\Reviews;
use App\Repository\ReviewsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * @Route("review/create", name="review_create")
     * @Method({"GET", "POST"})
     */
    public function createReview(Request $request)
    {
        $review = new Reviews();

        $form = $this->getForm($review, "Drop your review");

        $form->handleRequest($request);
                                     //TODO: Perform validation
        if ($form->isSubmitted() &&  $form->isValid()) {
            $review = $form->getData();

            try {
                $this->reviewsRepository->create($review);
            } catch (Exception $exception) {
                //TODO: Handle exception(hint: may be show a 404 page)
                throw new Exception("Error occured in saving the review");
            }

            return $this->redirectToRoute('get_reviews');
        }

        return $this->render(
            'reviews/createOrEdit.html.twig', [
                'form'  => $form->createView(),
                'title' => 'Drop your review'
        ]);
    }

    /**
     * @Route("review/edit/{id}", name="review_edit")
     * @Method({"PUT"})
     */
    public function editReview(Request $request, $id)
    {
        try {
            $review = $this->reviewsRepository->getReview($id)[0];
    
            $form = $this->getForm($review, "Drop your review");
            $form->handleRequest($request);
                                         //TODO: Perform validation
            if ($form->isSubmitted() &&  $form->isValid()) {
                $review = $form->getData();
    
                try {
                    $this->reviewsRepository->create($review);
                } catch (Exception $exception) {
                    //TODO: Handle exception(hint: may be show a 404 page)
                    throw new Exception("Error occured in saving the review");
                }
    
                return $this->redirectToRoute('get_reviews');
            }
    
            return $this->render(
                'reviews/createOrEdit.html.twig', [
                    'form'  => $form->createView(),
                    'title' => 'Edit your review'
            ]);
        } catch (Exception $exception) {
            //TODO: show a notification that an error occured
        }
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

        return $this->render('reviews/show.html.twig', compact('review'));    
    }

    /**
     * @Route("/reviews/delete/{id}")
     * @Method({"DELETE"})
     */
    public function deleteReview($id)
    {
        try {
            if ($this->reviewsRepository->deleteReview($id)) {
                return $this->json(['success' => true],200);
            }

            return $this->json(['success' => false],200);
        } catch (Exception $exception) {
            //TODO: Handle exception(hint: may be show a 404 page)
            throw new Exception("Error occured in deleting the review of $id");
        }
    }

    private function getForm(Reviews $review, $label)
    {
        return
            $this->createFormBuilder($review)
                ->add('title', TextType::class, ['attr' => ['class' => 'form-control']])
                ->add('body', TextareaType::class, ['attr' => ['class' => 'form-control']])
                ->add('save', SubmitType::class, [
                    'label' => $label, 
                    'attr' => ['class' => 'btn btn-primary mt-3'
                ]])->getForm();
    }
}