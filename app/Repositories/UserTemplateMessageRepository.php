<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface UserTemplateMessageRepository.
 *
 * @package namespace App\Repositories;
 */
interface UserTemplateMessageRepository extends RepositoryInterface
{
    public function getTemplatesViaParent(int $parentTemplateId);
}
