<?php

namespace App\Models;

enum EntryButtonColor: string
{
    case primary = 'primary';
    case secondary = 'secondary';
    case success = 'success';
    case info = 'info';
    case warning = 'warning';
    case danger = 'danger';
    case light = 'light';
    case dark = 'dark';
    case link = 'link';
}