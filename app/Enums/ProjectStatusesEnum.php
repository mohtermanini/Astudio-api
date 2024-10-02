<?php

namespace App\Enums;

enum ProjectStatusesEnum: int
{
    // These integer values correspond to the project status IDs stored in the database for project statuses.
    case CREATED = 1;
    case IN_PROGRESS = 2;
    case DONE = 3;
}
