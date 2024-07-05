<?php

namespace Entity;

use Enums\LabPackType;
use Utils\Env;
use Utils\Format;
use Utils\Globals;

use function Enums\GetLabPackTypeLabel;

class LabPack implements Entity {
    public function __construct(
        private int $ID,
        private int $teacherID, // teacher_id
        private int $categoryID, // department_id
        private LabPackType $type,
        private string $name,
        private string $resume,
        private string $description,
        private string $video,
        private string $language,
        private string $learning, // larning
        private string $requirements,
        private string $duration,
        private string $thumb,
        private string $banner,
        private string $createdAt, // created_at
    ) {}

    public function toCSVArray(): array {
        $mainPhoto = Format::mainPhoto($this->thumb);
        $bannerPhoto = Format::mainPhoto($this->banner);
        $category = Globals::categoryRepository()->get($this->categoryID);
        $teacher = Globals::labTeacherRepository()->get($this->teacherID);

        return [
            'ID DO POST' => $this->ID,
            'CATEGORIA' => $category ? $category->name : '',
            'SUBCATEGORIA' => GetLabPackTypeLabel($this->type),
            'NOME PROFESSOR' => $teacher ? $teacher->name : '',
            'E-MAIL PROFESSOR' => $teacher ? $teacher->email : '',
            'TÍTULO DO POST' => $this->name,
            'CONTEÚDO' => $this->resume,
            'DESCRIÇÃO' => $this->description,
            'URL DO VÍDEO' => $this->video,
            'IDIOMA' => $this->language,
            'EMENTA' => $this->learning,
            'PRÉ-REQUISITOS' => $this->requirements,
            'DURAÇÃO' => $this->duration,
            'IMAGEM DESTAQUE' => $mainPhoto,
            'URL DAS IMAGENS DE CONTEÚDO' => $bannerPhoto,
            'STATUS DO POST' => Env::POST_STATUS(),
            'Author ID' => Env::POST_AUTHOR_ID(),
            'Author Username' => Env::POST_AUTHOR_USERNAME(),
            'Author Email' => Env::POST_AUTHOR_EMAIL(),
            'Author First Name' => Env::POST_AUTHOR_FIRST_NAME(),
            'Author Last Name' => Env::POST_AUTHOR_LAST_NAME(),
            'DATA DA PUBLICAÇÃO' => $this->createdAt,
        ];
    }
}