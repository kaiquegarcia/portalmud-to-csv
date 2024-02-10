<?php

namespace Entity;

use Enums\MuralProfileLinkType;
use Utils\Env;
use Utils\Format;
use Utils\Globals;

class MuralProfile implements Entity {
    public function __construct(
        public int $ID,
        public int $status,
        public int $personAuthorID,
        public int $categoryID,
        public int $modalityID,
        public int $typeID,
        public string $doc,
        public int $docType,
        public string $URL,
        public string $thumb,
        public string $name,
        public string $nickname,
        public string $bio,
        public string $email,
        public string $website,
        public string $phone,
        public string $phoneFix,
        public string $whatsapp,
        public int $foundationYear,
        public string $foundationDate,
        public string $createdAt,
        public array $photoURLs,
    ) {}

    public function toCSVArray(): array {
        $mainPhoto = Format::mainPhoto($this->thumb);
        // category & subcategory
        $subcategory = Globals::muralProfileCategoryRepository()->get($this->categoryID);
        $category = null;
        if (!$subcategory || $subcategory->topID <= 0) {
            $category = $subcategory;
            $subcategory = null;
        } else {
            $category = Globals::muralProfileCategoryRepository()->get($subcategory->topID);
        }

        // links
        $links = Globals::muralProfileLinkRepository()->list($this->ID, 100, 0);

        $website = $this->website;
        $facebook = $instagram = $youtube = "";
        if ($links) {
            foreach($links as $link) {
                /* @var MuralProfileLink $link */
                switch($link->type) {
                    case MuralProfileLinkType::Website:
                        $website = $link->fullURL();
                        break;
                    case MuralProfileLinkType::Facebook:
                        $facebook = $link->fullURL();
                        break;
                    case MuralProfileLinkType::Instagram:
                        $instagram = $link->fullURL();
                        break;
                    case MuralProfileLinkType::Youtube:
                        $youtube = $link->fullURL();
                }
            }
        }

        // address
        $address = Globals::muralProfileAddressRepository()->get($this->ID);
        $city = $state = null;
        if ($address) {
            $state = Globals::stateRepository()->get($address->stateID);
            $city = Globals::cityRepository()->get($address->cityID);
        }

        return [
            'ID DO POST' => $this->ID,
            'NOME' => $this->name,
            'CATEGORIA' => $category ? $category->name : '',
            'SUBCATEGORIA' => $subcategory ? $subcategory->name : '',
            'IMAGEM DE CAPA' => $mainPhoto,
            'BIOGRAFIA' => $this->bio,
            'E-MAIL' => $this->email,
            'TELEFONE' => $this->phoneFix,
            'CELULAR' => $this->phone,
            'WEBSITE' => $website,
            'CIDADE' => $city ? $city->name : '',
            'ESTADO' => $state ? $state->UF : '',
            'FACEBOOK' => $facebook,
            'INSTAGRAM' => $instagram,
            'YOUTUBE' => $youtube,
            'PERMALINK' => Env::PERMALINK_BASE_URL_PORTAL() . $this->URL,
        ];
    }
}