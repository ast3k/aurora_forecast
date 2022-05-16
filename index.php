<?php

function get_color_by_kp($kp_index) {
    if ($kp_index == 4):
        return 'orange';
    elseif ($kp_index > 4):
        return 'red';
    else:
        return '#0ad503';
    endif;
}

function get_moon_svg_by_size($m_size,$id_tag) {
    if ($m_size < 0):
        $a = 0; $b = abs($m_size); $c = abs($m_size)/3.9; $d = 100;
    elseif ($m_size == 100):
        $a = 100; $b = $c = 0; $d = 100;
    elseif ($m_size == 50):
        $a = 50; $b = $d = 0; $c = 100;
    elseif ($m_size == -50):
        $a = $b = 50; $c = 0; $d = 100;
    else:
        $a = $d = 0; $b = $m_size; $c = 100 - ($m_size/3.9);
    endif;

    return '
            <svg class="svg_moon">
                <title>'.abs($m_size).'%</title>
                <linearGradient id="grad'.$id_tag.'" x1="'.$c.'%" x2="'.$d.'%">
                    <stop offset="'.$a.'%" style="stop-color:rgba(204, 204, 204, 1);stop-opacity:1" />
                    <stop offset="'.$b.'%" style="stop-color:rgba(204, 204, 204, 0);stop-opacity:0" />
                </linearGradient>
                <circle cx="50%" cy="50%" r="48%" stroke="#ccc" stroke-width="3%" fill="none" />
                <circle cx="50%" cy="50%" r="42%"  fill="url(#grad'.$id_tag.')" />
            </svg>';
}

$lat_by_kp = [  'Barrow (US), Reykjavik (IS), Inari (FI)',
                'Fairbanks (US), Rovaniemi (FI)',
                'Anchorage (US), Tórshavn (FO), Oulu (FI)',
                'Calgary (CA), Ålesund (NO), Jyväskylä (FI)',
                'Vancouver (CA), Stockholm (SV), Hobart (AU)',
                'Toronto (CA), Edinburgh (GB), Devonport (AU)',
                'New York (US), Hamburg (DE), Christchurch (NZ)',
                'Nashville (US), Brussels (BE), Melbourne (AU)',
                'San Francisco (US), Paris (FR), Sydney (AU)',
                'Monterrey (MX), Oviedo (ES), Ushuaia (AR)' ];

$file_json = file_get_contents("./pub/aurora_forecast.json");
$af = json_decode($file_json, true);

?>
<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="astrek aurora forecast, a fast, light, and responsive northern lights forecast" />
    <meta name="Keywords" content="aurora, aurora forecast, lapland, northern lights, revontulet, inlapland, guide, finland" />
    <meta name="Author" content="info@astrek.net" />
<?php echo '
    <meta property="og:title" content="Aurora Forecast: Now Kp '.$af['next_hours'][0][1].'!" />
    <meta property="og:description" content="On a clear night maybe visible from places like: '.$lat_by_kp[$af['next_hours'][0][1]].'" />';
?>  
    <meta property="og:image" content="https://astrek.net/pub/aurora_forecast_europe.webp" />
    <meta property="og:url" content="https://astrek.net" />
    <meta name="twitter:card" content="summary_large_image" />
  
    <meta property="og:site_name" content="astrek">
    <meta name="twitter:image:alt" content="Aurora Forecast">
    
    <meta name="twitter:site" content="@astreknet" />

    <link rel="icon" type="image/png" sizes="196x196 160x160 96x96 64x64 32x32 16x16" href="favicon.svg" />
    <link rel="apple-touch-icon" sizes="180x180 120x120 76x76 72x72 60x60 57x57" href="favicon.svg" />

