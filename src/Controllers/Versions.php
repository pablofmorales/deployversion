<?php

namespace Controllers;

class Versions
{
    private $versions;

    public function __construct($versions)
    {
        $this->version = $versions;
    }

    public function get($project)
    {
        $version = $this->version->getLatestByProject($project);

        return json_encode(
            ['response' => 
                ['project' => $project, 'version' => $version]
            ]
        );

    }
}
