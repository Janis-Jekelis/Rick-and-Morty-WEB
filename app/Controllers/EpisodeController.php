<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\Characters;
use App\Models\EpisodeCollection;
use App\Response;


class EpisodeController
{
    public function show(int $vars): Response
    {
        $season = (json_decode(file_get_contents("season.json"))->id);

        $episodeIdBySeason = "S";

        if (intval($season < 10)) {
            $episodeIdBySeason .= "0" . $season;
        } else {
            $episodeIdBySeason .= $season;
        }
        if ($vars < 10) {
            $episodeIdBySeason .= "E" . "0" . $vars;
        } else {
            $episodeIdBySeason .= "E" . $vars;
        }

        return new Response(
            "SingleEpisode", [
                "characters" => (new Characters($episodeIdBySeason))->getCharacterImages()

            ]
        );
    }

    public function search(): ?Response
    {
        $search = (json_decode(file_get_contents("search.json")));
        $search = strtoupper($search);
        $episodeIdBySeason = $search;
        $response = new Characters($episodeIdBySeason);
        if (empty($response->getCharacterImages())) {
            return new Response(
                "noResults", []
            );
        }

        return new Response(
            "Search", [
                "characters" => $response->getCharacterImages()
            ]
        );
    }
}