<?php

namespace Entity;

use Utils\Env;
use Utils\Format;
use Utils\Globals;

class LabTeacher implements Entity {
    public function __construct(
        public int $ID,
        public int $status,
        public int $categoryID,
        public string $thumb,
        public string $thumb2,
        public string $URL,
        public string $name,
        public string $fullName,
        public string $curriculum,
        public string $email,
        public string $testimonial,
        public string $twitter,
        public string $facebook,
        public string $googlePlus,
        public string $createdAt,
        public string $updatedAt,
    ) {}

    public function toCSVArray(): array {
        $mainPhoto = Format::mainPhoto($this->thumb);
        $category = Globals::categoryRepository()->get($this->categoryID);

        return [
            'ID DO POST' => $this->ID,
            'NOME DO PROFESSOR' => $this->fullName,
            'CATEGORIA' => $category ? $category->name : '',
            'IMAGEM DE CAPA' => $mainPhoto,
            'E-MAIL' => $this->email,
            'CURRICULO' => $this->curriculum,
            'PERMALINK' => Env::PERMALINK_BASE_URL_PORTAL() . $this->URL,
        ];
    }
}