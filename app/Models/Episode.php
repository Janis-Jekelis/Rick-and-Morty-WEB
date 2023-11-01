<?php
declare(strict_types=1);
namespace App\Models;

class Episode
{
    private int $id;
    private string  $name;
    private string $airDate;
    private string $idBySeason;

    public function __construct(int $id,string  $name, string $airDate, string $idBySeason)
        {
            $this->id = $id;
            $this->name = $name;
            $this->airDate = $airDate;
            $this->idBySeason = $idBySeason;
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

}