<?php
/**
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\Block;

use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockAttributeDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockValue;

/**
 * Spotify Play Button Block
 *
 * Adds follow button for user or artist, can be configured regarding theme and dimensions
 */
class PlayButtonBlock extends AbstractBlock
{
    /* Block Attributes names for convenience */
    const BLOCK_ATTRIBUTE_WIDTH = 'width';
    const BLOCK_ATTRIBUTE_HEIGHT = 'height';
    const BLOCK_ATTRIBUTE_THEME = 'theme';
    const BLOCK_ATTRIBUTE_LAYOUT = 'layout';
    const BLOCK_ATTRIBUTE_TYPE = 'type';
    const BLOCK_ATTRIBUTE_NAME_OR_ID = 'name_or_id';

    /**
     * Returns the parameters to the template.
     * To retrieve block attributes call $blockValue->getAttributes()
     *
     * {@inheritdoc}
     */
    public function getTemplateParameters(BlockValue $blockValue)
    {
        $attributes = $blockValue->getAttributes();
        $spotifyUri = '';

        switch ($attributes[self::BLOCK_ATTRIBUTE_TYPE]) {
            case 'track':
                $track = $this->musicServiceApi->getTrackByName($attributes[self::BLOCK_ATTRIBUTE_NAME_OR_ID]);
                if ($track === null) {
                    $track = $this->musicServiceApi->getTrackById($attributes[self::BLOCK_ATTRIBUTE_NAME_OR_ID]);
                }
                if ($track !== null) {
                    $spotifyUri = 'spotify:track:' . $track->getId();
                }
                break;
            case 'album':
                $album = $this->musicServiceApi->getAlbumByName($attributes[self::BLOCK_ATTRIBUTE_NAME_OR_ID]);
                if ($album === null) {
                    $album = $this->musicServiceApi->getAlbumById($attributes[self::BLOCK_ATTRIBUTE_NAME_OR_ID]);
                }
                if ($album !== null) {
                    $spotifyUri = 'spotify:album:' . $album->getId();
                }
                break;
            case 'playlist':
                    $spotifyUri = 'spotify:user:spotify:playlist:' . $attributes[self::BLOCK_ATTRIBUTE_NAME_OR_ID];
                break;
        }

        return [
            'width' => $attributes[self::BLOCK_ATTRIBUTE_WIDTH],
            'height' => $attributes[self::BLOCK_ATTRIBUTE_HEIGHT],
            'theme' => $attributes[self::BLOCK_ATTRIBUTE_THEME],
            'layout' => $attributes[self::BLOCK_ATTRIBUTE_LAYOUT],
            'type' => $attributes[self::BLOCK_ATTRIBUTE_TYPE],
            'name_or_id' => $attributes[self::BLOCK_ATTRIBUTE_NAME_OR_ID],
            'spotify_uri' => $spotifyUri
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function createBlockDefinition()
    {
        return new BlockDefinition(
            'spotify_play_button',
            'Play Button',
            'default',
            'bundles/ezsystemslandingpageblockspotify/images/spotifylogo.svg',
            [],
            [
                new BlockAttributeDefinition(
                    self::BLOCK_ATTRIBUTE_WIDTH,
                    'Width',
                    'integer',
                    '/\d+/',
                    'Provide widget width',
                    true,
                    true,
                    [],
                    []
                ),
                new BlockAttributeDefinition(
                    self::BLOCK_ATTRIBUTE_HEIGHT,
                    'Height',
                    'integer',
                    '/\d+/',
                    'Provide widget height',
                    true,
                    true,
                    [],
                    []
                ),
                new BlockAttributeDefinition(
                    self::BLOCK_ATTRIBUTE_THEME,
                    'Theme',
                    'select',
                    '/^(dark|light)$/',
                    'Provide valid theme name (Dark or Light)',
                    true,
                    true,
                    [],
                    [
                        'dark' => 'Dark',
                        'light' => 'Light',
                    ]
                ),
                new BlockAttributeDefinition(
                    self::BLOCK_ATTRIBUTE_LAYOUT,
                    'Layout',
                    'select',
                    '/^(list|coverart)$/',
                    'Provide valid layout name (List or Cover Art)',
                    true,
                    true,
                    [],
                    [
                        'list' => 'List',
                        'coverart' => 'Cover Art',
                    ]
                ),
                new BlockAttributeDefinition(
                    self::BLOCK_ATTRIBUTE_TYPE,
                    'Type',
                    'select',
                    '/^(track|album|playlist)$/',
                    'Valid type is either Track, Album or Playlist',
                    true,
                    false,
                    [],
                    [
                        'track' => 'Track',
                        'album' => 'Album',
                        'playlist' => 'Playlist',
                    ]
                ),
                new BlockAttributeDefinition(
                    self::BLOCK_ATTRIBUTE_NAME_OR_ID,
                    'Name (of the album/track) or Spotify ID',
                    'string',
                    '',
                    'Provide valid Name or ID',
                    true,
                    false,
                    [],
                    []
                ),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequiredAttributes()
    {
        return [
            self::BLOCK_ATTRIBUTE_WIDTH,
            self::BLOCK_ATTRIBUTE_HEIGHT,
            self::BLOCK_ATTRIBUTE_THEME,
            self::BLOCK_ATTRIBUTE_LAYOUT,
            self::BLOCK_ATTRIBUTE_TYPE,
            self::BLOCK_ATTRIBUTE_NAME_OR_ID
        ];
    }
}