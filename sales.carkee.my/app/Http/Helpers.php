<?php

function my_asset($path, $secure = null)
{
    return app('url')->asset($path, $secure);
}