<!-- STYLE CSS STARTS -->
<style>
    @media screen and (prefers-color-scheme: light) {
        :root {
            --background-color: #006199;
            --bg-color-transparent: rgba(0, 97, 153, 0.81);
            --color: #ccc;
        }
    }

    @media screen and (prefers-color-scheme: dark) {
        :root {
            --background-color: #002D62;
            --bg-color-transparent: rgba(0, 45, 98, 0.87);
            --color: #ccc;
        }
    }

    :root { color-scheme: light dark;}

    @media (max-width: 999px) {
        :root {
            --width: 100%;
            --next-img-width: 99%;
            --font-size: 270%
        }
    }
    
    @media only screen and (min-width: 999px) and (max-width: 1400px) {
        :root {
            --width: 69%;
            --next-img-width: 99%;
            --font-size: 180%
        }
    }

    @media  (min-width: 1400px) {
        :root {
            --width: 42%;
            --next-img-width: 99%;
            --font-size: 150%;
        }
    }

    body {
        width:var(--width);
        padding: 0;
        background-color: var(--background-color);
        color: var(--color);
        font-size: var(--font-size);
        font-family: verdana;
    }

    header, section {
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    header { 
        margin-top: 1%;
        overflow: auto;
    }

    body, h2, #next, #forecast_img, #marquee ul, table { margin: 0 auto; }
    
    .center_align, footer, h2, #marquee ul {text-align: center;}
    
    .right_align { text-align: right; }
    
    #marquee, #forecast_img, #keys  { border-radius: 0.45em; }
    
    #next_days table, #keys, footer { padding: 0.9em; }

    footer, #def, #lat { font-size: 0.6em; }
    
    #def li, #def table { margin-top: 0.9em; }
    
    .upsidedown { transform: scaleY(-1);}
    
    h2 {
        font-size: 1.2em;
        position: absolute;
        left: 0;
        right: 0;
        top: 0.6em;
    }

    h1, h3, th {
        visibility: hidden;
        display: none;
    }

    a {
        color: #BAD7FF;
        text-decoration: none;
    }

    #keys { border: 0.06em dashed var(--color); }
    
    .svg_color { fill: var(--color); }

    .svg_text { 
        fill: var(--background-color); 
        font-family: 'Arial';
        stroke-width: 0.03em;
        }
    
    #forecast_img {
        width: var(--next-img-width);
        display: block;
    }

    .svg_moon {
        width: 1.5em;
        height: 1.5em;
        vertical-align: middle;
    }       
    
    footer svg {
        width: 3.6em;
        height: 3.6em;
    }

    #marquee {
        width:96%;
        margin: -3.9em auto 0.9em auto;
        position: relative;
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;
    }

    #marquee::-webkit-scrollbar { display: none }

    #marquee ul, #donate {
        list-style-type: none;
        padding-left: 0;
    }
    
    #marquee li {
        background-color: var(--bg-color-transparent);
        cursor: pointer;
        display: inline-block;
        *display: inline;
        *zoom: 1;
        padding: 0.3em;
    }
    
    #next_days table { width: 100%; }

</style>

<title id="title">aurora forecast | astrek</title>
</head>

<body>
<header> 
    <h1>astrek</h1>
    <h2 id="h2">aurora forecast</h2>
    <img id="forecast_img" src="./pub/aurora_forecast_europe.webp" alt="aurora forecast for the next hour">

    <div id="marquee">
        <ul>
<?php 
    echo '  <li><span id="now">now!</span><br/>
            K<sub>p</sub> <span style="color:'.get_color_by_kp($af['next_hours'][0][1]).'">'.$af['next_hours'][0][1].'</span>  '.get_moon_svg_by_size($af['next_hours'][0][2],"hours").'</li>';
        
    for ($i = 1; $i < 17; $i++) {
        echo '  
            <li><span id="'.$af['next_hours'][$i][0].'h">'.gmdate("D, g:i", $af['next_hours'][$i][0]).' UTC</span><br/>
            K<sub>p</sub> <span style="color:'.get_color_by_kp($af['next_hours'][$i][1]).'">'.$af['next_hours'][$i][1].'</span> '.get_moon_svg_by_size($af['next_hours'][$i][2],"h".$af['next_hours'][$i][0]).'</li>';
    }
