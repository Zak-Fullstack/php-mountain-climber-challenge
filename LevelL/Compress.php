<?php

namespace Hackathon\LevelL;

class Compress
{
    private $path;
    private $infos = array(
        'width' => 'ba',
        'height' => 'ba',
        'ratiohw' => 'ba',
        'ratiowh' => 'ba',
        'strongcolor' => 'ba',
        'averagecolor' => 'ba',
    );
    private $trans = array(
        'ba', // 0
        'ce', // 1
        'di', // 2
        'fo', // 3
        'gu', // 4
        'ha', // 5
        'je', // 6
        'ki', // 7
        'lo', // 8
        'mu', // 9
        'ra', // 10
        'se', // 11
        'ti', // 12
        'vo', // 13
        'xu', // 14
        'za', // 15
    );

    public function __construct($path)
    {
        $this->path = $path;
        $this->extractInfos();
    }

    private function extractInfos()
    {
        list($width, $height) = getimagesize($this->path);

        $this->putSizesAndRatiosInfos($width, $height);
        $this->putColorsInfos();
    }

    /**
     * Cette méthodes permet d'extraire et de mettre les informations liés aux couleurs de l'image
     * dans le tableau informations qui permettra de générer une clé unique pour notre image
     * a titre d'exemple nous avons déjà mis en place la valeur moyenne d'une couleur d'un pixel.
     *
     * Il vous reste à marquer la couleur dominante de l'image ->
     *
     * Si l'image a une dominante bleue ==> Il faudra donner la valeur 'ha' - 5
     * Si l'image a une dominante verte ==> Il faudra donner la valeur 'ki' - 7
     * Si l'image a une dominante rouge ==> Il faudra donner la veleur 'ra' - 10
     *
     * Il faut que la couleure soit strictement supérieur aux autres pour la compter comme forte
     *   les pixels gris ne sont pas pris en compte // pareil pour les couleurs mélées (violet, ...)
     * .. dans le tableau $this->infos['strongcolor']
     *
     * Si aucune couleure n'est dominante Alors il faut mettre 'vo' - 13
     */
    private function putColorsInfos()
    {
        $srcImg = ImageCreateFromPng($this->path);
        list($width, $height) = getimagesize($this->path);

        $colors = array('blue' => 0, 'green' => 0, 'red' => 0);
        $averageColor = 0;
        $redSum = 0;
        $greenSum = 0;
        $blueSum = 0;

        for ($i = 0; $i < $width; ++$i) {
            for ($j = 0; $j < $height; ++$j) {
                // Extraction du triplet de couleur, r (rouge), g (vert), b (bleu)
                $rgb = imagecolorat($srcImg, $i, $j);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $averageColor += ($r + $g + $b) / 3;
                $redSum += $r;
                $greenSum += $g;
                $blueSum += $b;

                // @TODO - A COMPLETER -- COULEUR DOMINANTE
                // fin @TODO
            }
        }

        // @TODO - A COMPLETER -- COULEUR DOMINANTE
        // fin @TODO
        if ($blueSum === $greenSum && $blueSum === $redSum)
            $this->infos['strongcolor'] = 'vo';
        else if ($blueSum > $greenSum)
            $this->infos['strongcolor'] = $blueSum > $redSum ? 'ha' : 'ra';
        else
            $this->infos['strongcolor'] = $greenSum > $redSum ? 'ki' : 'ra';


        // On fait la moyenne des moyennes - On divise par 16 car notre tableau va de l'index 0 à 15
        // et que la valeur maximale de la moyenne est 16
        $averageColor = ($averageColor / (($width) * ($height))) / 16 - 1;
        $this->infos['averagecolor'] = ($averageColor > 15) ? $this->trans[15] : $this->trans[intval($averageColor)];
        
    }

    /**
     * Cette méthode va insérer les informations liées à l'image.
     * Elle sert d'exemple.
     *
     * @param $w
     * @param $h
     */
    private function putSizesAndRatiosInfos($w, $h)
    {
        $widthTranslatedInfo = (($w / 240) < 15) ? intval($w / 240) : 15;
        $this->infos['width'] = $this->trans[$widthTranslatedInfo];

        $heighTranslatedInfo = (($h / 240) < 15) ? intval($h / 240) : 15;
        $this->infos['height'] = $this->trans[$heighTranslatedInfo];

        $ratiohwTranslatedInfo = (($h / $w) * 5 < 15) ? intval(($h / $w) * 5) : 15;
        $this->infos['ratiohw'] = $this->trans[$ratiohwTranslatedInfo];

        $ratiowhTranslatedInfo = (($w / $h) * 5 < 15) ? intval(($w / $h) * 5) : 15;
        $this->infos['ratiowh'] = $this->trans[$ratiowhTranslatedInfo];
    }

    /**
     * On colle toutes les syllabes ensemble pour former un mot qui décrira l'image.
     *
     * @return string
     */
    public function getFingerprint()
    {
        return implode('', $this->infos);
    }

    /**
     * Cette méthode permet de comparer deux chaînes et de donner un coût à la difference.
     *
     * @param $opponentFingerprint
     *
     * @return int
     */
    public function compareFingerprint($opponentFingerprint)
    {
        return levenshtein($this->getFingerprint(), $opponentFingerprint);
    }
}
