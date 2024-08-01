<?php

namespace Entity;

use Utils\Env;
use Utils\Format;

class Columnist implements Entity {
    private array $partners = [
        'amis@aamis.com.br',
        'cgia@iar.unicamp.br',
        'brumleonel@gmail.com',
        'ppgadc@iar.unicamp.br',
    ];

    public function __construct(
        public int $ID,
        public int $status,
        public string $thumb,
        public string $CPF,
        public string $login,
        public string $encryptedPassword,
        public string $name,
        public string $email,
        public string $phone,
        public string $bioShort,
        public string $bio,
        public string $URL,
        public int $isPartner,
        public ?string $facebookID,
        public ?string $accessToken,
        public ?string $recoveryToken,
        public int $menuState,
        public int $menuTip,
        public string $createdAt,
        public string $updatedAt,
    ) { }

    public function isPartner(): bool {
        return array_search($this->email, $this->partners) !== false;
    }

    public function toCSVArray(): array {
        return [
            'ID DO POST' => $this->ID,
            'TIPO' => $this->isPartner() ? 'PARCEIRO' : 'COLUNISTA',
            'NOME DO COLUNISTA' => $this->name,
            'EMAIL' => $this->email,
            'DESCRIÇÃO' => $this->bioShort,
            'BIOGRAFIA/ CURRICULO' => $this->bio,
            'URL DA IMAGEM' => Format::mainPhoto($this->thumb),
            'PERMALINK' => Env::PERMALINK_BASE_URL_PORTAL() . 'colunistas/' . $this->URL,
        ];
    }
}