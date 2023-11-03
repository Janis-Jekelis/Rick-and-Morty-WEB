<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Episode;
use App\Models\EpisodeCollection;
use App\Response;

class SeasonController
{
    private string $api = "https://rickandmortyapi.com/api/episode";

    private array $IDs;

    public function __construct()
    {
        $this->IDs = [];
        $request = (json_decode(file_get_contents($this->api)));
        $pageCount = $request->info->pages;
        for ($i = 1; $i <= $pageCount; $i++) {
            $request = (json_decode(file_get_contents($this->api . "?page=$i")));
            foreach ($request->results as $episode) {
                if (!(in_array(intval(substr($episode->episode, 1, 2)), $this->IDs))) {
                    $this->IDs[] = intval(substr($episode->episode, 1, 2));
                }
            }


        }

    }

    public function index(): Response
    {
        return new Response(
            "AllSeasons", [
                "seasonids" => $this->IDs,

            ]

        );
    }

    public function show(int $vars): Response
    {
        return new Response(
            "SingleSeason", [
                "episodes" => (new EpisodeCollection())->getEpisodesBySeason($vars),
                "seasonID" => str_replace("/season/", "", $_SERVER['REQUEST_URI'])
            ]
        );
    }

}
