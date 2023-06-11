<!DOCTYPE html> 
<html lang="en">

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

function get_moon_svg_by_size($m_size, $id_tag) {
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
                <circle cx="50%" cy="50%" r="45%" stroke="#ccc" stroke-width="0.18rem" fill="none" />
                <circle cx="50%" cy="50%" r="45%"  fill="url(#grad'.$id_tag.')" />
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

<head>
    <meta charset = "UTF-8" >
    <meta name="description" content="astrek aurora forecast, a fast, light, and responsive northern lights forecast" >
    <meta name="Keywords" content="aurora, aurora forecast, lapland, northern lights, revontulet, inlapland, guide, finland" >
    <meta name="Author" content="hugo@astrek.net" >
    <meta property="og:title" content="Aurora Forecast: Now Kp <?php echo $af['next_hours'][0][1]; ?>!" >
    <meta property="og:description" content="On a clear night maybe visible from places like: <?php echo $lat_by_kp[$af['next_hours'][0][1]]; ?>" >
    <meta property="og:image" content="https://astrek.net/pub/aurora_forecast_europe.webp" >
    <meta property="og:url" content="https://astrek.net" >
    <meta property="og:site_name" content="astrek" >
    <link rel="icon" href="favicon.ico" >
    <link rel="apple-touch-icon" href="favicon.svg" >

<!-- CSS3 STARTS -->   
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
.center_align, h2, footer, #marquee ul {text-align: center;}
.right_align { text-align: right; }
#marquee, #forecast_img, #keys  { border-radius: 0.45em; }
#next_days table, footer, #keys { padding: 0.9em; }
#def, #lat { font-size: 0.6em; }
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
#forecast_img {
        width: var(--next-img-width);
        display: block;
}

svg {
    width: 2.4rem;
    height: 2.4rem;
    fill: var(--color);
    vertical-align: middle;
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
#marquee ul {
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
            <li>
                <span id="now">now!</span><br>
                K<sub>p</sub> <span style="color: <?php echo get_color_by_kp($af['next_hours'][0][1]); ?>"> <?php echo $af['next_hours'][0][1]; ?></span>  
                <?php echo get_moon_svg_by_size($af['next_hours'][0][2], "hours"); ?>
            </li>
        
<?php 
    for ($i = 1; $i < 17; $i++) {
        echo '  
            <li>
                <span id="'.$af['next_hours'][$i][0].'h">'.gmdate("D, g:i", $af['next_hours'][$i][0]).' UTC</span><br>
                K<sub>p</sub> <span style="color:'.get_color_by_kp($af['next_hours'][$i][1]).'">'.$af['next_hours'][$i][1].'</span>
                '.get_moon_svg_by_size($af['next_hours'][$i][2],"h".$af['next_hours'][$i][0]).'
            </li>';
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
    <a href="mailto:info@astrek.net">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
    </a>

    <a href="https://github.com/astreknet/aurora_forecast">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512"><path d="M165.9 397.4c0 2-2.3 3.6-5.2 3.6-3.3.3-5.6-1.3-5.6-3.6 0-2 2.3-3.6 5.2-3.6 3-.3 5.6 1.3 5.6 3.6zm-31.1-4.5c-.7 2 1.3 4.3 4.3 4.9 2.6 1 5.6 0 6.2-2s-1.3-4.3-4.3-5.2c-2.6-.7-5.5.3-6.2 2.3zm44.2-1.7c-2.9.7-4.9 2.6-4.6 4.9.3 2 2.9 3.3 5.9 2.6 2.9-.7 4.9-2.6 4.6-4.6-.3-1.9-3-3.2-5.9-2.9zM244.8 8C106.1 8 0 113.3 0 252c0 110.9 69.8 205.8 169.5 239.2 12.8 2.3 17.3-5.6 17.3-12.1 0-6.2-.3-40.4-.3-61.4 0 0-70 15-84.7-29.8 0 0-11.4-29.1-27.8-36.6 0 0-22.9-15.7 1.6-15.4 0 0 24.9 2 38.6 25.8 21.9 38.6 58.6 27.5 72.9 20.9 2.3-16 8.8-27.1 16-33.7-55.9-6.2-112.3-14.3-112.3-110.5 0-27.5 7.6-41.3 23.6-58.9-2.6-6.5-11.1-33.3 2.6-67.9 20.9-6.5 69 27 69 27 20-5.6 41.5-8.5 62.8-8.5s42.8 2.9 62.8 8.5c0 0 48.1-33.6 69-27 13.7 34.7 5.2 61.4 2.6 67.9 16 17.7 25.8 31.5 25.8 58.9 0 96.5-58.9 104.2-114.8 110.5 9.2 7.9 17 22.9 17 46.4 0 33.7-.3 75.4-.3 83.6 0 6.5 4.6 14.4 17.3 12.1C428.2 457.8 496 362.9 496 252 496 113.3 383.5 8 244.8 8zM97.2 352.9c-1.3 1-1 3.3.7 5.2 1.6 1.6 3.9 2.3 5.2 1 1.3-1 1-3.3-.7-5.2-1.6-1.6-3.9-2.3-5.2-1zm-10.8-8.1c-.7 1.3.3 2.9 2.3 3.9 1.6 1 3.6.7 4.3-.7.7-1.3-.3-2.9-2.3-3.9-2-.6-3.6-.3-4.3.7zm32.4 35.6c-1.6 1.3-1 4.3 1.3 6.2 2.3 2.3 5.2 2.6 6.5 1 1.3-1.3.7-4.3-1.3-6.2-2.2-2.3-5.2-2.6-6.5-1zm-11.4-14.7c-1.6 1-1.6 3.6 0 5.9 1.6 2.3 4.3 3.3 5.6 2.3 1.6-1.3 1.6-3.9 0-6.2-1.4-2.3-4-3.3-5.6-2z"/></svg>
    </a>

    <a href="https://www.websitecarbon.com/website/astrek-net/">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M57.7 193l9.4 16.4c8.3 14.5 21.9 25.2 38 29.8L163 255.7c17.2 4.9 29 20.6 29 38.5v39.9c0 11 6.2 21 16 25.9s16 14.9 16 25.9v39c0 15.6 14.9 26.9 29.9 22.6c16.1-4.6 28.6-17.5 32.7-33.8l2.8-11.2c4.2-16.9 15.2-31.4 30.3-40l8.1-4.6c15-8.5 24.2-24.5 24.2-41.7v-8.3c0-12.7-5.1-24.9-14.1-33.9l-3.9-3.9c-9-9-21.2-14.1-33.9-14.1H257c-11.1 0-22.1-2.9-31.8-8.4l-34.5-19.7c-4.3-2.5-7.6-6.5-9.2-11.2c-3.2-9.6 1.1-20 10.2-24.5l5.9-3c6.6-3.3 14.3-3.9 21.3-1.5l23.2 7.7c8.2 2.7 17.2-.4 21.9-7.5c4.7-7 4.2-16.3-1.2-22.8l-13.6-16.3c-10-12-9.9-29.5 .3-41.3l15.7-18.3c8.8-10.3 10.2-25 3.5-36.7l-2.4-4.2c-3.5-.2-6.9-.3-10.4-.3C163.1 48 84.4 108.9 57.7 193zM464 256c0-36.8-9.6-71.4-26.4-101.5L412 164.8c-15.7 6.3-23.8 23.8-18.5 39.8l16.9 50.7c3.5 10.4 12 18.3 22.6 20.9l29.1 7.3c1.2-9 1.8-18.2 1.8-27.5zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256z"/></svg>
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
