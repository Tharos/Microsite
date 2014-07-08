<?php

namespace Microsite\Site;

use Microsite\LeanMapper\Entity;

/**
 * @property int $id
 * @property Page $page m:hasOne
 *
 * @property string $code
 * @property string|null $html
 * @property int|null $ord
 */
class Content extends Entity
{
}
