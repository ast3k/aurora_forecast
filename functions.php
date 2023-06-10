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
                <circle cx="50%" cy="50%" r="45%" stroke="#ccc" stroke-width="0.18rem" fill="none" />
                <circle cx="50%" cy="50%" r="39%"  fill="url(#grad'.$id_tag.')" />
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
