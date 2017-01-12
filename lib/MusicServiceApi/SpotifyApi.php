<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\MusicServiceApi;

use SpotifyWebAPI\SpotifyWebAPI;
use SpotifyWebAPI\SpotifyWebAPIException;
use stdClass;

class SpotifyApi implements MusicServiceApiInterface
{
    /** @var SpotifyWebAPI */
    protected $api;

    public function __construct()
    {
        $this->api = new SpotifyWebAPI();
    }

    /**
     * {@inheritdoc}
     */
    public function getArtistById($artistId, $includeAlbums = false)
    {
        $response = null;

        try {
            $response = $this->api->getArtist($artistId);
        } catch(SpotifyWebAPIException $exception) {
            if ($exception->getCode() === 400) {
                return null;
            }
        }

        return $this->createArtistFromResponse($response, $includeAlbums);
    }

    /**
     * {@inheritdoc}
     */
    public function getArtistByName($artistName, $includeAlbums = false)
    {
        $artistId = $this->findArtistId($artistName);

        if ($artistId === null) {
            return null;
        }

        return $this->getArtistById($artistId, $includeAlbums);
    }

    /**
     * @inheritDoc
     */
    public function getAlbumById($albumId, $includeTracks = false)
    {
        $response = null;

        try {
            $response = $this->api->getAlbum($albumId);
        } catch(SpotifyWebAPIException $exception) {
            if ($exception->getCode() === 400) {
                return null;
            }
        }

        return $this->createAlbumFromResponse($response, $includeTracks);
    }

    /**
     * @inheritDoc
     */
    public function getAlbumByName($albumName, $includeTracks = false)
    {
        $albumId = $this->findAlbumId($albumName);

        if ($albumId === null) {
            return null;
        }

        return $this->getAlbumById($albumId, $includeTracks);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlbumsFromArtist(Artist $artist)
    {
        $albums = [];
        $response = null;

        try {
            $response = $this->api->getArtistAlbums($artist->getId());
        } catch(SpotifyWebAPIException $exception) {
            if ($exception->getCode() === 400) {
                return [];
            }
        }

        if (isset($response->items)) {
            foreach ($response->items as $albumData) {
                $albums[] = AlbumFactory::createFromResponse($albumData);
            }
        }

        return $albums;
    }

    /**
     * {@inheritDoc}
     */
    public function getTrackById($trackId)
    {
        $response = null;

        try {
            $response = $this->api->getTrack($trackId);
        } catch(SpotifyWebAPIException $exception) {
            if ($exception->getCode() === 400) {
                return null;
            }
        }

        return TrackFactory::createFromResponse($response);
    }

    /**
     * {@inheritDoc}
     */
    public function getTrackByName($trackName)
    {
        $trackId = $this->findTrackId($trackName);

        if ($trackId === null) {
            return null;
        }

        return $this->getTrackById($trackId);
    }

    /**
     * {@inheritDoc}
     */
    public function getTracksFromAlbum(Album $album)
    {
        $tracks = [];
        $response = null;

        try {
            $response = $this->api->getAlbumTracks($album->getId());
        } catch(SpotifyWebAPIException $exception) {
            if ($exception->getCode() === 400) {
                return [];
            }
        }

        if (isset($response->items)) {
            foreach ($response->items as $trackData) {
                $tracks[] = TrackFactory::createFromResponse($trackData);
            }
        }

        return $tracks;
    }

    private function findArtistId($artist)
    {
        $apiResponse = $this->api->search($artist, 'artist');

        if (!isset($apiResponse->artists) || !isset($apiResponse->artists->items) || count($apiResponse->artists->items) === 0) {
            return null;
        }

        return $apiResponse->artists->items[0]->id;
    }

    private function findAlbumId($album)
    {
        $apiResponse = $this->api->search($album, 'album');

        if (!isset($apiResponse->albums) || !isset($apiResponse->albums->items) || count($apiResponse->albums->items) === 0) {
            return null;
        }

        return $apiResponse->albums->items[0]->id;
    }

    private function findTrackId($track)
    {
        $apiResponse = $this->api->search($track, 'track');

        if (!isset($apiResponse->tracks) || !isset($apiResponse->tracks->items) || count($apiResponse->tracks->items) === 0) {
            return null;
        }

        return $apiResponse->tracks->items[0]->id;
    }

    /**
     * Creates an Artist instance using ArtistFactory, can fetch albums if $includeAlbums is true
     *
     * @param stdClass $response
     * @param bool $includeAlbums
     * @return Artist
     */
    private function createArtistFromResponse($response, $includeAlbums)
    {
        $artist = ArtistFactory::createFromResponse($response);
        if ($includeAlbums) {
            $artist->setAlbums($this->getAlbumsFromArtist($artist));
        }

        return $artist;
    }

    /**
     * Creates an Album instance using AlbumFactory, can fetch tracks if $includeTracks is true
     *
     * @param stdClass $response
     * @param bool $includeTracks
     * @return Album
     */
    private function createAlbumFromResponse($response, $includeTracks)
    {
        $album = AlbumFactory::createFromResponse($response);
        if ($includeTracks) {
            $album->setTracks($this->getTracksFromAlbum($album));
        }

        return $album;
    }
}