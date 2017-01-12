<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\MusicServiceApi;

use EzSystems\LandingPageBlockSpotify\MusicServiceApi\Error\InvalidResponseObjectFormatException;
use stdClass;

class AlbumFactory
{
    /**
     * Initializes Album object using deserialized data from Spotify API
     *
     * @param stdClass $response
     * @return Album
     */
    public static function createFromResponse($response)
    {
        if (!isset($response->id) || !isset($response->name)) {
            throw new InvalidResponseObjectFormatException();
        }

        $album = new Album($response->id, $response->name);

        return $album;
    }
}