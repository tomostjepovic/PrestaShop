<?php
namespace PrestaShop\Module\B2BWholesale\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class ActivityType
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id_activity_type", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\OneToMany(targetEntity="PrestaShop\Module\B2BWholesale\Entity\ActivityTypeLang", cascade={"persist", "remove"}, mappedBy="activityType")
     */
    private $activityTypeLangs;

    public function __construct()
    {
        $this->activityTypeLangs = new ArrayCollection();
    }

    /**
     * @param int $langId
     * @return QuoteLang|null
     */
    public function getActivityTypeLangByLangId(int $langId): ?ActivityTypeLang
    {
        foreach ($this->activityTypeLangs as $activityTypeLang) {
            if ($langId === $activityTypeLang->getLang()->getId()) {
                return $activityTypeLang;
            }
        }

        return null;
    }

    /**
     * @param QuoteLang $quoteLang
     * @return $this
     */
    public function addActivityTypeLang(ActivityTypeLang $activityTypeLang)
    {
        $activityTypeLang->setActivityType($this);
        $this->activityTypeLangs->add($activityTypeLang);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getActivityTypeLangs()
    {
        return $this->activityTypeLangs;
    }

    public function toArray(): array
    {
        return [
            'id_activity_type' => $this->getId()
        ];
    }
}
