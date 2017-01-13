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
 * Spotify Follow Button Block
 *
 * Adds follow button for user or artist, can be configured regarding theme and dimensions
 */
class FollowButtonBlock extends AbstractBlock
{
    /* Block Attributes names for convenience */
    const BLOCK_ATTRIBUTE_WIDTH = 'width';
    const BLOCK_ATTRIBUTE_HEIGHT = 'height';
    const BLOCK_ATTRIBUTE_THEME = 'theme';
    const BLOCK_ATTRIBUTE_LAYOUT = 'layout';
    const BLOCK_ATTRIBUTE_SHOW_FOLLOWER_COUNT = 'show_follower_count';
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
            case 'user':
                $spotifyUri = 'spotify:user:' . $attributes[self::BLOCK_ATTRIBUTE_NAME_OR_ID];
                break;
            case 'artist':
                $artist = $this->musicServiceApi->getArtistByName($attributes[self::BLOCK_ATTRIBUTE_NAME_OR_ID]);

                if (null !== $artist) {
                    $spotifyUri = 'spotify:artist:' . $artist->getId();
                }
                break;
        }

        return [
            'width' => $attributes[self::BLOCK_ATTRIBUTE_WIDTH],
            'height' => $attributes[self::BLOCK_ATTRIBUTE_HEIGHT],
            'theme' => $attributes[self::BLOCK_ATTRIBUTE_THEME],
            'layout' => $attributes[self::BLOCK_ATTRIBUTE_LAYOUT],
            'type' => $attributes[self::BLOCK_ATTRIBUTE_TYPE],
            'name_or_id' => $attributes[self::BLOCK_ATTRIBUTE_NAME_OR_ID],
            'show_follower_count' => $attributes[self::BLOCK_ATTRIBUTE_SHOW_FOLLOWER_COUNT],
            'spotify_uri' => $spotifyUri
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function createBlockDefinition()
    {
        return new BlockDefinition(
            'spotify_follow_button',
            'Follow Button',
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
                    false,
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
                    '/^(basic|detailed)$/',
                    'Provide valid layout name (Basic or Detailed)',
                    true,
                    true,
                    [],
                    [
                        'basic' => 'Basic',
                        'detail' => 'Detailed',
                    ]
                ),
                new BlockAttributeDefinition(
                    self::BLOCK_ATTRIBUTE_SHOW_FOLLOWER_COUNT,
                    'Show follower count',
                    'radio',
                    '/^(0|1)$/',
                    'Select either yes or no',
                    true,
                    false,
                    [0],
                    [
                        ['value' => 1, 'label' => 'Yes'],
                        ['value' => 0, 'label' => 'No'],
                    ]
                ),
                new BlockAttributeDefinition(
                    self::BLOCK_ATTRIBUTE_TYPE,
                    'Type',
                    'select',
                    '/^(artist|user)$/',
                    'Valid type is either Artist or User',
                    true,
                    false,
                    [],
                    [
                        'artist' => 'Artist',
                        'user' => 'User',
                    ]
                ),
                new BlockAttributeDefinition(
                    self::BLOCK_ATTRIBUTE_NAME_OR_ID,
                    'Name (of the artist) or Spotify ID',
                    'string',
                    '',
                    'Provide valid name for an artist or user',
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
            self::BLOCK_ATTRIBUTE_SHOW_FOLLOWER_COUNT,
            self::BLOCK_ATTRIBUTE_TYPE,
            self::BLOCK_ATTRIBUTE_NAME_OR_ID
        ];
    }
}