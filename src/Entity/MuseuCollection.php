<?php

namespace Entity;

use Utils\Env;
use Utils\Format;
use Utils\Globals;

class MuseuCollection implements Entity
{
    public function __construct(
        public int $ID,
        public int $status,
        public int $categoryID,
        public int $countryID,
        public int $cityID,
        public string $postIDs, // content1
        public string $thumb,
        public string $foundationYear, // thumb_legend
        public string $endingYear, // thumb_link
        public string $birthYear, // content2
        public string $deathYear, // content3
        public string $URL,
        public string $title,
        public string $techinicalSpecification, // subtitle
        public string $preview,
        public string $email, // layout
        public string $phone, // artist
        public string $instagram,
        public string $facebook,
        public string $youtube,
        public string $twitter,
        public string $site,
    ) { }

    public function toCSVArray(): array
    {
        $category = Globals::museuCategoryRepository()->get($this->categoryID);
        $country = Globals::museuCountryRepository()->get($this->countryID);
        $city = Globals::museuCityRepository()->get($this->cityID);

        return [
            'ID DO POST' => $this->ID,
            'CATEGORIA' => $category ? $category->name : '',
            'IMAGEM DE CAPA' => Format::mainPhoto($this->thumb, Env::PHOTO_BASE_URL_MUSEU()),
            'PAÍS' => $country ? $country->name : '',
            'CIDADE' => $city ? $city->name : '',
            'ANO DE FUNDAÇÃO' => $this->foundationYear,
            'ANO DE ENCERRAMENTO' => $this->endingYear,
            'ANO DE NASCIMENTO' => $this->birthYear,
            'ANO DE FALECIMENTO' => $this->deathYear,
            'PERMALINK' => Env::PERMALINK_BASE_URL_MUSEU() . $this->URL,
            'TÍTULO' => $this->title,
            'FICHA TÉCNICA' => $this->techinicalSpecification,
            'DESCRIÇÃO' => $this->preview,
            'E-MAIL' => $this->email,
            'TELEFONE' => $this->phone,
            'INSTAGRAM' => $this->instagram,
            'FACEBOOK' => $this->facebook,
            'YOUTUBE' => $this->youtube,
            'TWITTER' => $this->twitter,
            'SITE' => $this->site,
        ];
    }
}