<?php
namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Identifier extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('identifier', [$this, 'identifier']),
        ];
    }
    
    public function identifier($identifier): string
    {
        $table = str_split($identifier);
        $retour = "";
        $i = 0;
        foreach($table as $value){
            $retour .= $value;
            $i ++;
            if ($i % 4 == 0 && isset($table[$i])){
                $retour .= " - ";
            }
        }
        
        return $retour;
    }
}