?>
        </ul>
    </div>
</header>

<section id="next_days">
    <h3 id="h3_0">next days</h3>
    <table id="calendar">
        <tr>
            <th id="next_days_th0">date</th>
            <th id="next_days_th1">kp index</th>
            <th id="next_days_th2" class="right_align">moon</th>
        </tr>
<?php
    for ($i = 0; $i < 15; $i++){
        echo '
        <tr>
            <td id="'.$af['next_days'][$i][0].'d">'.gmdate("M, d", $af['next_days'][$i][0]).'</td> 
            <td>K<sub>p</sub> <span style="color:'.get_color_by_kp($af['next_days'][$i][1]).'">'.$af['next_days'][$i][1].'</span></td>
            <td class="right_align">'.get_moon_svg_by_size($af['next_days'][$i][2],"d".$af['next_days'][$i][0]).'</td>
        </tr>';
    }
?>
    </table>
</section>

<section id="keys">
    <h3 id="h3_1">keys</h3>
    <ul id="def">
        <li id="key_0">The <a href='https://en.wikipedia.org/wiki/Solar_wind'>solar wind</a> excites the atoms on the <a href='https://en.wikipedia.org/wiki/Ionosphere'>ionosphere</a> releasing diferent ligth colors depending on the <a href='https://en.wikipedia.org/wiki/Emission_spectrum'>emission spectrum</a>. Oxygen releases <span style='color:#0ad503'>green</span> and <span style='color:red'>red</span>. Nitrogen glows <a href='https://en.wikipedia.org/wiki/Nitrogen'>blue</a> and <span style='color:purple'>purple</span>. Hydrogen also releases <a href='https://en.wikipedia.org/wiki/Hydrogen'>blue</a>.</li>
        <li id="key_1">The <dfn><a href='https://en.wikipedia.org/wiki/K-index'>K<sub>p</sub> index</a></dfn> is an excellent indicator of disturbances in the <a href='https://en.wikipedia.org/wiki/Earth%27s_magnetic_field'>Earth's magnetic field</a>. The K<sub>p</sub> index data of this site is provided by <a href='https://www.noaa.gov'>NOAA</a>.</li>
        <li id="key_2">An <dfn><a href='https://en.wikipedia.org/wiki/Aurora'>aurora</a></dfn> is the glowing evidence of the particles from a <a href='https://en.wikipedia.org/wiki/Geomagnetic_storm'>geomagnetic storm</a> colliding with the <a href='https://en.wikipedia.org/wiki/Atmosphere_of_Earth'>atmosphere</a>. During a clear night could be possible to witness those phenomena from latitudes like:</li>
    </ul>
    <table id="lat">
<?php
    for ($i=0;$i<10;$i++) {
    echo ' <tr><td>K<sub>p</sub> <span style="color:'.get_color_by_kp($i).'">'.$i.'</span>: </td><td>'.$lat_by_kp[$i].'</td></tr>';
    }
?>
    </table>
</section>

