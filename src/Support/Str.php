<?php

declare(strict_types=1);

namespace App\Support;

final class Str
{

    public static function slugify(string $text): string
    {
        $translit = [
            'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'zh',
            'з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o',
            'п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'ts',
            'ч'=>'ch','ш'=>'sh','щ'=>'sch','ъ'=>'','ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya',
        ];

        $text = mb_strtolower($text);
        $text = strtr($text, $translit);
        $text = preg_replace('~[^a-z0-9]+~', '-', $text) ?? $text;
        $text = trim($text, '-');

        return $text !== '' ? $text : bin2hex(random_bytes(4));
    }
}