<?php
namespace PrestaShop\Module\B2BWholesale\Entity;

use Doctrine\ORM\Mapping as ORM;
use PrestaShopBundle\Entity\Lang;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class ActivityTypeLang
{
    /**
     * @var ActivityType
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="PrestaShop\Module\B2BWholesale\Entity\ActivityType", inversedBy="activityTypeLangs")
     * @ORM\JoinColumn(name="id_activity_type", referencedColumnName="id_activity_type", nullable=false)
     */
    private ActivityType $activityType;

    /**
     * @var Lang
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="PrestaShopBundle\Entity\Lang")
     * @ORM\JoinColumn(name="id_lang", referencedColumnName="id_lang", nullable=false, onDelete="CASCADE")
     */
    private Lang $lang;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @return ActivityType
     */
    public function getActivityType()
    {
        return $this->activityType;
    }

    /**
     * @param ActivityType $quote
     * @return $this
     */
    public function setActivityType(ActivityType $activity_type)
    {
        $this->activityType = $activity_type;

        return $this;
    }

    /**
     * @return Lang
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @param Lang $lang
     * @return $this
     */
    public function setLang(Lang $lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }
}
