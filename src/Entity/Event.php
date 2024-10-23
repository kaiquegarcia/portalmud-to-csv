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
        public int $profileID,
        public int $personID,
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
        public string | null $addressPostalCode,
        public string | null $addressComplement,
        public string | null $addressStreet,
        public string | null $addressNumber,
        public string | null $addressName,
        public int $capacity,
        public string | null $googleMapsIframe,
        public string | null $createdAt,
    ) {
    }

    private function getAgeGroup(): string
    {
        return Format::toAgeGroup($this->ageGroup);
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

    private function getHours(): \Utils\EventHours {
        $hoursCollection = Globals::eventHoursRepository()->getByEventID($this->ID);
        return Format::eventHours($hoursCollection);
    }

    public function toCSVArray(): array {
        $profile = $this->profileID > 0 ? Globals::muralProfileRepository()->get($this->profileID) : null;
        $eventHours = $this->getHours();
        return [
            'ID DO POST' => $this->ID,
            'SLUG' => 'eventos/' . $this->URL,
            'PERMALINK' => Env::PERMALINK_BASE_URL_PORTAL() . 'eventos/' . $this->URL,
            'TITULO DO POST' => $this->title,
            'NOME DO AUTOR' => $this->authorName,
            'NOME DO PERFIL' => $profile?->name ?? '',
            'E-MAIL DO PERFIL' => $profile?->email ?? '',
            'TELEFONE DO PERFIL' => $profile?->phoneFix ?? '',
            'CELULAR DO PERFIL' => $profile?->phone ?? '',
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
            'DATA DE TÉRMINO' => $this->periodInit !== $this->periodEnd ? Format::nullableDate($this->periodEnd) : '',
            'DATA DE CADASTRO' => Format::nullableDate($this->createdAt),
            'DIA DA SEMANA' => join('|', $eventHours->days),
            'HORÁRIO DE INÍCIO' => join('|', $eventHours->startTimes),
            'HORÁRIO DE TÉRMINO' => join('|', $eventHours->endTimes),
            'Nome/Identificação do local' => $this->addressName,
            'ACESSIBILIDADE' => $this->hasAccessibility ? 'sim' : 'não',
            'CAPACIDADE' => $this->capacity > 0 ? intval($this->capacity) . ' pessoas' : '',
            'NOME ENDEREÇO' => $this->addressName,
            'CEP' => $this->addressPostalCode,
            'LOGRADOURO' => $this->addressStreet,
            'NÚMERO' => $this->addressNumber,
            'COMPLEMENTO' => $this->addressComplement,
            'BAIRRO' => $this->districtName,
            'CIDADE' => $this->cityName,
            'ESTADO (UF)' => $this->stateUF,
            'URL IMAGENS DA GALERIA' => Format::toWordPressGallery($this->photoURLs),
            'GOOGLE MAPS IFRAME' => $this->googleMapsIframe,
        ];
    }
}
