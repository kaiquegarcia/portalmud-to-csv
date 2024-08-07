<?php

namespace Entity;

use Utils\Env;
use Utils\Format;
use Utils\Globals;

class PortalPost implements Entity {
    public function __construct(
        public int $ID,
        public int $status,
        public int $categoryID,
        public int $columnistID,
        public string $URL,
        public string $thumb,
        public string $thumbCredit,
        public string $title,
        public string $content,
        public string $preview,
        public string $postDate,
        public array $photoURLs,
    ) {}

    public function toCSVArray(): array {
        $mainPhoto = Format::mainPhoto($this->thumb);
        $category = Globals::portalCategoryRepository()->get($this->categoryID);
        $defaultCategory = 'Portal da Dança';
        $topCategory = $category && $category->topID ? Globals::portalCategoryRepository()->get($category->topID) : null;
        $columnistData = Globals::columnistRepository()->get($this->columnistID);
        $partner =  $columnist = null;
        if ($columnistData?->isPartner()) {
            $partner = $columnistData;
        } else {
            $columnist = $columnistData;
        }

        $tags = [];
        if ($category) {
            $tags[] = $category->name;
        }

        if ($topCategory) {
            $tags[] = $topCategory->name;
        } elseif($category?->topID === 0) {
            $topCategory = $category;
            $category = null;
            $defaultCategory = 'FIQUE LIGADO';
        }

        if ($columnist) {
            $tags[] = $columnist->name;
        }

        return [
            'ID DO POST' => $this->ID,
            'ID COLUNISTA/PARCEIRO' => $this->columnistID,
            'TITULO DO POST' => $this->title,
            'CONTEÚDO' => $this->content,
            'PRÉVIA' => $this->preview,
            'DATA DA PUBLICAÇÃO' => $this->postDate,
            'PERMALINK' => Env::PERMALINK_BASE_URL_PORTAL() . $this->URL,
            'URL DAS IMAGENS DE CONTEÚDO' => $mainPhoto,
            'TÍTULO DA IMAGEM' => $this->title,
            'LEGENDA DA IMAGEM' => '',
            'DESCRIÇÃO DA IMAGEM' => '',
            'IMAGEM DESTAQUE' => $mainPhoto,
            'CATEGORIAS' => $category ? $category->name : $defaultCategory,
            'PILAR' => $topCategory ? $topCategory->name : '',
            'TAGS' => join('|', $tags),
            'STATUS DO POST' => Env::POST_STATUS(),
            'Author ID' => Env::POST_AUTHOR_ID(),
            'Author Username' => Env::POST_AUTHOR_USERNAME(),
            'Author Email' => Env::POST_AUTHOR_EMAIL(),
            'Author First Name' => Env::POST_AUTHOR_FIRST_NAME(),
            'Author Last Name' => Env::POST_AUTHOR_LAST_NAME(),
            'SLUG DO POST' => $this->URL,
            'PALAVRAS CHAVE' => '',
            'URL IMAGENS DA GALERIA' => Format::toWordPressGallery($this->photoURLs),
            'COLUNISTA' => $columnist ? $columnist->name : '',
            'PARCEIRO' => $partner ? $partner->name : '',
            'CRÉDITO DA FOTO' => $this->thumbCredit,
        ];
    }
}