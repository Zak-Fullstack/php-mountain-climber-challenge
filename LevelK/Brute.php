<?php

namespace Hackathon\LevelK;

class Brute
{
    private $hash;
    public $origin;
    private $method; // md5 - crc32 - base64 - sha1

    public function __construct($hash)
    {
        $this->hash = $hash;
    }

    /**
     * @TODO :
     *
     * Cette méthode essaye de trouver par la force à quel mot de 4 lettres correspond ce hash.
     * Sachant que nous ne connaissons pas le hash (enfin si... il suffit de regarder les commentaires de l'attribut privé $methode.
     */
    public function force()
    {
        $a = "qwertyuiopasdfghjklzxcvbnm";
        for ($i=0; $i < 26; $i++) {
            # code...
            for ($j=0; $j < 26; $j++) {
                # code...
                for ($k=0; $k < 26; $k++) {
                    # code...
                    for ($l=0; $l < 26; $l++) {
                        $res = substr($a, $i,1).substr($a, $j,1).substr($a, $k,1).substr($a, $l,1);
                        $h = $this->hash;
                        if (md5($res) == $h || crc32($res) == $h || base64_encode($res) == $h || sha1($res) == $h) {
                            $this->origin = $res;
                            return;
                        }
                    }
                }
            }
        }
    }
}
