<?php
declare(strict_types=1);
namespace App\Models;

class Characters
{
    private array $characterLinks;
    private array $characterImages;
    private string $api="https://rickandmortyapi.com/api/episode";
    public function __construct(string $episodeID)
    {
        $this->characterLinks = [];
        $request = (json_decode(file_get_contents($this->api)));
        $pageCount = $request->info->pages;
        for ($i = 1; $i <= $pageCount; $i++) {
            $request = (json_decode(file_get_contents($this->api . "?page=$i")));
            foreach ($request->results as $episode) {

                if ($episode->episode==$episodeID) {
                    $this->characterLinks=$episode->characters;
                }
            }
        }
    }

    public function getCharacterImages(): array
    {
        $this->characterImages=[];
        foreach ($this->characterLinks as $character) {
            $request=json_decode(file_get_contents($character));
            $this->characterImages []= $request->image;
                }
        return $this->characterImages;
    }

}
