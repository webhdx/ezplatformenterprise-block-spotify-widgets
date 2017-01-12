<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\MusicServiceApi;

use EzSystems\LandingPageBlockSpotify\MusicServiceApi\Error\InvalidResponseObjectFormatException;
use stdClass;

class ArtistFactory
{
    /**
     * Initializes Artist object using deserialized data from Spotify API
     *
     * @param stdClass $response
     * @return Artist
     */
    public static function createFromResponse($response)
    {
        if (!isset($response->id) || !isset($response->name)) {
            throw new InvalidResponseObjectFormatException();
        }

        $artist = new Artist($response->id, $response->name);

        if (isset($response->genres)) {
            foreach ($response->genres as $genre) {
                $artist->addGenre(new Genre($genre));
            }
        }

        return $artist;
    }
}