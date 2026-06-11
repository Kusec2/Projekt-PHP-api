<?php
if(!defined('__APP__')) { die("Hacking attempt"); }

$valuta = isset($_GET['valuta']) ? strtoupper($_GET['valuta']) : 'EUR';
$dozvoljene = ['EUR', 'USD', 'GBP', 'CHF', 'JPY', 'CNY'];
if (!in_array($valuta, $dozvoljene)) { $valuta = 'EUR'; }

$tecaj = 1.0;

if ($valuta !== 'EUR') {
    $env      = parse_ini_file(__DIR__ . '/.env');
    $url      = $env['API_CURRENCY'] . $valuta;
    $response = file_get_contents($url);
    $data     = json_decode($response, true);

    if (isset($data['rates'][$valuta])) {
        $tecaj = $data['rates'][$valuta];
    }
}

function prikaziCijenu($cijena_eur, $tecaj, $valuta) {
    $konvertirana = round($cijena_eur * $tecaj, 2);
    $simbol = [
    'EUR' => '€', 'USD' => '$', 'GBP' => '£',
    'CHF' => 'CHF', 'JPY' => '¥', 'CNY' => '¥'
    ];
    return number_format($konvertirana, 2, ',', '.') . ' ' . $simbol[$valuta];
}
?>

<!DOCTYPE HTML>
<html>
    <head>

    </head>
    <body>
        <header>
            <h1>Galerija</h1> 
                <form method="GET" action="index.php" class="valuta-form">
                    <input type="hidden" name="menu" value="2">
                    <input type="hidden" name="submenu" value="2">
                    
                    <label for="valuta" class="valuta-label">Prikaži cijene u:</label>
                    
                    <select name="valuta" id="valuta" class="valuta-select" onchange="this.form.submit()">
                        <option value="EUR" <?= $valuta=='EUR' ? 'selected' : '' ?>>EUR €</option>
                        <option value="USD" <?= $valuta=='USD' ? 'selected' : '' ?>>USD $</option>
                        <option value="GBP" <?= $valuta=='GBP' ? 'selected' : '' ?>>GBP £</option>
                        <option value="CHF" <?= $valuta=='CHF' ? 'selected' : '' ?>>CHF</option>
                        <option value="JPY" <?= $valuta=='JPY' ? 'selected' : '' ?>>JPY ¥</option>
                        <option value="CNY" <?= $valuta=='CNY' ? 'selected' : '' ?>>CNY ¥</option>
                    </select>
                </form>
            
            <nav class="podstranice">
                <ul>
                    <li><a href="index.php?menu=2&submenu=1">FDM Printeri</a></li>
                    <li><a href="index.php?menu=2&submenu=2">Printeri na bazi smole</a></li>
                    <li><a href="index.php?menu=2&submenu=3">3D modeli</a></li>
                </ul>
            </nav>
        </header>
        <main>
            
                <section>
                <div class="galerija">
                <figure>
                    <img src="img/Mars 4 Max 6K.webp">
                    <figcaption>
                        <h3>Elegoo: Mars 4 Max 6K</h3>
                        <ul>
                            
                            <li>Rezolucija ispisa: 5760 x 3600 piksela</li>
                            <li>Volumen ispisa: 195,84*122,4*150 mm</li>
                            <li>Izvor svjetlosti: UV LCD</li>
                            <li>Dodatne značajke:</li>
                            <ul>
                        
                                <li>Zaštitno staklo od kaljenog stakla</li>
                                <li>Pjeskarena ispisna ploča</li>
                                <li>Sustav hlađenja s dva ventilatora za učinkovito odvođenje topline i hlađenje</li>
                            </ul>
                        </ul>
                           <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(250, $tecaj, $valuta) ?></p>
                            

                        
                        
                    </figcaption>
                </figure>
                </div>
                <div class="galerija">
                <figure>
                    <img src="img/Saturn 3 Ultra 12K.webp">
                    <figcaption>
                        <h3>Elegoo: Saturn 3 Ultra 12K</h3>
                        <ul>
                            
                            <li>Rezolucija ispisa:11520 x 5120 piksela</li>
                            <li>Volumen ispisa: 218.88*122.88*260 mm</li>
                            <li>Izvor svjetlost: UV LCD</li>
                            <li>Dodatne značajke:</li>
                            <ul>
                                <li>Refraktivni COB izvor svjetlosti</li>
                                <li>Niveliranje u 4 točke</li>
                                <li>USB pročišćivač zraka s filtrom od aktivnog ugljena</li>

                            </ul>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(520, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
            </div>
            <div class="galerija">
                <figure>
                    <img src="img/Photon M3 Max.webp">
                    <figcaption>
                        <h3>Anycubic: Photon M3 Max</h3>
                        <ul>
                            
                            <li>Rezolucija ispisa: 6480 x 3600 piksela </li>
                            <li>Volumen ispisa:298*164*300 mm</li>
                            <li>Izvor svjetlosti: UV LCD </li>
                            <li>Dodatne značajke:</li>   
                            <ul>
                                    <li>Smart Resin Filling funkcija</li>
                                    <li>Velike brzine ispisa</li>
                                    <li>Najbrža brzina printanja može doseći 60 mm/h</li>

                                </ul>
                                </li>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(900, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
            </div>
            <div class="galerija">
                <figure>
                    <img src="img/Halot Mage Pro.webp">
                    <figcaption>
                        <h3>Creality: Halot Mage Pro</h3>
                        <ul>
                            
                            <li>Rezolucija ispisa: 7680 x 4320 piksela </li>
                            <li>Volumen ispisa: 228*128*230 mm</li>
                            <li>Izvor svjetlosti: UV LCD </li>
                            <li>Dodatne značajke:</li>   
                            <ul>
                                    <li>Pametno povezivanje</li>
                                    <li>Automatska pumpa smole za sustav isporuke bez muke</li>
                                    <li>Zaštita LCD zaslona od kaljenog stakla protiv ogrebotina i curenja smole</li>

                                </ul>
                                </li>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(550, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
            </div>
            <div class="galerija">
                <figure>
                    <img src="img/Sonic Mega 8K S.webp">
                    
                    <figcaption>
                        <h3>Phrozen: Sonic Mega 8K S</h3>
                        <ul>
                            
                            <li>Rezolucija ispisa: 43 µm </li>
                            <li>Volumen ispisa: 330*185*300 mm</li>
                            <li>Izvor svjetlosti: UV LCD </li>
                            <li>Dodatne značajke:</li>   
                            <ul>
                                    <li>Resin Drip Hanger</li>
                                    <li>Pump & Fill – automatski Resin Feeder (Add-On) </li>
                                    <li> Brzi ispis, veća produktivnost</li>

                                </ul>
                                </li>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(1500, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
            </div>
            <div class="galerija">
                <figure>
                    <img src="img/Photon Mono X 6Ks.webp">
                    
                    <figcaption>
                        <h3>Photon: Mono X 6Ks</h3>
                        <ul>
                            
                            <li>Rezolucija ispisa: 5760 x 3600 piksela </li>
                            <li>Volumen ispisa: 195,84*122,4*200 mm</li>
                            <li>Izvor svjetlosti: UV LCD </li>
                            <li>Dodatne značajke:</li>   
                            <ul>
                                    <li>Poboljšani sustav osvjetljenja</li>
                                    <li>Brzina ispisa 15-60mm/h </li>
                                    <li>Laserski gravirana konstrukcijska platforma</li>

                                </ul>
                                </li>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(420, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
            </div>
            </section>
            
            
            
        </main>
    </body>
</html>