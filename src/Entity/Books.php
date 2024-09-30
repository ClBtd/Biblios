<?php

namespace App\Entity;

use App\Enum\BookStatus;
use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BooksRepository::class)]
class Books
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(min: 5)]
    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\Regex(pattern: '/^(97(8|9))?\d{9}(\d|X)$/')]
    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?string $isbn = null;

    #[Assert\Regex(pattern: '/\.(jpe?g|png|gif)$/i')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cover = null;

    #[Assert\NotBlank()]
    #[ORM\Column]
    private ?\DateTimeImmutable $editedAt = null;

    #[Assert\Length(min: 50)]
    #[Assert\NotBlank()]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $plot = null;

    #[Assert\Type('integer')]
    #[Assert\GreaterThan(10)]
    #[Assert\NotBlank()]
    #[ORM\Column]
    private ?int $pageNumber = null;

    #[Assert\NotBlank()]
    #[ORM\Column(length: 255)]
    private ?BookStatus $status = null;

    #[Assert\NotBlank()]
    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editors $editor = null;

    /**
     * @var Collection<int, Comments>
     */
    #[ORM\OneToMany(targetEntity: Comments::class, mappedBy: 'book', orphanRemoval: true)]
    private Collection $comments;

    #[Assert\NotBlank()]
    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Authors $author = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getEditedAt(): ?\DateTimeImmutable
    {
        return $this->editedAt;
    }

    public function setEditedAt(\DateTimeImmutable $editedAt): static
    {
        $this->editedAt = $editedAt;

        return $this;
    }

    public function getPlot(): ?string
    {
        return $this->plot;
    }

    public function setPlot(string $plot): static
    {
        $this->plot = $plot;

        return $this;
    }

    public function getPageNumber(): ?int
    {
        return $this->pageNumber;
    }

    public function setPageNumber(int $pageNumber): static
    {
        $this->pageNumber = $pageNumber;

        return $this;
    }

    public function getStatus(): ?BookStatus
    {
        return $this->status;
    }

    public function setStatus(BookStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getEditor(): ?Editors
    {
        return $this->editor;
    }

    public function setEditor(?Editors $editor): static
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    public function getAuthor(): ?Authors
    {
        return $this->author;
    }

    public function setAuthor(?Authors $author): static
    {
        $this->author = $author;

        return $this;
    }
}
