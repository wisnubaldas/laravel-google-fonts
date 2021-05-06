<?php

namespace Spatie\GoogleFonts;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class Fonts implements Htmlable
{
    public function __construct(
        private string $googleFontsUrl,
        private ?string $localizedUrl = null,
        private ?string $localizedCss = null
    ) {}

    public function inline(): HtmlString
    {
        if (! $this->localizedUrl) {
            return $this->fallback();
        }

        return new HtmlString(<<<HTML
            <style>{$this->localizedCss}</style>
        HTML);
    }

    public function link(): HtmlString
    {
        if (! $this->localizedUrl) {
            return $this->fallback();
        }

        return new HtmlString(<<<HTML
            <link href="{$this->localizedUrl}" rel="stylesheet" type="text/css">
        HTML);
    }

    public function fallback(): HtmlString
    {
        return new HtmlString(<<<HTML
            <link href="{$this->googleFontsUrl}" rel="stylesheet" type="text/css">
        HTML);
    }

    public function toHtml(): HtmlString
    {
        return $this->inline();
    }
}