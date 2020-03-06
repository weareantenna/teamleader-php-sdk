<?php

declare(strict_types=1);

namespace Antenna\TeamleaderSDK\Resources;

use Antenna\TeamleaderSDK\Connection;
use Antenna\TeamleaderSDK\Models\CompanyId;
use function time;

class Companies
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function addNote(CompanyId $companyId, string $title) : void
    {
        $this->connection->makeV1Request(
            'addNote.php',
            [
                'object_type' => 'company',
                'object_id' => $companyId,
                'note_title' => $title,
                // 'note_extra_information' => '',
                // 'note_extra_information_type' => 'HTML',
                // 'disable_modification' => 1,
                'date' => time(),
            ]
        );

        // $request = $request->withBody(stream_for(http_build_query([
        //     'api_group' => '154905',
        //     'api_secret' => 'AfQ4NAGLaK3vpix8PRvz3vRE5Afc0r9zTkLw61PQLhaLkQ4nBopHZ8KpI7ritgd3SNo4KW0A0izKc4imFPXe613sL417fmrgOC28Qa3c0sWSmxoEhhJmuHeY5yT891F5qNbKrAfkK7Tt8szlY7rBttskqZiE9uHPOUSwu72EtLR1tzm109UvdBd91naAJACqNU8ECcmR',
        //     'object_type' => 'company',
        //     'object_id' => $companyId,
        //     'note_title' => $title,
        //     // 'note_extra_information' => '',
        //     // 'note_extra_information_type' => 'HTML',
        //     // 'disable_modification' => 1,
        //     'date' => time(),
        // ])));

        // $this->connection->send($request);
    }
}
