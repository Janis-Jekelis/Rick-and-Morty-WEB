<?php
declare(strict_types=1);
namespace App\Models;

class Episode
{
    private int $id;
    private string  $name;
    private string $airDate;
    private string $idBySeason;
    private array $characters;

    private ?int $countInSeason;

    public function __construct(
        int $id,
        string  $name,
        string $airDate,
        string $idBySeason,
        array $characters,
        ?int $countInSeason=null
    )
        {
            $this->id = $id;
            $this->name = $name;
            $this->airDate = $airDate;
            $this->idBySeason = $idBySeason;
            if ($countInSeason!=null)$this->countInSeason=$countInSeason;
        }


    public function getId(): int
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }

       public function getAirDate(): string
    {
        return $this->airDate;
    }

    public function getIdBySeason(): string
    {
        return $this->idBySeason;
    }


    public function getCountInSeason(): ?int
    {
        return $this->countInSeason;
    }

    public function getCharacters(): array
    {
        return $this->characters;
    }

}