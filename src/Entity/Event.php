<?php

namespace Entity;

use Utils\Env;
use Utils\Format;
use Utils\Globals;

class Event implements Entity
{
    public function __construct(
        public int $ID,
        public int $categoryID,
        public string $thumb,
        public string $URL,
        public string $typeName,
        public string $title,
        public string $content,
        public string | null $periodInit,
        public string | null $periodEnd,
        public array $photoURLs,
        public float $price,
        public float $maxPrice,
        public string $website,
        public int $ageGroup,
        public bool $hasAccessibility,
        public string $phone,
        public string $email,
        public string $authorName,
        public string | null $stateUF,
        public string | null $cityName,
        public string | null $districtName,
        public string | null $addressStreet,
        public string | null $addressNumber,
        public string | null $addressName,
        public int $capacity,
    ) {
    }

    private function getAgeGroup(): string
    {
        return Format::toAgeGroup($this->ageGroup);
    }

    private function getAddress(): string
    {
        $pieces = [];
        
        if ($this->addressStreet) {
            $pieces[] = $this->addressStreet;
        }

        if ($this->addressNumber) {
            $pieces[] = $this->addressNumber;
        }

        if ($this->districtName) {
            $pieces[] = "bairro {$this->districtName}";
        }

        if ($this->cityName && $this->stateUF) {
            $pieces[] = "{$this->cityName}-{$this->stateUF}";
        }

        return join(", ", $pieces);
    }

    private function getPrice(): string
    {
        if (
            $this->price > 0
            && $this->maxPrice > 0
            && $this->price != $this->maxPrice
        ) {
            if ($this->price < $this->maxPrice) {
                return 'De ' . Format::toMoney($this->price) . ' à ' . Format::toMoney($this->maxPrice);
            }

            // prevent form errors
            return 'De ' . Format::toMoney($this->maxPrice) . ' à ' . Format::toMoney($this->price);
        }

        if ($this->price > 0) {
            return Format::toMoney($this->price);
        }

        if ($this->maxPrice > 0) {
            return Format::toMoney($this->maxPrice);
        }

        return 'Entrada gratuita';
    }

    private function getModalityNames(): array {
        $names = [];
        $modalityCollection = Globals::eventModalityRepository()->getByEventID($this->ID);
        if ($modalityCollection) {
            /** @var \Entity\EventModality $modality */
            foreach($modalityCollection as $modality) {
                $names[] = $modality->name;
            }
        }

        if (!empty($names)) {
            return $names;
        }

        $category = Globals::categoryRepository()->get($this->categoryID);
        if ($category) {
            return [$category->name];
        }

        return [];
    }

    private function getHours(): string {
        $hoursCollection = Globals::eventHoursRepository()->getByEventID($this->ID);
        return Format::eventHours($hoursCollection);
    }

    public function toCSVArray(): array {
        return [
            'ID DO POST' => $this->ID,
            'TITULO DO POST' => $this->title,
            'NOME DO AUTOR' => $this->authorName,
            'TIPO DE EVENTO' => $this->typeName,
            'MODALIDADES' => join('|', $this->getModalityNames()),
            'IMAGEM DE CAPA' => Format::mainPhoto($this->thumb),
            'INGRESSO' => $this->getPrice(),
            'CLASSIFICAÇÃO' => $this->getAgeGroup(),
            'WEBSITE' => $this->website,
            'TELEFONE' => $this->phone,
            'EMAIL' => $this->email,
            'CONTEÚDO' => $this->content,
            'DATA DE INÍCIO' => Format::nullableDate($this->periodInit),
            'DATA DE TÉRMINO' => Format::nullableDate($this->periodEnd),
            'HORÁRIOS' => $this->getHours(),
            'Nome/Identificação do local' => $this->addressName,
            'ACESSIBILIDADE' => $this->hasAccessibility ? 'sim' : 'não',
            'CAPACIDADE' => $this->capacity > 0 ? intval($this->capacity) . ' pessoas' : '',
            'ENDEREÇO' => $this->getAddress(),
            'URL IMAGENS DA GALERIA' => Format::toWordPressGallery($this->photoURLs),
            'PERMALINK' => Env::PERMALINK_BASE_URL_PORTAL() . 'eventos/' . $this->URL,
        ];
    }
}
