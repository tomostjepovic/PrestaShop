<?php

namespace PrestaShop\Module\B2BWholesale\Form\DataHandler;

use Doctrine\ORM\EntityManagerInterface;
use PrestaShop\Module\B2BWholesale\Entity\ActivityType;
use PrestaShop\Module\B2BWholesale\Entity\ActivityTypeLang;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataHandler\FormDataHandlerInterface;
use PrestaShopBundle\Entity\Repository\LangRepository;

class ActivityTypeFormDataHandler implements FormDataHandlerInterface
{
    /**
     * @var LangRepository
     */
    private $langRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param LangRepository $langRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        LangRepository         $langRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->langRepository = $langRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data)
    {
        dump($data);
        $activityType = new ActivityType();
        foreach ($data['name'] as $langId => $langName) {
            $lang = $this->langRepository->find($langId);
            $activityTypeLang = new ActivityTypeLang();
            $activityTypeLang
                ->setLang($lang)
                ->setName($langName);
            $activityType->addActivityTypeLang($activityTypeLang);
        }
        $this->entityManager->persist($activityType);
        $this->entityManager->flush();

        return $activityType->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function update($id, array $data)
    {
        $activityType = $this->entityManager->getRepository(ActivityType::class)->find($id);
        foreach ($data['name'] as $langId => $name) {
            $activityTypeLang = $activityType->getActivityTypeLangByLangId($langId);
            if (null === $activityTypeLang) {
                continue;
            }
            $activityTypeLang->setName($name);
        }
        $this->entityManager->flush();

        return $activityType->getId();
    }
}
