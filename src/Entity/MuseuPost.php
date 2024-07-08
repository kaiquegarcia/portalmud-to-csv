<?php

namespace Entity;

use Utils\Env;
use Utils\Format;
use Utils\Globals;

class MuseuPost implements Entity
{
    public function __construct(
        public int $ID,
        public int $status,
        public int $categoryID,
        public int $periodID,
        public int $cityID,
        public int $countryID,
        public int $danceStyleID,
        public int $colllectionID,
        public int $subcategoryID,
        public int $order,
        public string $thumb,
        public string $thumbLegend,
        public string $link,
        public string $URL,
        public string $title,
        public string $PDF,
        public string $preview,
        public string $content1,
        public string $content2,
        public string $content3,
        public string $artist,
        public string $local,
        public string $ISBN,
        public string $ISSN,
        public string $DOI,
        public string $postedAt,
        public string $searchURI,
        public string $tags,
        public string $visibilityStartDate,
        public string $visibilityEndDate,
        public string $createdAt,
        public string $updatedAt,
        public array $photoURLs,
    ) {
    }

    public function toCSVArray(): array
    {
        $danceStyle = Globals::museuDanceStyleRepository()->get($this->danceStyleID);
        $period = Globals::museuPeriodRepository()->get($this->periodID);
        $country = Globals::museuCountryRepository()->get($this->countryID);
        $city = Globals::museuCityRepository()->get($this->cityID);
        $subcategory = Globals::museuSubcategoryRepository()->get($this->subcategoryID);

        switch ($this->categoryID) {
            case 19:
                return $this->getClippingCSVArray(
                    $danceStyle,
                    $period,
                    $country,
                    $city,
                    $subcategory,
                );
            case 21:
                return $this->getDocumentsCSVArray(
                    $danceStyle,
                    $period,
                    $country,
                    $city,
                    $subcategory,
                );
            case 22:
                return $this->getPhotographiesCSVArray(
                    $danceStyle,
                    $period,
                    $country,
                    $city,
                    $subcategory,
                );
            case 23:
                return $this->getGraphicMaterialsCSVArray(
                    $danceStyle,
                    $period,
                    $country,
                    $city,
                    $subcategory,
                );
            case 24:
                return $this->getVideosCSVArray(
                    $danceStyle,
                    $period,
                    $country,
                    $city,
                    $subcategory,
                );
        }

        return [];
    }

    private function getSanitizedPDF(): string {
        return $this->PDF != '' ? Env::PHOTO_BASE_URL_MUSEU() . $this->PDF : '';
    }

    private function getSanitizedPermalink(): string {
        return Env::PERMALINK_BASE_URL_MUSEU() . $this->URL;
    }

    private function getSanitizedMaterialType(): string {
        if ($this->categoryID == 18) {
            // YES, THIS IS ON THE FRONT-END
            return $this->postedAt;
        }

        // yes, it's stored on 'thumb_link'..............
        switch($this->link) {
            case 'Programa':
            case 'Diário':
                return $this->link . ' de Aula';
        }

        return $this->link;
    }

    private function getClippingCSVArray(
        MuseuDanceStyle | null $danceStyle,
        MuseuPeriod | null $period,
        MuseuCountry | null $country,
        MuseuCity | null $city,
        MuseuSubcategory | null $subcategory,
    ): array
    {
        return [
            "ID DO POST" => $this->ID,
            "TÍTULO" => $this->title,
            "SUBCATEGORIA" => $subcategory ? $subcategory->name : '',
            "ESTILO DE DANÇA" => $danceStyle ? $danceStyle->name : '',
            "ANO" => $period ? $period->name : '',
            "PAÍS" => $country ? $country->name : '',
            "CIDADE" => $city ? $city->name : '',
            "AUTOR" => $this->artist,
            "VEÍCULO" => $this->content1,
            "DESCRIÇÃO" => $this->preview,
            "FICHA TÉCNICA" => '', // não existe para essa categoria
            "EVENTO" => $this->content2,
            "LOCAL" => $this->local,
            "DATA" => $this->postedAt,
            "HASHTAGS" => $this->tags,
            "ACERVO DOADO POR" => $this->content3,
            "IMAGEM DE CAPA" => Format::mainPhoto($this->thumb, Env::PHOTO_BASE_URL_MUSEU()),
            "IMAGENS DE GALERIA" => Format::toWordPressGallery($this->photoURLs, Env::PHOTO_BASE_URL_MUSEU()),
            "LEGENDAS IMAGENS GALERIA" => Format::toWordPressGalleryLegends($this->photoURLs),
            "PDF" => $this->getSanitizedPDF(),
            "LINK" => $this->link,
            "PERMALINK" => $this->getSanitizedPermalink(),
        ];
    }

