<?php

namespace Enums;

enum LabPackType: int
{
    case COMMON = 0;
    case PREMIUM = 1;
    case HIGHLIGHT = 2;
}

function GetLabPackTypeLabel(LabPackType $type): string
{
    switch ($type) {
        case LabPackType::COMMON:
            return "comum";
        case LabPackType::PREMIUM:
            return "premium";
        case LabPackType::HIGHLIGHT:
            return "destaque";
    }

    return "";
}