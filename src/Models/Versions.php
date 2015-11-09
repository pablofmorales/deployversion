<?php

namespace Models;

class Versions
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getLatestByProject($project)
    {
        $qb = $this->conn->createQueryBuilder();

        $qb->select('p.version')
            ->from('projects', 'p')
            ->where('p.code = ?')
            ->setParameter(0, $project);
        $version = $qb->execute()->fetchColumn();

        if ($version) {
            return $version;
        }

        throw new \InvalidArgumentException('Project not found');

    }

}