    private function getDocumentsCSVArray(
        MuseuDanceStyle | null $danceStyle,
        MuseuPeriod | null $period,
        MuseuCountry | null $country,
        MuseuCity | null $city,
        MuseuSubcategory | null $subcategory,
    ): array
    {
        return [
            "ID DO POST" => $this->ID,
            "TÍTULO" => $this->title,
            "SUBCATEGORIA" => $subcategory ? $subcategory->name : '',
            "ESTILO DE DANÇA" => $danceStyle ? $danceStyle->name : '',
            "ANO" => $period ? $period->name : '',
            "PAÍS" => $country ? $country->name : '',
            "CIDADE" => $city ? $city->name : '',
            "ARTISTA" => $this->artist,
            "TIPO DE MATERIAL" => $this->getSanitizedMaterialType(),
            "DESCRIÇÃO" => $this->preview,
            "FICHA TÉCNICA" => $this->content1,
            "EVENTO" => $this->content2,
            "LOCAL" => $this->local,
            "DATA" => $this->postedAt,
            "HASHTAGS" => $this->tags,
            "ACERVO DOADO POR" => $this->content3,
            "IMAGEM DE CAPA" => Format::mainPhoto($this->thumb, Env::PHOTO_BASE_URL_MUSEU()),
            "IMAGENS DE GALERIA" => Format::toWordPressGallery($this->photoURLs, Env::PHOTO_BASE_URL_MUSEU()),
            "LEGENDAS IMAGENS GALERIA" => Format::toWordPressGalleryLegends($this->photoURLs),
            "PDF" => $this->getSanitizedPDF(),
            "PERMALINK" => $this->getSanitizedPermalink(),
        ];
    }

    private function getPhotographiesCSVArray(
        MuseuDanceStyle | null $danceStyle,
        MuseuPeriod | null $period,
        MuseuCountry | null $country,
        MuseuCity | null $city,
        MuseuSubcategory | null $subcategory,
    ): array
    {
        return [
            "ID DO POST" => $this->ID,
            "TÍTULO" => $this->title,
            "SUBCATEGORIA" => $subcategory ? $subcategory->name : '',
            "ESTILO DE DANÇA" => $danceStyle ? $danceStyle->name : '',
            "ANO" => $period ? $period->name : '',
            "PAÍS" => $country ? $country->name : '',
            "CIDADE" => $city ? $city->name : '',
            "ARTISTA" => $this->artist,
            "DESCRIÇÃO" => $this->preview,
            "FICHA TÉCNICA" => $this->content1,
            "EVENTO" => $this->content2,
            "LOCAL" => $this->local,
            "DATA" => $this->postedAt,
            "HASHTAGS" => $this->tags,
            "ACERVO DOADO POR" => $this->content3,
            "IMAGEM DE CAPA" => Format::mainPhoto($this->thumb, Env::PHOTO_BASE_URL_MUSEU()),
            "IMAGENS GALERIA" => Format::toWordPressGallery($this->photoURLs, Env::PHOTO_BASE_URL_MUSEU()),
            "LEGENDAS IMAGENS GALERIA" => Format::toWordPressGalleryLegends($this->photoURLs),
            "PERMALINK" => $this->getSanitizedPermalink(),
        ];
    }

    private function getGraphicMaterialsCSVArray(
        MuseuDanceStyle | null $danceStyle,
        MuseuPeriod | null $period,
        MuseuCountry | null $country,
        MuseuCity | null $city,
        MuseuSubcategory | null $subcategory,
    ): array
    {
        return [
            "ID DO POST" => $this->ID,
            "TÍTULO" => $this->title,
            "SUBCATEGORIA" => $subcategory ? $subcategory->name : '',
            "ESTILO DE DANÇA" => $danceStyle ? $danceStyle->name : '',
            "ANO" => $period ? $period->name : '',
            "PAÍS" => $country ? $country->name : '',
            "CIDADE" => $city ? $city->name : '',
            "ARTISTA" => $this->artist,
            "DESCRIÇÃO" => $this->preview,
            "FICHA TÉCNICA" => $this->content1,
            "EVENTO" => $this->content2,
            "LOCAL" => $this->local,
            "DATA" => $this->postedAt,
            "HASHTAGS" => $this->tags,
            "ACERVO DOADO POR" => $this->content3,
            "IMAGEM DE CAPA" => Format::mainPhoto($this->thumb, Env::PHOTO_BASE_URL_MUSEU()),
            "IMAGENS DE GALERIA" => Format::toWordPressGallery($this->photoURLs, Env::PHOTO_BASE_URL_MUSEU()),
            "LEGENDAS IMAGENS GALERIA" => Format::toWordPressGalleryLegends($this->photoURLs),
            "PDF" => $this->getSanitizedPDF(),
            "PERMALINK" => $this->getSanitizedPermalink(),
        ];
    }

    private function getVideosCSVArray(
        MuseuDanceStyle | null $danceStyle,
        MuseuPeriod | null $period,
        MuseuCountry | null $country,
        MuseuCity | null $city,
        MuseuSubcategory | null $subcategory,
    ): array
    {
        return [
            "ID DO POST" => $this->ID,
            "TÍTULO" => $this->title,
            "SUBCATEGORIA" => $subcategory ? $subcategory->name : '',
            "ESTILO DE DANÇA" => $danceStyle ? $danceStyle->name : '',
            "ANO" => $period ? $period->name : '',
            "PAÍS" => $country ? $country->name : '',
            "CIDADE" => $city ? $city->name : '',
            "ARTISTA" => $this->artist,
            "DESCRIÇÃO" => $this->preview,
            "FICHA TÉCNICA" => $this->content1,
            "EVENTO" => $this->content2,
            "LOCAL" => $this->local,
            "DATA" => $this->postedAt,
            "HASHTAGS" => $this->tags,
            "ACERVO DOADO POR" => $this->content3,
            "IMAGEM DE CAPA" => Format::mainPhoto($this->thumb, Env::PHOTO_BASE_URL_MUSEU()),
            "LINK DO VÍDEO" => $this->link,
            "PERMALINK" => $this->getSanitizedPermalink(),
        ];
    }
}
