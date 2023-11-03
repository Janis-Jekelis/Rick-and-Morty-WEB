<?php
declare(strict_types=1);

namespace App\Models;

class EpisodeCollection
{
    private string $api = "https://rickandmortyapi.com/api/episode";

    public function getApi(): string
    {
        return $this->api;
    }

    public function getEpisodesBySeason(int $season): array
    {
        $count = 0;
        $episodes = [];
        $request = (json_decode(file_get_contents($this->api)));
        $pageCount = $request->info->pages;
        for ($i = 1; $i <= $pageCount; $i++) {
            $request = (json_decode(file_get_contents($this->api . "?page=$i")));
            foreach ($request->results as $episode) {

                if (intval(substr($episode->episode, 1, 2)) == $season) {
                    $count++;
                    $episodes[] = new Episode(
                        $episode->id,
                        $episode->name,
                        $episode->air_date,
                        $episode->episode,
                        $episode->characters,
                        $count
                    );

                }
            }
        }
        return $episodes;
    }

    private function getAllEpisodes(): array
    {
        $episodes = [];
        $request = (json_decode(file_get_contents($this->api)));
        $pageCount = $request->info->pages;
        for ($i = 1; $i <= $pageCount; $i++) {
            $request = (json_decode(file_get_contents($this->api . "?page=$i")));
            foreach ($request->results as $episode)
                $episodes[] = new Episode(
                    $episode->id,
                    $episode->name,
                    $episode->air_date,
                    $episode->episode,
                    $episode->characters
                );
        }
        return $episodes;
    }

}