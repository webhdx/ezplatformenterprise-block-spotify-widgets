<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\MusicServiceApi\Error;

use RuntimeException;
use Exception;

class InvalidResponseObjectFormatException extends RuntimeException
{
    /**
     * @param Exception $previous
     */
    public function __construct(Exception $previous = null)
    {
        parent::__construct(
            'Invalid response object format',
            0,
            $previous
        );
    }
}