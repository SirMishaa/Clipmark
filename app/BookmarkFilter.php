<?php

namespace App;

enum BookmarkFilter: string
{
    case Starred = 'starred';
    case Archived = 'archived';
    case Unread = 'unread';
}
