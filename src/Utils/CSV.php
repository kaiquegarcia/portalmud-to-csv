<?php

namespace Utils;

class CSV {
    private $stream;

    public function __construct(
        private string $filename,
        private bool $extractHeaders = true,
        private bool $append = false,
    ) {
        $this->stream = fopen($this->filename, $append ? 'a' : 'w');
    }

    public function append(array $data) {
        if ($this->extractHeaders) {
            fputcsv($this->stream, array_keys($data));
            $this->extractHeaders = false;
        }

        fputcsv($this->stream, array_values($data));
    }

    public function close() {
        fclose($this->stream);
    }
}