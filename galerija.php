<?php
if(!defined('__APP__')) { die("Hacking attempt"); }

$valuta = isset($_GET['valuta']) ? strtoupper($_GET['valuta']) : 'EUR';
$dozvoljene = ['EUR', 'USD', 'GBP', 'CHF', 'JPY', 'CNY'];
if (!in_array($valuta, $dozvoljene)) { $valuta = 'EUR'; }

$tecaj = 1.0;

if ($valuta !== 'EUR') {
    $env      = parse_ini_file(__DIR__ . '/.env');
    $url      = "https://api.frankfurter.app/latest?from=EUR&to=" . $valuta;
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
    <body>
        <header>
            <div class=slika1></div>
            
        </header>
        <main>
            <h1>Galerija</h1>
            <form method="GET" action="index.php" class="valuta-form">
                <input type="hidden" name="menu" value="2">
                <input type="hidden" name="submenu" value="1">
                
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
                    <li><a href="index.php?menu=2&amp;submenu=1">FDM Printeri</a></li>
                    <li><a href="index.php?menu=2&amp;submenu=2">Printeri na bazi smole</a></li>
                    <li><a href="index.php?menu=2&amp;submenu=3">3D modeli</a></li>
                </ul>
            </nav>  
            
                <section>
                <div class="galerija">
                <figure>
                    <img src="img/sovol_sv06_plus.webp">
                    <figcaption>
                        <h3>Sovol: SV06 Plus</h3>
                        <ul>
                            
                            <li>Brzina ispisa: do 150 mm/s</li>
                            <li>Volumen ispisa: 300*300*340mm</li>
                            <li>Temperatura ispisa: do 300°C</li>
                            <li>Dodatne značajke:</li>
                            <ul>
                        
                                <li>ekstruder s direktnim pogonom i planetarnim prijenosnikom</li>
                                <li>automatsko niveliranje</li>
                                <li>G34 Automatsko Z poravnanje</li>
                            </ul>
                        </ul>
                           <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(300, $tecaj, $valuta) ?></p>
                            

                        
                        
                    </figcaption>
                </figure>
                </div>
                <div class="galerija">
                <figure>
                    <img src="img/neptune_4.webp">
                    <figcaption>
                        <h3>Elegoo: Neptune 4</h3>
                        <ul>
                            
                            <li>Brzina ispisa: do 500 mm/s</li>
                            <li>Volumen ispisa: 225*225*265mm</li>
                            <li>Temperatura ispisa: do 300°C</li>
                            <li>Dodatne značajke:</li>
                            <ul>
                                <li>ekstruder s izravnim pogonom s dva zupčanika</li>
                                <li>snažan sustav hlađenja</li>
                                <li>kompatibilan s klipperom</li>

                            </ul>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(260, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
            </div>
            <div class="galerija">
                <figure>
                    <img src="img/Kobra_2.webp">
                    <figcaption>
                        <h3>Anycubic: Kobra 2</h3>
                        <ul>
                            
                            <li>Brzina ispisa: do 250mm/s </li>
                            <li>Volumen ispisa: 220*220*250mm</li>
                            <li>Temperatura ispisa: do 300°C </li>
                            <li>Dodatne značajke:</li>   
                            <ul>
                                    <li>automatsko niveliranje</li>
                                    <li>automatsko Z poravnanje</li>
                                    <li>Unaprijeđeni sustav ekstruzije i hlađenja, brzo oblikovanje ispisa</li>

                                </ul>
                                </li>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(200, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
                
            </div>
            <div class="galerija">
                <figure>
                    <img src="img/T500.webp">
                    <figcaption>
                        <h3>Comgrow: T500</h3>
                        <ul>
                            
                            <li>Brzina ispisa: do 200mm/s </li>
                            <li>Volumen ispisa: 500*500*500 mm</li>
                            <li>Temperatura ispisa: do 300°C </li>
                            <li>Dodatne značajke:</li>   
                            <ul>
                                    <li>Automatsko niveliranje u 49 točaka</li>
                                    <li>WiFi povezivanje</li>
                                    <li>Sustav koračnog motora visoke preciznosti za glatku ekstruziju</li>

                                </ul>
                                </li>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(1000, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
                
            </div>
            <div class="galerija">
                <figure>
                    <img src="img/M5.webp">
                    <figcaption>
                        <h3>AnkerMake: M5</h3>
                        <ul>
                            
                            <li>Brzina ispisa: do 250mm/s </li>
                            <li>Volumen ispisa: 235*235*250 mm</li>
                            <li>Temperatura ispisa: do 300°C </li>
                            <li>Dodatne značajke:</li>   
                            <ul>
                                    <li>Automatsko niveliranje 7x7</li>
                                    <li>AI-Kamera-System</li>
                                    <li>High-Speed printer smanjuje vrijeme ispisa za 80%   </li>

                                </ul>
                                </li>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(800, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
                
            </div>
            <div class="galerija">
                <figure>
                    <img src="img/Q5.webp">
                    <figcaption>
                        <h3>Flsun: Q5</h3>
                        <ul>
                            
                            <li>Brzina ispisa: do 120mm/s </li>
                            <li>Volumen ispisa: Ø 200*200 mm</li>
                            <li>Temperatura ispisa: do 300°C </li>
                            <li>Dodatne značajke:</li>   
                            <ul>
                                    <li>Automatsko izravnavanje</li>
                                    <li>Jednostavna konstrukcija</li>
                                    <li>32-bitna matična ploča i upravljački program TMC2208</li>

                                </ul>
                                </li>
                        </ul>
                        <p class="cijena"><span id="cijena">Cijena:</span> <?= prikaziCijenu(300, $tecaj, $valuta) ?></p>
                    </figcaption>
                </figure>
                
            </div>
            </section>
   
        </main>
    </body>
</html>