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

    public function create(Reviews $reviews)
    {
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
        $query = $this->createQueryBuilder('r')
                ->select('r')
                ->getQuery();

        try {
            return $query->execute();
        }  catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getReview($id)
    {
        $query = $this->createQueryBuilder('r')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            return $query->execute();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function deleteReview($id)
    {
        $qb = $this->_em->createQueryBuilder()
            ->delete('App\Entity\Reviews', 'r')
            ->where('r.id = :id')
            ->setParameter('id', $id);

        try {
            return $qb->getQuery()->execute();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
