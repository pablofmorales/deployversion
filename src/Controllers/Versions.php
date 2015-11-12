<?php

namespace Controllers;

use Modals;

class Versions
{
    private $versions;

    public function __construct($versions)
    {
        $this->versions = $versions;
    }

    public function latest($project)
    {
        $version = $this->versions->getLatestByProject($project);

        return json_encode(
            ['response' =>
                ['project' => $project, 'version' => $version]
            ]
        );

    }
}
