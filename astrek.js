const requestURL = "./pub/aurora_forecast.json";
const request = new Request(requestURL);
const response = await fetch(request);
const af = await response.json();

var lang = navigator.language.slice(0, 2) || navigator.userLanguage.slice(0, 2)
if (( lang == 'es' ) || ( lang == 'fi' ) || ( lang == 'hu' ) || (lang == 'fr') || (lang == 'it')) {
    var language = new XMLHttpRequest()
    language.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myObj = JSON.parse(this.responseText)
            document.getElementById("title").innerHTML = myObj.h2 +' | astrek'
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
for (var i = 1; i < 17; i++) {
    var d = new Date((af['next_hours'][i][0] *1000)) 
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
