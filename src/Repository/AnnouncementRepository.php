<?php

namespace App\Repository;

use App\Entity\Announcement;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Announcement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Announcement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Announcement[]    findAll()
 * @method Announcement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnouncementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Announcement::class);
    }

    // /**
    //  * @return Announcement[] Returns an array of Announcement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Announcement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAnnouncementUser($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $value)
//            ->join('a.id_user', 'id_user')
//            ->join('a.idBalcony', 'idBalcony')
            ->getQuery()
            ->getResult();
    }

    public function getParametersForFiltration($type)
    {
        $selectParameters = [
            'MAX(a.price) as max_price',
            'MIN(a.price) as min_price',
            'MAX(a.total_area) as max_total_area',
            'MIN(a.total_area) as min_total_area',
            'MAX(a.living_area) as max_living_area',
            'MIN(a.living_area) as min_living_area',
            'MAX(a.kitchen_area) as max_kitchen_area',
            'MIN(a.kitchen_area) as min_kitchen_area',
        ];
        return $this->createQueryBuilder('a')
            ->select($selectParameters)
            ->where('a.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getResult()[0];
    }

    public function getFiltrationAnnouncement($params)
    {
        $parameters = [
            'type'             => $params['type'],
            'total_area_max'   => $params['total_area']['max'],
            'total_area_min'   => $params['total_area']['min'],
            'living_area_max'  => $params['living_area']['max'],
            'living_area_min'  => $params['living_area']['min'],
            'kitchen_area_max' => $params['kitchen_area']['max'],
            'kitchen_area_min' => $params['kitchen_area']['min'],
            'price_max'        => $params['price']['max'],
            'price_min'        => $params['price']['min'],
        ];

        $query = $this->createQueryBuilder('a')->andWhere('a.type = :type');

        if ($params['apartment_size'] != 'null') {
            $query->andWhere('a.idApartment_size = :apartment_size');
            $parameters['apartment_size'] = $params['apartment_size'];
        }
        if ($params['due_date'] != 'null') {
            $query->andWhere('a.idDue_date = :due_date');
            $parameters['due_date'] = $params['due_date'];
        }
        if ($params['ownership'] != 'null') {
            $query->andWhere('a.idOwnership = :ownership');
            $parameters['ownership'] = $params['ownership'];
        }
        if ($params['type_house'] != 'null') {
            $query->andWhere('a.idType_house = :type_house');
            $parameters['type_house'] = $params['type_house'];
        }
        if ($params['balcony'] != 'null') {
            $query->andWhere('a.idBalcony = :balcony');
            $parameters['balcony'] = $params['balcony'];
        }

        $query->andWhere('a.total_area <= :total_area_max')
            ->andWhere('a.total_area >= :total_area_min')
            ->andWhere('a.living_area <= :living_area_max')
            ->andWhere('a.living_area >= :living_area_min')
            ->andWhere('a.kitchen_area <= :kitchen_area_max')
            ->andWhere('a.kitchen_area >= :kitchen_area_min')
            ->andWhere('a.price <= :price_max')
            ->andWhere('a.price >= :price_min')
            ->setParameters($parameters);
        return $query->getQuery()->getResult();
    }

    public function findPhotosByUser($value)
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a.photos
            FROM App\Entity\Announcement a
            WHERE a.id_user = :id'
        )->setParameter('id', $value);

        // returns an array of Product objects
        return $query->getResult();
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.id_user = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getArrayResult();
    }
}
