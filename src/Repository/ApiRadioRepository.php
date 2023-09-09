<?php

namespace App\Repository;

use App\Entity\ApiRadio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApiRadio>
 *
 * @method ApiRadio|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiRadio|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiRadio[]    findAll()
 * @method ApiRadio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiRadioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiRadio::class);
    }

    public function save(ApiRadio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApiRadio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findZipCode($apiRadio,$zipCode): void{

            // Récupération de la liste des villes contenant les latitudes et longitudes
            // https://www.data.gouv.fr/fr/datasets/villes-de-france/

            $citiesJson = file_get_contents('assets/cities.json');
            $json = json_decode($citiesJson, true);
            $jsonCities = $json['cities'];


            $isFinded   = false;

            // Chercher dans le json si on trouve une correspondance etre un code postal du json et celui rentré 
            
            foreach ($jsonCities as $key => $value) {
                if($value['zip_code'] == $zipCode){
                    $correctInfo = $value;
                    $isFinded    = true;
                }
            }

            // Si trouvé rajouter dans la bdd les coordonnées

            if($isFinded){
                $concat = $correctInfo['latitude'].','.$correctInfo['longitude'];
                $apiRadio->setCoordonnees($concat);
            }
    }

    public function updateImgUrl($apiRadio): void{
        if(!$apiRadio->getimageURL() == null){
            $apiRadio->setimageURL('https://latinoclub.fr/assets/img/'.$apiRadio->getimageURL());
        }

        $this->save($apiRadio, true);
    }

//    /**
//     * @return ApiRadio[] Returns an array of ApiRadio objects
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

//    public function findOneBySomeField($value): ?ApiRadio
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
