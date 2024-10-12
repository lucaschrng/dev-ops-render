<?php

namespace App\Model;

use Symfony\Component\String\Slugger\SluggerInterface;

class AnswerModel
{
    private array $values;
    private string $username;
    private string $content;
    private int $vote;

    public function __construct(array $values)
    {
        $this->values = $values;
        $this->username = $values[0] ?? 'no username';
        $this->content = $values[1] ?? 'no content';
        $this->vote = random_int(-20, 20);
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getUsername(): string
    {
        return trim($this->username);
    }

    public function getContent(): string
    {
        return trim($this->content);
    }

    public function getVote(): int
    {
        return $this->vote;
    }
}
