<?php

namespace Enums;

enum MuralProfileLinkType: int
{
    case Website = 0;
    case Facebook = 1;
    case Instagram = 2;
    case Pinterest = 3;
    case Twitter = 4;
    case Youtube = 5;
    case TripAdvisor = 6;
    case FourSquare = 7;
}

function GetMuralProfileLinkTypeBaseURL(MuralProfileLinkType $type): string
{
    switch ($type) {
        case MuralProfileLinkType::Facebook:
            return "https://www.facebook.com/";
        case MuralProfileLinkType::Instagram:
            return "https://www.instagram.com/";
        case MuralProfileLinkType::Pinterest:
            return "https://www.pinterest.com/";
        case MuralProfileLinkType::Twitter:
            return "https://www.twitter.com/";
        case MuralProfileLinkType::Youtube:
            return "https://www.youtube.com/";
        case MuralProfileLinkType::TripAdvisor:
            return "https://www.tripadvisor.com.br/";
        case MuralProfileLinkType::FourSquare:
            return "https://www.foursquare.com/";
    }

    return "http://";
}
