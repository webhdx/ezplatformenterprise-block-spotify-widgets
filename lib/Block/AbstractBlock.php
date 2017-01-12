<?php
/**
 *  @copyright Copyright (C) eZ Systems AS. All rights reserved.
 *  @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\LandingPageBlockSpotify\Block;

use EzSystems\LandingPageBlockSpotify\MusicServiceApi\MusicServiceApiInterface;
use EzSystems\LandingPageFieldTypeBundle\Exception\InvalidBlockAttributeException;
use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;

/**
 * {@inheritDoc}
 */
abstract class AbstractBlock extends AbstractBlockType
{
    /** @var MusicServiceApiInterface */
    protected $musicServiceApi;

    public function __construct(MusicServiceApiInterface $musicServiceApi)
    {
        $this->musicServiceApi = $musicServiceApi;
    }

    /**
     * {@inheritdoc}
     */
    public function checkAttributesStructure(array $attributes)
    {
        foreach ($this->getRequiredAttributes() as $attributeName) {
            if (!isset($attributes[$attributeName])) {
                throw new InvalidBlockAttributeException(
                    $this->getBlockDefinition()->getName(),
                    $attributeName,
                    'Attribute ' . ucfirst(str_replace('_', ' ', $attributeName)) . ' must be set'
                );
            }
        }
    }

    /**
     * Must return array of string describing required Block Attribute names
     *
     * @return string[]
     */
    protected abstract function getRequiredAttributes();
}