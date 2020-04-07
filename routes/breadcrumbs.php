<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('dashboard.index'));
});

// Home > Impostazioni
Breadcrumbs::for('settings', function ($trail) {
    $trail->parent('home');
    $trail->push('Impostazioni account', route('settings.edit'));
});
// Dispositivi
Breadcrumbs::for('devices', function ($trail) {
    $trail->parent('home');
    $trail->push('Dispositivi', route('devices.index'));
});
Breadcrumbs::for('device', function ($trail, $deviceId) {
    $trail->parent('devices');
    $trail->push($deviceId, route('devices.show', ['deviceId' => $deviceId]));
});
Breadcrumbs::for('devices.create', function ($trail) {
    $trail->parent('devices');
    $trail->push('Creazione', route('devices.create'));
});
Breadcrumbs::for('devices.edit', function ($trail, $deviceId) {
    $trail->parent('devices');
    $trail->push('Modifica', route('devices.edit', ['deviceId' => $deviceId]));
});

// Sensori
Breadcrumbs::for('sensors', function ($trail, $deviceId) {
    $trail->parent('device', $deviceId);
    $trail->push('Sensori', route('sensors.index', ['deviceId' => $deviceId]));
});
Breadcrumbs::for('sensor', function ($trail, $deviceId, $sensorId) {
    $trail->parent('sensors', $deviceId);
    $trail->push($sensorId, route('sensors.show', ['deviceId' => $deviceId, 'sensorId' => $sensorId]));
});


// Utenti
Breadcrumbs::for('users.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Gestione Utenti', route('users.index'));
});
Breadcrumbs::for('users.show', function ($trail, $userId) {
    $trail->parent('users.index');
    $trail->push('Utente ' . $userId, route('users.show', ['userId' => $userId]));
});
Breadcrumbs::for('users.create', function ($trail) {
    $trail->parent('users.index');
    $trail->push('Creazione', route('users.create'));
});
Breadcrumbs::for('users.edit', function ($trail, $userId) {
    $trail->parent('users.show', $userId);
    $trail->push('Modifica', route('users.edit', ['userId' => $userId]));
});

// Gateway
Breadcrumbs::for('gateways', function ($trail) {
    $trail->parent('home');
    $trail->push('Gestione gateway', route('gateways.index'));
});
Breadcrumbs::for('gateways.show', function ($trail, $gatewayId) {
    $trail->parent('gateways');
    $trail->push('Gateway ' . $gatewayId, route('gateways.show', ['gatewayId' => $gatewayId]));
});
Breadcrumbs::for('gateways.create', function ($trail) {
    $trail->parent('gateways');
    $trail->push('Creazione', route('gateways.create'));
});
Breadcrumbs::for('gateways.edit', function ($trail, $gatewayId) {
    $trail->parent('gateways');
    $trail->push('Modifica ' . $gatewayId, route('gateways.edit', ['gatewayId' => $gatewayId]));
});

// Enti
Breadcrumbs::for('entities', function ($trail) {
    $trail->parent('home');
    $trail->push('Gestione enti', route('entities.index'));
});

Breadcrumbs::for('entities.show', function ($trail, $entityName) {
    $trail->parent('entities');
    $trail->push($entityName, route('entities.show', ['entityName' => $entityName]));
});

Breadcrumbs::for('entities.create', function ($trail) {
    $trail->parent('entities');
    $trail->push('Creazione', route('entities.create'));
});

Breadcrumbs::for('entities.edit', function ($trail, $entityName) {
    $trail->parent('entities');
    $trail->push('Modifica ' . $entityName, route('entities.edit', ['entityName' => $entityName]));
});

//Views
Breadcrumbs::for('views', function ($trail) {
    $trail->parent('home');
    $trail->push('Pagine view', route('views.index'));
});
Breadcrumbs::for('views.show', function ($trail, $viewId) {
    $trail->parent('views');
    $trail->push('view' . $viewId, route('views.show', ['viewId' => $viewId]));
});
