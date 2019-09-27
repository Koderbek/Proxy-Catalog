<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 27.09.2019
 * Time: 8:18
 */

namespace App\Service;


use App\Entity\Proxy;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ImportService
{
    /** @var EntityManagerInterface $em */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function parseCSV(UploadedFile $file)
    {
        try {
            $fileData = str_replace(';', '', file_get_contents($file));
            $proxies = explode(PHP_EOL, $fileData);

            foreach ($proxies as $proxy) {
                $data = explode(' ', $proxy);
                $ip = $data[0];
                $port = $data[1];
                $entity = new Proxy();
                $entity->setIp($ip);
                $entity->setPort($port);

                $this->em->persist($entity);
            }
        } catch (\Exception $exception) {
            throw new HttpException(409, 'File error');
        }

        $this->em->flush();
    }
}