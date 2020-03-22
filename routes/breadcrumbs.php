<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('dashboard.index'));
});

// Home > Impostazioni
Breadcrumbs::for('settings', function ($trail) {
    $trail->parent('home');
    $trail->push('Impostazioni account', route('profile.index'));
});
