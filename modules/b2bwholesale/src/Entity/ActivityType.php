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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private string $name;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->$id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function toArray(): array
    {
        return [
            'id_activity_type' => $this->getId(),
            'name' => $this->getName(),
        ];
    }
}
