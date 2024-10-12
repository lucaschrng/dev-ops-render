<?php

namespace App\Model;

use Symfony\Component\String\Slugger\SluggerInterface;

class QuestionModel
{
    private array $values;
    private string $name;
    private string $question;
    private int $vote;
    private string $slug;

    public function __construct(array $values, SluggerInterface $slugger)
    {
        $this->values = $values;
        $this->name = $values[0] ?? 'no name';
        $this->question = $values[1] ?? 'no question';
        $this->vote = random_int(-20, 20);
        $this->slug = strtolower($slugger->slug($this->name)->toString());
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getName(): string
    {
        return trim($this->name);
    }

    public function getQuestion(): string
    {
        return trim($this->question);
    }

    public function getVote(): int
    {
        return $this->vote;
    }

    public function getSlug(): string
    {
        return trim($this->slug);
    }
}
