<?php

namespace Controllers;

class Versions
{
    private $versions;

    public function __construct($versions)
    {
        $this->versions = $versions;
    }

    public function latests($project)
    {
        $version = $this->versions->getLatestByProject($project);

        return json_encode(
            ['response' =>
                ['project' => $project, 'version' => $version]
            ]
        );

    }
}
