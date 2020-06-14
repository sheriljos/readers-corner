<?php

namespace App\Repository;

use App\Entity\Reviews;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Reviews|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reviews|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reviews[]    findAll()
 * @method Reviews[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reviews::class);
    }

    public function create()
    {
        $reviews = new Reviews();
        $reviews->setTitle('Review One');
        $reviews->setBody('This is the body of the review 1');

        try {
            $this->_em->persist($reviews);
            $this->_em->flush();

            return $reviews;
        } catch (Exception $exception) {
            echo 'An exception occured in saving your review: ',  $e->getMessage(), "\n";
        }
    }

    public function findAll()
    {
        try {
            return $this->createQueryBuilder('r')
                ->select('r')
                ->getQuery()
                ->execute();
        }  catch (Exception $exception) {
            echo 'Error occured in fetching reviews',  $e->getMessage(), "\n";
        }
    }
}
