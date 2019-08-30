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
        if (!empty($parameters['search'])) {
            $query->andWhere('s.nom like :search')
                ->setParameter('search', '%' . $parameters['search'] . '%');
        }
        if (!empty($parameters['dateDebut']) && !empty($parameters['dateFin'])) {
            $query->andWhere('s.dateHeureDebut between :dateDebut and :dateFin')
                ->setParameter('dateDebut', date('Y-d-m', strtotime($parameters['dateDebut'])))
                ->setParameter('dateFin', date('Y-d-m', strtotime($parameters['dateFin'])));
        }
       if ($parameters['orga']) {
            $query->andWhere('s.organisateur = :orga')
                ->setParameter('orga', $parameters['user']);
        }
        if ($parameters['passee']) {
            $query->andWhere('s.etat = 5');
        } else {
            $query->andWhere('s.etat != 5');
        }
        return $query->getQuery()->getResult();
    }

    public function findBySite($site) {
        return $this->createQueryBuilder('s')
            ->andWhere('s.site = :site')
            ->andWhere('s.etat != 5')
            ->setParameter('site', $site->getId())->getQuery()->getResult();
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
