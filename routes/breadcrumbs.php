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

Breadcrumbs::for('devices', function ($trail) {
    $trail->parent('home');
    $trail->push('Dispositivi', route('devices.index'));
});
Breadcrumbs::for('sensors', function ($trail) {
    $trail->parent('devices');
    $trail->push('Sensori', route('sensors.index'));
});

Breadcrumbs::for('users', function ($trail) {
    $trail->parent('home');
    $trail->push('Gestione Utenti', route('users.index'));
});
