<?php

namespace App\Repositories;

use App\Services\AppManager;
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

    public function syncMiniProgram(AppManager $appManager);

    public function syncOfficialAccount();

    public function getTemplateMessagesTest();

    public function getMiniProgramTemplateMessages($app, int $offset, int $count = PAGE_LIMIT);

    public function getOfficialAccountTemplateMessages();
}
