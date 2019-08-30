<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */

    public function findByParameters($parameters)
    {
        $query = $this->createQueryBuilder('s')
            ->andWhere('s.site = :site')
            ->setParameter('site', $parameters['site']);
        if (isset($parameters['search'])) {
            $query->andWhere('s.nom like :search')
                ->setParameter('search', $parameters['search']);
        }
        if (isset($parameters['dateDebut']) && isset($parameters['dateFin'])) {
            $query->andWhere('s.date_heure_debut between :dateDebut and :dateFin')
                ->setParameter('dateDebut', $parameters['dateDebut'])
                ->setParameter('dateFin', $parameters['dateFin']);
        }
     /*  if (isset($parameters['orga'])) {
            $query->andWhere('s.organisateur = :orga')
                ->setParameter('orga', $parameters['orga']);
        }*/
        if (isset($parameters['passee'])) {
            $query->andWhere('s.etat = :passee')
                ->setParameter('passee', $parameters['passee']);
        }
        return $query->getQuery()->getResult();
    }

    public function queryResult($val) {
        return $val->getQuery()->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
