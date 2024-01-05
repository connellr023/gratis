<?php

namespace Gratis\Framework\HTTP;

enum ResponseCodes: int
{
    case OK = 200;
    case NOT_FOUND = 404;
    case BAD_REQUEST = 400;
}