<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\MusicServiceApi;

use EzSystems\LandingPageBlockSpotify\MusicServiceApi\Error\InvalidResponseObjectFormatException;
use stdClass;

class TrackFactory
{
    /**
     * Initializes Track object using deserialized data from Spotify API
     *
     * @param stdClass $response
     * @return Track
     */
    public static function createFromResponse($response)
    {
        if (!isset($response->id) || !isset($response->name)) {
            throw new InvalidResponseObjectFormatException();
        }

        $track = new Track($response->id, $response->name);

        return $track;
    }
}