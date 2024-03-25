<?php

function is_route_active($routeName)
{
    return Str::contains(request()->url(), $routeName);
}
