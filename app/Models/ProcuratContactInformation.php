<?php

namespace App\Models;

class ProcuratContactInformation
{
    private int $id;
    private string $type;
    private string $medium;
    private string $content;

    /**
     * @param int $id
     * @param string $type
     * @param string $medium
     * @param string $content
     */
    public function __construct(int $id, string $type, string $medium, string $content)
    {
        $this->id = $id;
        $this->type = $type;
        $this->medium = $medium;
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getMedium(): string
    {
        return $this->medium;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}