<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface WxTemplateMessageRepository.
 *
 * @package namespace App\Repositories;
 */
interface WxTemplateMessageRepository extends RepositoryInterface
{
    public function getTemplateMessages();

    public function getPrivateTemplateMessages();

    public function syncMiniProgram();

    public function syncOfficialAccount();

    public function getTemplateMessagesTest();

    public function getMiniProgramTemplateMessages(int $offset, int $count = PAGE_LIMIT);

    public function getOfficialAccountTemplateMessages();
}
