<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RecommendedAuthors extends Component
{

    public array $authors = [
        ['name' => 'Sarah Drasner', 'username' => '@sarahdrasner', 'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuB_bDNza0_XsizBBXy317LgL0ZlmEMBGHRNKyKJQEHUTZshyhzuRibQZzQeQZzBZYYQiReJ2d-IiJwtoIjp6M6rGrrwY37laL6K4BthiktNmgwhd0qebRtgpHmf8yFhbk-tHrPmUa7BNZsDbuhL6IgYwEAUf_kGkv_NiAdgkdMoXonaLJXpkAtuWiOU1uM4o9ZxZjLoB4P657GWFnuaJ4zwrnfXzPwxL1DmQ-hiP1T0i5Tr4yNY1JUGm0wgGbbwqoDe_zItDbBhPO9s'],
        ['name' => 'David Perell', 'username' => '@davidperell', 'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDEbvciYQ2X_kcFKWWe0O2L03yycemd88WyF_ooBIPwvG-WUezMyveSVstWiBM3XBuBVeVDzlceL-_gL4AgUIr6BEBpg3Euz2S2UzZN3b7J0xsam1LeGO1NhpU_0esyYJLMpFBq04g-yrbxML5Mh9hqxz5h5TIJ9P7mJfg6g-cWjvM7qDXLTdmFZBp2k_85lHK2C98M3j3TVo-8bN-Fxw0iZjBGwnUEnXJTIzcuZiKkPQIYxNt5ft8vlUeIg_jxv3WpCbfdLVr_BibE'],
        ['name' => 'Alice Wong', 'username' => '@alicewong', 'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBn451ZfbDr0Yg1IXraoXumBVLm-GRjvj1ID8YSBo0NiOHTR4h-nTwkze6WtbjRnNOOMDcBV7PVYIEX2ErQLZ5CS0pjQHCWUfvRmnxBdvz8-Vx2EBwEKvXbfHCqrNa1VTMg8U0jzBuUI677uzcLVYBXfX-MGBuqjb8F88PuUlDth4sZu3gUuA2PIYmrVS-QFLFolBrLmvCbiZ1MixmBXlkAL8-XnIM-WJuv7SMkmfwFvY9i6LBBcJEWfjZDfTG8AOPKgzwjZMRCMCdJ'],
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(public string $title = "Recommended Authors", public int $count = 2)
    {
        $this->authors = array_slice($this->authors, 0, $count);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.recommended-authors', ['title' => $this->title]);
    }
}
