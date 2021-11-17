<?php

namespace Hackathon\LevelN;

class Sec
{
    private $str;
    private $salt;

    public function __construct($str)
    {
        $this->str = $str;
        $this->salt = '';
    }

    /**
     * Cette méthode ne prends rien en paramétre et retourne un sel.
     * A vous de générer le même sel que la fonction generateSalt() sans faire appel à elle.
     *
     * Vous allez y arriver à coup de var_dump ou en de...... le code source de la fonction generateSalt()
     *
     * @return string
     */
    public function hackSaltGenerator()
    {
        // @TODO
        $tmp = base64_decode(
            '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'
        );
        $tmp1 = str_rot13($tmp);
        $tmp2 = gzinflate($tmp1);
        $tmp3 = str_rot13($tmp2);
        eval($tmp3);
        return $res;
    }

    /**
     * Cette méthode permet de chiffrer un mot de passe, en utilisant une méthode précise pour générer le sel.
     *
     * @param string $method
     *
     * @return string
     */
    public function crypt($method)
    {
        $this->salt = $this->$method();

        return md5($this->str.$this->salt);
    }

    /**
     * Cette méthode génére un sel. Malheureusement, elle est illisible.
     * A vous de développer une nouvelle méthode (hackSaltGenerator())
     * qui vous permettra d'obtenir les mêmes résultats.
     *
     * @return mixed
     */
    public function generateSalt()
    {

        eval(
            str_rot13(
                gzinflate(
                    str_rot13(
                        base64_decode(
                            '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'
                        )
                    )
                )
            )
        );
        return $res;
    }
};