<footer>
    <a href="monero:8AWaVALa8imWWZWsni9LPk2ShXieRu4FLXCFhJtUuXDJ76qGSyMns52Tc2mPxcdeb6JRFGe94wFEPJs1CXjFrmF8V6kHxzZ">
        <svg viewBox="120 120 4200 4200" version="1.1" xmlns="http://www.w3.org/2000/svg">
	        <title>monero</title>
            <path class="svg_color" d="M2250,371.75c-1036.89,0-1879.12,842.06-1877.8,1878,0.26,207.26,33.31,406.63,95.34,593.12h561.88V1263L2250,2483.57,3470.52,1263v1579.9h562c62.12-186.48,95-385.85,95.37-593.12C4129.66,1212.76,3287,372,2250,372Z"/>
            <path class="svg_color" d="M1969.3,2764.17l-532.67-532.7v994.14H1029.38l-384.29.07c329.63,540.8,925.35,902.56,1604.91,902.56S3525.31,3766.4,3855,3225.6H3063.25V2231.47l-532.7,532.7-280.61,280.61-280.62-280.61h0Z"/>
        </svg>
    </a>

    <a href="https://twitter.com/intent/tweet?url=https://astrek.net&hashtags=AuroraForecast,NorthernLights,Lapland">
        <svg id="logo-twitter" data-name="logo-twitter" xmlns="http://www.w3.org/2000/svg" viewBox="60 60 270 270">
            <title>twitter!</title>
            <path class="svg_color" d="M153.62,301.59c94.34,0,145.94-78.16,145.94-145.94,0-2.22,0-4.43-.15-6.63A104.36,104.36,0,0,0,325,122.47a102.38,102.38,0,0,1-29.46,8.07,51.47,51.47,0,0,0,22.55-28.37,102.79,102.79,0,0,1-32.57,12.45,51.34,51.34,0,0,0-87.41,46.78A145.62,145.62,0,0,1,92.4,107.81a51.33,51.33,0,0,0,15.88,68.47A50.91,50.91,0,0,1,85,169.86c0,.21,0,.43,0,.65a51.31,51.31,0,0,0,41.15,50.28,51.21,51.21,0,0,1-23.16.88,51.35,51.35,0,0,0,47.92,35.62,102.92,102.92,0,0,1-63.7,22A104.41,104.41,0,0,1,75,278.55a145.21,145.21,0,0,0,78.62,23"/>
        </svg>
    </a>
    
    <a href="mailto:info@astrek.net">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="12 9 93 93">
        <title>mail</title>
        <path class="svg_color" d="M 60.854168,60.854168 20.042361,27.825652 H 101.66937 Z M 42.380683,54.658586 19.991278,36.53763 v 42.508954 z m 36.946866,0 22.389521,24.387998 V 36.537591 Z M 74.0253,58.946605 60.853827,69.60706 47.682367,58.946605 20.065809,89.033735 h 81.575931 z"/>
        </svg>
    </a>
    
    <a href="http://dh6zihexkhoflepndufa7x7ap7jqbxhqpezkk3e4avo5jdborbhgjvad.onion">
        <svg class="upsidedown" xmlns="http://www.w3.org/2000/svg" viewBox="360 531 1920 1500">
        <title>tor</title>
        <path class="svg_color" d="M1590 2183 c-52 -39 -157 -142 -201 -196 -44 -55 -45 -54 -24 23 18 65 17 60 6 60 -22 0 -119 -248 -136 -347 l-7 -43 -43 30 c-73 50 -85 39 -50 -46 28 -68 32 -134 9 -172 -8 -15 -71 -64 -139 -110 -238 -160 -325 -293 -325 -497 0 -167 67 -304 198 -404 108 -83 236 -121 407 -121 328 0 554 167 597 443 34 223 -75 433 -293 561 -142 84 -189 140 -189 225 0 36 -3 40 -30 46 -16 4 -30 9 -30 12 0 25 215 286 319 387 45 43 80 81 78 83 -3 2 -29 -6 -60 -17 -48 -18 -107 -53 -197 -117 -26 -19 15 42 109 162 24 30 42 57 40 60 -3 2 -20 -8 -39 -22z m-290 -628 c0 -93 13 -135 70 -230 77 -128 92 -190 95 -390 3 -145 2 -155 -4 -69 -10 120 -27 175 -97 314 -52 104 -57 123 -77 295 -2 17 -5 1 -5 -35 -3 -114 13 -180 67 -291 28 -57 57 -133 66 -169 16 -70 19 -197 6 -270 -8 -44 -9 -43 -10 24 -1 90 -24 173 -72 266 -25 49 -39 91 -40 116 0 21 -5 48 -10 59 -6 14 -8 -5 -6 -61 3 -68 8 -89 35 -135 41 -71 62 -156 62 -244 0 -81 -22 -191 -45 -232 -9 -15 -14 -20 -11 -10 3 10 9 59 12 110 6 81 3 106 -21 205 -16 61 -32 112 -36 112 -5 0 -16 -15 -25 -32 -9 -18 -31 -50 -49 -70 -40 -47 -55 -97 -55 -179 0 -66 30 -150 68 -193 16 -18 16 -18 -8 -11 -104 31 -214 172 -228 290 -8 79 57 180 159 246 55 35 93 90 107 157 13 58 1 53 -21 -9 -22 -62 -54 -97 -137 -152 -109 -72 -155 -175 -131 -294 16 -80 49 -139 106 -191 41 -36 44 -42 19 -29 -69 35 -190 221 -219 336 -15 58 -15 67 0 114 35 107 93 171 248 277 38 26 75 60 87 82 20 36 55 176 46 185 -2 2 -16 -32 -31 -76 -33 -99 -48 -119 -137 -177 -87 -56 -172 -135 -203 -189 -13 -22 -31 -65 -40 -97 -14 -51 -14 -62 -1 -122 23 -98 87 -215 160 -295 l31 -33 -45 22 c-68 35 -161 134 -201 215 -33 68 -34 73 -34 190 0 110 2 125 27 178 45 96 122 172 273 272 159 105 190 166 147 291 l-18 51 63 -26 63 -26 0 -70z m5 -930 c-7 -77 -23 -155 -35 -169 -14 -15 -67 71 -85 137 -21 76 -11 125 39 202 18 28 37 62 41 75 15 43 47 -160 40 -245z m132 -27 c-3 -8 -6 -5 -6 6 -1 11 2 17 5 13 3 -3 4 -12 1 -19z"/>
        </svg>
    </a>
    
    <a href="https://github.com/astreknet/aurora_forecast">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-0.3 -0.6 12.9 12.9" preserveAspectRatio="xMidYMid meet">
        <title>github</title>
        <path class="svg_color" d="
        m 5.9526408,0.34839166 c -3.172883,0 -5.746044,2.57280814 -5.746044,5.74674914 0,2.5385891 1.646414,4.6926512 3.929944,5.4528872 0.287514,0.05256 0.392289,-0.124884 0.392289,-0.277284 0,-0.136525 -0.0049,-0.497769 -0.0078,-0.977193 -1.598436,0.347132 -1.935692,-0.7704681 -1.935692,-0.7704681 -0.261408,-0.663928 -0.638175,-0.840669 -0.638175,-0.840669 -0.521758,-0.356306 0.03951,-0.34925 0.03951,-0.34925 0.576792,0.04057 0.880181,0.592314 0.880181,0.592314 0.512586,0.878063 1.345142,0.624416 1.672519,0.477308 0.05221,-0.371122 0.200731,-0.624417 0.364773,-0.767997 -1.275998,-0.145345 -2.617612,-0.6381751 -2.617612,-2.8402141 0,-0.627592 0.224014,-1.140178 0.591609,-1.541992 -0.05927,-0.145344 -0.25647,-0.729544 0.05644,-1.520825 0,0 0.482248,-0.154516 1.580092,0.588786 0.458258,-0.127352 0.95003,-0.190852 1.438627,-0.193322 0.488244,0.0025 0.979664,0.06597 1.438628,0.193322 1.0971394,-0.743302 1.5786804,-0.588786 1.5786804,-0.588786 0.313619,0.791281 0.116417,1.375481 0.0575,1.520825 0.368299,0.401814 0.590549,0.9144 0.590549,1.541992 0,2.207683 -1.34373,2.6934581 -2.6236074,2.8356281 0.206022,0.177447 0.389819,0.528108 0.389819,1.06433 0,0.7679981 -0.0071,1.3878281 -0.0071,1.5762111 0,0.153812 0.103717,0.33267 0.395111,0.276578 2.2817692,-0.761647 3.9267712,-2.9139441 3.9267712,-5.4521812 1e-6,-3.173941 -2.5731578,-5.74674914 -5.7471002,-5.74674914
        " />
        </svg>
    </a>

	<a href="https://www.websitecarbon.com/website/astrek-net/">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="6.6 6 57 57" preserveAspectRatio="xMidYMid meet">
        <title>websitecarbon</title>
        <g id="g1439" transform="translate(-4.0804854,-3.1866026)">
            <ellipse class="svg_color" cx="28.170734" cy="42.819939" rx="15.609625" ry="14.290636" />
            <ellipse class="svg_color" cx="44.764538" cy="41.696072" rx="15.233018" ry="15.545994" />
            <ellipse class="svg_color" cx="44.945271" cy="36.333206" rx="16.613911" ry="14.981083" />
            <ellipse class="svg_color" cx="30.860334" cy="28.963091" rx="9.4334364" ry="8.6228247" />
            <ellipse class="svg_color" cx="57.202381" cy="47.950161" rx="9.8349791" ry="9.520277" />
        </g>
        <text class="svg_text" x="24" y="30"><tspan style="font-size:8.46667px;">0.06g</tspan></text>
        <text class="svg_text" x="15" y="51"><tspan style="font-size:22.5778px;">CO<tspan style="font-size:11.2889px">2</tspan></tspan></text>
        </svg>
    </a>
