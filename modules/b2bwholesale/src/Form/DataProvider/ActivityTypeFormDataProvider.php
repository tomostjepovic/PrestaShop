<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace PrestaShop\Module\B2BWholesale\Form\DataProvider;

use Doctrine\ORM\EntityManagerInterface;
use PrestaShop\Module\B2BWholesale\Entity\ActivityType;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Domain\Manufacturer\Query\GetManufacturerForEditing;
use PrestaShop\PrestaShop\Core\Domain\Manufacturer\QueryResult\EditableManufacturer;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;

/**
 * Provides data for manufacturers add/edit forms
 */
final class ActivityTypeFormDataProvider implements FormDataProviderInterface
{
    protected $entityManager;
    /**
     * @var bool
     */
    private $multistoreEnabled;

    /**
     * @var int[]
     */
    private $defaultShopAssociation;

    /**
     * @param bool $multistoreEnabled
     * @param int[] $defaultShopAssociation
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        $multistoreEnabled,
        array $defaultShopAssociation
    ) {
        $this->entityManager = $entityManager;
        $this->multistoreEnabled = $multistoreEnabled;
        $this->defaultShopAssociation = $defaultShopAssociation;
    }

    /**
     * {@inheritdoc}
     */
    public function getData($activityTypeId)
    {
        $activity_type = $this->entityManager->getRepository(ActivityType::class)->find($activityTypeId);

        $data = [];
        foreach ($activity_type->getActivityTypeLangs() as $activity_type_lang) {
            $data['name'][$activity_type_lang->getLang()->getId()] = $activity_type_lang->getName();
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultData()
    {
        if ($this->multistoreEnabled) {
            $data['shop_association'] = $this->defaultShopAssociation;
        }
        $data['name'] = [];

        return $data;
    }
}
