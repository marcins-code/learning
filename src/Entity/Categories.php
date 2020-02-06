<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriesRepository")
 */
class Categories
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $category;

    /**
     * @Gedmo\Slug(fields={"category"}, updatable=false, separator="_")
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $UpdatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    /**
     * A page can have one parent
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="childrenPages")
     */
    private $parentPage;

    /**
     * @ORM\OneToMany(targetEntity="Categories", mappedBy="parentPage")
     *
     */
    private $childrenPages;

    public function __construct()
    {
        $this->childrenPages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getParentPage(): ?self
    {
        return $this->parentPage;
    }

    public function setParentPage(?self $parentPage): self
    {
        $this->parentPage = $parentPage;

        return $this;
    }

    /**
     * @return Collection|Categories[]
     */
    public function getChildrenPages(): Collection
    {
        return $this->childrenPages;
    }

    public function addChildrenPage(Categories $childrenPage): self
    {
        if (!$this->childrenPages->contains($childrenPage)) {
            $this->childrenPages[] = $childrenPage;
            $childrenPage->setParentPage($this);
        }

        return $this;
    }

    public function removeChildrenPage(Categories $childrenPage): self
    {
        if ($this->childrenPages->contains($childrenPage)) {
            $this->childrenPages->removeElement($childrenPage);
            // set the owning side to null (unless already changed)
            if ($childrenPage->getParentPage() === $this) {
                $childrenPage->setParentPage(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getCategory();
    }
}


//    public function __toString()
//    {
//        return $this->getCategory();
//    }
//}
