<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container2nrSPXF\srcApp_KernelTestDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container2nrSPXF/srcApp_KernelTestDebugContainer.php') {
    touch(__DIR__.'/Container2nrSPXF.legacy');

    return;
}

if (!\class_exists(srcApp_KernelTestDebugContainer::class, false)) {
    \class_alias(\Container2nrSPXF\srcApp_KernelTestDebugContainer::class, srcApp_KernelTestDebugContainer::class, false);
}

return new \Container2nrSPXF\srcApp_KernelTestDebugContainer([
    'container.build_hash' => '2nrSPXF',
    'container.build_id' => '976fc4fc',
    'container.build_time' => 1565179568,
], __DIR__.\DIRECTORY_SEPARATOR.'Container2nrSPXF');
