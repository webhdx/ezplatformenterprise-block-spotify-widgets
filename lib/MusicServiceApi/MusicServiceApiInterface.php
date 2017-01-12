<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\MusicServiceApi;

/**
 * Interface for loading data from external APIs like Spotify or last.fm
 */
interface MusicServiceApiInterface
{
    /**
     * Loads artist from external API using artist name
     *
     * @param string $artistName
     * @param bool $includeAlbums
     * @return Artist
     */
    public function getArtistByName($artistName, $includeAlbums = false);

    /**
     * Loads artist from external API using artist identifier
     *
     * @param string $artistId
     * @param bool $includeAlbums
     * @return Artist
     */
    public function getArtistById($artistId, $includeAlbums = false);

    /**
     * Loads album from external API using album name
     *
     * @param string $albumName
     * @param bool $includeTracks
     * @return Album
     */
    public function getAlbumByName($albumName, $includeTracks = false);

    /**
     * Loads album from external API using album identifier
     *
     * @param string $albumId
     * @param bool $includeTracks
     * @return Album
     */
    public function getAlbumById($albumId, $includeTracks = false);

    /**
     * Loads all albums associated with $artist
     *
     * @param Artist $artist
     * @return Album[]
     */
    public function getAlbumsFromArtist(Artist $artist);

    /**
     * Loads track from external API using track name
     *
     * @param string $trackName
     * @return Track
     */
    public function getTrackByName($trackName);

    /**
     * Loads track from external API using track identifier
     *
     * @param string $trackId
     * @return Track
     */
    public function getTrackById($trackId);

    /**
     * Loads all tracks associated with $albun
     *
     * @param Album $album
     * @return Track[]
     */
    public function getTracksFromAlbum(Album $album);
}