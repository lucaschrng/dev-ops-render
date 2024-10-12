<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Slug(fields={"name"})
     */
    private string $slug = '';

    /**
     * @ORM\Column(type="text")
     */
    private string $question;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?datetimeInterface $askedAt = null;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $votes = 0;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question", fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private Collection $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAskedAt(): ?DateTimeInterface
    {
        return $this->askedAt;
    }

    public function setAskedAt(?DateTimeInterface $askedAt): self
    {
        $this->askedAt = $askedAt;

        return $this;
    }

    public function getVotesString(): string
    {
        $prefix = $this->getVotes() >= 0 ? '+' : '-';

        return sprintf('%s %d', $prefix, abs($this->getVotes()));
    }

    public function getVotes(): int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function upVote(): self
    {
        $this->votes++;

        return $this;
    }

    public function downVote(): self
    {
        $this->votes--;

        return $this;
    }

    public function getFormattedAskedAt(): string
    {
        return $this->askedAt ? $this->askedAt->format('d/m/Y') : '';
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        // set the owning side to null (unless already changed)
        if ($this->answers->removeElement($answer) && $answer->getQuestion() === $this) {
            $answer->setQuestion(null);
        }

        return $this;
    }
}