</footer>

<!-- JAVASCRIPT STARTS -->
<script>
    var lang = navigator.language.slice(0, 2) || navigator.userLanguage.slice(0, 2)

    if (( lang == 'es' ) || ( lang == 'fi' ) || ( lang == 'hu' ) || (lang == 'fr') || (lang == 'it')) {
        var language = new XMLHttpRequest()
        language.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var myObj = JSON.parse(this.responseText)
                    document.getElementById("title").innerHTML = myObj.h2 +' | in Lapland'
                    document.getElementById("h2").innerHTML = myObj.h2
                    document.getElementById("now").innerHTML = myObj.now
                    document.getElementById("h3_0").innerHTML = myObj.h3[0]
                    document.getElementById("h3_1").innerHTML = myObj.h3[1]
                    document.getElementById("next_days_th0").innerHTML = myObj.next_days_th[0]
                    document.getElementById("next_days_th1").innerHTML = myObj.next_days_th[1]
                    document.getElementById("next_days_th2").innerHTML = myObj.next_days_th[2]
                    document.getElementById("key_0").innerHTML = myObj.key[0]
                    document.getElementById("key_1").innerHTML = myObj.key[1]
                    document.getElementById("key_2").innerHTML = myObj.key[2]
                }
        }
        language.open("GET", "./langs/lang."+ lang +".json", true)
        language.send()
    }
    var now = document.getElementById('now');
    var af = <?php echo json_encode($af); ?>;
    for (i = 1; i < 17; i++) {
        d = new Date((af['next_hours'][i][0] *1000)) 
        document.getElementById(af['next_hours'][i][0]+'h').innerHTML = d.toLocaleTimeString(window.navigator.language, {weekday: 'long', hour: '2-digit', minute: '2-digit'}) 
    }
    for (i = 0; i < 7; i++) {
        d = new Date((af['next_days'][i][0] *1000))
        document.getElementById(af['next_days'][i][0]+'d').innerHTML = d.toLocaleString(window.navigator.language, {weekday: 'long'})
    }
    for (i = 7; i < 15; i++) {
        d = new Date((af['next_days'][i][0] *1000))
        document.getElementById(af['next_days'][i][0]+'d').innerHTML = d.toLocaleString(window.navigator.language, {weekday: 'short', day: '2-digit'}) 
    }
</script>

</body>
</html>
