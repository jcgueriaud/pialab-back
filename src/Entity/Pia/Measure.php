<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace PiaApi\Entity\Pia;

use Gedmo\Timestampable\Timestampable;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use PiaApi\Entity\Pia\Traits\ResourceTrait;
use PiaApi\Entity\Pia\Traits\HasPiaTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="pia_measure")
 */
class Measure implements Timestampable
{
    use ResourceTrait,
        HasPiaTrait,
        TimestampableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="Pia", inversedBy="measures")
     * @JMS\Exclude()
     * 
     * @var Pia
     */
    protected $pia;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $title;
    /**
     * @ORM\Column(type="text")
     *
     * @var string
     */
    protected $content;
    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $placeholder;
}