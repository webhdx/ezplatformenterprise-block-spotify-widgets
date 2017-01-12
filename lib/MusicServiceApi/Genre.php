<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\MusicServiceApi;

/**
 * Class representing music genre associated with album or artist
 */
class Genre
{
    /** @var string */
    protected $name;

    /**
     * Genre constructor.
     *
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Returns genre name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}