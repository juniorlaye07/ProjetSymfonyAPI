<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerYUovxdY\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerYUovxdY/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerYUovxdY.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerYUovxdY\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerYUovxdY\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'YUovxdY',
    'container.build_id' => '085ec216',
    'container.build_time' => 1565352821,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerYUovxdY');
