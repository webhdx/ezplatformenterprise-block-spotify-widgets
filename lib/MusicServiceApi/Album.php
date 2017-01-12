<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\MusicServiceApi;

/**
 * Album class
 */
class Album
{
    /**
     * Identifier for Album
     *
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Track[]
     */
    protected $tracks;

    /**
     * Album constructor
     *
     * @param string $id
     * @param string $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns album name
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

    /**
     * @return Track[]
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * @param Track[] $tracks
     */
    public function setTracks($tracks)
    {
        $this->tracks = $tracks;
    }

    /**
     * Adds track to the album
     *
     * @param Track $track
     */
    public function addTrack(Track $track)
    {
        $this->tracks[] = $track;
    }

    /**
     * @param Track $track
     */
    public function removeTrack(Track $track)
    {
        if ($key = array_search($track, $this->tracks, true) !== false) {
            array_splice($this->tracks, $key, 1);
        }
    }

    public function getTracksCount()
    {
        return count($this->tracks);
    }
}