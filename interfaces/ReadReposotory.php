<?php

namespace koperdog\yii2sitemanager\interfaces;

/**
 *
 * @author Koperdog <koperdog@github.com>
 */
interface ReadReposotory {
    
    public function getById(int $id): ?array;
    
    public function getAll(): ?array;
}
