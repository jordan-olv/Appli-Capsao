<?php

namespace App\Repository;

use App\Entity\ApiEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApiEvent>
 *
 * @method ApiEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiEvent[]    findAll()
 * @method ApiEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiEventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiEvent::class);
    }

    public function save(ApiEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApiEvent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    public function addEventDB($fluxrss,$em): void {
        $RAW_QUERY = 'TRUNCATE TABLE api_event';
            
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();


        $em->flush();

        $apirss = new ApiEvent();
        $apirss->setTitle('--- Vide ---');
        $apirss->setDescription('empty data for slider select');
        $apirss->setPubDate('');
        $apirss->setLink('');
        $apirss->setGuid('');
        $apirss->setUrlImg('');
        $apirss->setContent('');
        $this->save($apirss, true);   


        // dd($feeds);
        try {
            $feeds = file_get_contents($fluxrss);
            
            // rename de la balise <content:encoded> sinon on ne peut récupérer ce qu'elle contient
            $feeds = str_replace("<content:encoded>","<contentEncoded>",$feeds);
            $feeds = str_replace("</content:encoded>","</contentEncoded>",$feeds);
            $rss = simplexml_load_string($feeds, 'SimpleXMLElement', LIBXML_NOCDATA);
            $item = $rss->channel->item;

            foreach ($item as $key => $value) {

                // Ajout des infos provenant du flux rss dans la bdd
                ////////////////////////
                $apirss = new ApiEvent();
                
                $apirss->setTitle($value->title);
                $apirss->setDescription($value->description);
                $apirss->setPubDate($value->pubDate);
                $apirss->setLink($value->link);
                $apirss->setGuid($value->guid);
                $apirss->setUrlImg($value->enclosure->attributes()->url);
                $apirss->setContent($value->contentEncoded);
                ////////////////////////
                
                $this->save($apirss, true);
                // dd($apirss);
            }
        } catch (\Throwable $th) {
            // throw $th;
        }
        
    }

//    /**
//     * @return ApiEvent[] Returns an array of ApiEvent objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ApiEvent
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
