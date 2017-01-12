<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\MusicServiceApi;

/**
 * Artist class
 */
class Artist
{
    /**
     * Identifier for Artist
     *
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Genre[] Genres describing the artist
     */
    protected $genres;

    /**
     * @var Album[] Albums associated with the artist
     */
    protected $albums;

    /**
     * Artist constructor
     *
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
     * Returns artist name
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
     * Adds genre Artist is associated with
     *
     * @param Genre $genre
     */
    public function addGenre(Genre $genre)
    {
        $this->genres[] = $genre;
    }

    /**
     * @param Genre $genre
     */
    public function removeGenre(Genre $genre)
    {
        if ($key = array_search($genre, $this->genres, true) !== false) {
            array_splice($this->genres, $key, 1);
        }
    }

    /**
     * Returns an array of albums
     *
     * @return Album[]
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param Album[] $albums
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;
    }

    /**
     * Associates Album with Artist
     *
     * @param Album $album
     */
    public function addAlbum(Album $album)
    {
        $this->albums[] = $album;
    }

    /**
     * @param Album $album
     */
    public function removeAlbum(Album $album)
    {
        if ($key = array_search($album, $this->albums, true) !== false) {
            array_splice($this->albums, $key, 1);
        }
    }

    /**
     * Finds an album using name
     *
     * @param $albumName
     * @return Album|null
     */
    public function findAlbumByName($albumName)
    {
        foreach ($this->albums as $album) {
            if ($album->getName() == $albumName) {
                return $album;
            }
        }

        return null;
    }
}