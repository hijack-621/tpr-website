$(document).ready(function(){
    $('.mapbig').append('<div id="world-clock-map"><a href=\'/russia/moscow\' target=\'_blank\'><div id="mosocow" class="time-frame"></div></a><a href=\'/india/new-delhi\' target=\'_blank\'><div id="delhi" class="time-frame" ></div></a><a href=\'/uk/london\' target=\'_blank\'><div id="london" class="time-frame" ></div></a><a href=\'/china/beijing\' target=\'_blank\'><div id="beijing" class="time-frame" ></div></a><a href=\'/chile/santiago\' target=\'_blank\'><div id="Santiago" class="time-frame" ></div></a><a href=\'/japan/tokyo\' target=\'_blank\'><div id="Tokyo" class="time-frame" ></div></a><a href=\'/south-africa/cape-town\' target=\'_blank\'><div id="Capetown" class="time-frame" ></div></a><a href=\'/australia/canberra\' target=\'_blank\'><div id="Canberra" class="time-frame" ></div></a><a href=\'/new-zealand/wellington\' target=\'_blank\'><div id="Wellington" class="time-frame" ></div></a><a href=\'/usa/new-york\' target=\'_blank\'><div id="Newyork" class="time-frame" ></div></a><a href=\'/usa/washington-dc\' target=\'_blank\'><div id="Washington" class="time-frame" ></div></a></div>');

    $('.capital-time').append('<div id="Kabul" class="time-frame"></div><div id="Buenos" class="time-frame"></div><div id="Vienna" class="time-frame"></div><div id="Brussels" class="time-frame"></div><div id="Sofia" class="time-frame"></div><div id="Sanjose" class="time-frame"></div><div id="Havana" class="time-frame"></div><div id="Nicosia" class="time-frame"></div><div id="Zagreb" class="time-frame"></div><div id="Copenhagen" class="time-frame"></div><div id="Cairo" class="time-frame"></div><div id="Helsinki" class="time-frame"></div><div id="Suva" class="time-frame"></div><div id="Athens" class="time-frame"></div><div id="Berlin" class="time-frame"></div><div id="Tegucigalpa" class="time-frame"></div><div id="hongkong" class="time-frame"></div><div id="Budapest" class="time-frame"></div><div id="Rome" class="time-frame"></div><div id="Jerusalem" class="time-frame"></div><div id="Dublin" class="time-frame"></div><div id="Baghdad" class="time-frame"></div><div id="Kingston" class="time-frame"></div><div id="Amman" class="time-frame"></div><div id="Nairobi" class="time-frame"></div><div id="Riga" class="time-frame"></div><div id="Tripoli" class="time-frame"></div><div id="kualalumpur" class="time-frame"></div><div id="MexicoCity" class="time-frame"></div><div id="Amsterdam" class="time-frame"></div><div id="Norway" class="time-frame"></div><div id="Nigeria" class="time-frame"></div><div id="Muscat" class="time-frame"></div><div id="Lima" class="time-frame"></div><div id="Manila" class="time-frame"></div><div id="Warsaw" class="time-frame"></div><div id="Lisbon" class="time-frame"></div><div id="Doha" class="time-frame"></div><div id="Singapore" class="time-frame"></div><div id="Seoul" class="time-frame"></div><div id="madrid" class="time-frame"></div><div id="Khartoum" class="time-frame"></div><div id="Stockholm" class="time-frame"></div><div id="Bern" class="time-frame"></div><div id="Damascus" class="time-frame"></div><div id="Bangkok" class="time-frame"></div><div id="Ankara" class="time-frame"></div><div id="Kampala" class="time-frame"></div><div id="Kiev" class="time-frame"></div><div id="Montevideo" class="time-frame"></div><div id="Hanoi" class="time-frame"></div><div id="Harare" class="time-frame"></div>');

});
// function to calculate local time
// in a different city
// given the city's UTC offset

function calcTime(date,city,offset) {

    // create Date object for current location
    d = new Date();
    // convert to msec
    // add local time zone offset
    // get UTC time in msec
    utc = d.getTime() + (d.getTimezoneOffset() * 60000);

    // create new Date object for different city
    // using supplied offset
    nd = new Date(utc + (3600000 * offset));

    // return time as a string
    return "<div class='cty-name'>" + city + " </div>" + nd.toLocaleString();
}
setInterval(function(){
    delhi=calcTime("12-25-2014 14:07 PM", '鏂板痉閲�', '+5.5');$('#delhi').html(delhi);
    mosocow=calcTime("12-25-2014 14:07 PM",'鑾柉绉�', '+3');$('#mosocow').html(mosocow);
    london=calcTime("12-25-2014 14:07 PM",'浼︽暒', '0');$('#london').html(london);
    beijing=calcTime("12-25-2014 14:07 PM",'鍖椾含', '+8');$('#beijing').html(beijing);
    Abuja=calcTime("12-25-2014 14:07 PM",'闃垮竷璐�', '+1');$('#Abuja').html(Abuja);
    Brasilia=calcTime("12-25-2014 14:07 PM",'宸磋タ鍒╀簹', '-2');$('#Brasilia').html(Brasilia);
    Santiago=calcTime("12-25-2014 14:07 PM",'鍦ｅ湴浜氬摜', '-3');$('#Santiago').html(Santiago);
    Ottawa=calcTime("12-25-2014 14:07 PM",'娓ュお鍗�', '-4');$('#Ottawa').html(Ottawa);
    Paris=calcTime("12-25-2014 14:07 PM",'宸撮粠', '+1');$('#Paris').html(Paris);
    Anchorage=calcTime("12-25-2014 14:07 PM",'瀹夊厠闆峰', '-8');$('#Anchorage').html(Anchorage);
    Tokyo=calcTime("12-25-2014 14:07 PM",'涓滀含', '+9');$('#Tokyo').html(Tokyo);
    Capetown=calcTime("12-25-2014 14:07 PM",'寮€鏅暒', '+2');$('#Capetown').html(Capetown);
    Chicago=calcTime("12-25-2014 14:07 PM",'鑺濆姞鍝�', '-5');$('#Chicago').html(Chicago);
    Perth =calcTime("12-25-2014 14:07 PM",'鐝€鏂� ', '+8');$('#Perth ').html(Perth );
    Canberra  =calcTime("12-25-2014 14:07 PM",'鍫煿鎷�', '+11');$('#Canberra').html(Canberra);
    Darwin   =calcTime("12-25-2014 14:07 PM",'杈惧皵鏂� ', '+9.30');$('#Darwin').html(Darwin);
    Jakarta   =calcTime("12-25-2014 14:07 PM",'闆呭姞杈� ', '+7');$('#Jakarta').html(Jakarta);
    Vladivostok =calcTime("12-25-2014 14:07 PM",'绗︽媺杩矁鏂墭鍏�', '+10');$('#Vladivostok').html(Vladivostok);
    Abudhabi =calcTime("12-25-2014 14:07 PM",'闃垮竷鎵庢瘮', '+4');$('#Abudhabi').html(Abudhabi);
    Kaliningrad =calcTime("12-25-2014 14:07 PM",'鍔犻噷瀹佹牸鍕�', '+2');$('#Kaliningrad').html(Kaliningrad);
    Wellington =calcTime("12-25-2014 14:07 PM",'鎯犵伒椤�', '+13');$('#Wellington').html(Wellington);
    Newyork =calcTime("12-25-2014 14:07 PM",'绾界害', '-4');$('#Newyork').html(Newyork);
    Losangeles =calcTime("12-25-2014 14:07 PM",'娲涙潐鐭�', '-8');$('#Losangeles').html(Losangeles);
    Washington =calcTime("12-25-2014 14:07 PM",'鍗庣洓椤� ', '-4');$('#Washington').html(Washington);
    denver =calcTime("12-25-2014 14:07 PM",'涓逛經', '-7');$('#denver').html(denver);

    Kabul =calcTime("12-25-2014 14:07 PM",'Kabul', '+4.3');$('#Kabul').html(Kabul);
    Buenos =calcTime("12-25-2014 14:07 PM",'Buenos', '-3');$('#Buenos').html(Buenos);
    Vienna =calcTime("12-25-2014 14:07 PM",'Vienna', '+1');$('#Vienna').html(Vienna);
    Brussels =calcTime("12-25-2014 14:07 PM",'Brussels', '+1');$('#Brussels').html(Brussels);
    Sofia =calcTime("12-25-2014 14:07 PM",'Sofia', '+2');$('#Sofia').html(Sofia);
    Havana =calcTime("12-25-2014 14:07 PM",'Havana', '-5');$('#Havana').html(Havana);
    Nicosia =calcTime("12-25-2014 14:07 PM",'Nicosia', '+2');$('#Nicosia').html(Nicosia);
    Zagreb =calcTime("12-25-2014 14:07 PM",'Zagreb', '+1');$('#Zagreb').html(Zagreb);
    Copenhagen =calcTime("12-25-2014 14:07 PM",'Copenhagen', '+1');$('#Copenhagen').html(Copenhagen);
    Cairo =calcTime("12-25-2014 14:07 PM",'Cairo', '+2');$('#Cairo').html(Cairo);
    Helsinki =calcTime("12-25-2014 14:07 PM",'Helsinki', '+2');$('#Helsinki').html(Helsinki);
    Suva =calcTime("12-25-2014 14:07 PM",'Suva', '+13');$('#Suva').html(Suva);
    Athens =calcTime("12-25-2014 14:07 PM",'Athens', '+2');$('#Athens').html(Athens);
    Berlin =calcTime("12-25-2014 14:07 PM",'Berlin', '+1');$('#Berlin').html(Berlin);
    Tegucigalpa =calcTime("12-25-2014 14:07 PM",'Tegucigalpa', '-6');$('#Tegucigalpa').html(Tegucigalpa);
    Budapest =calcTime("12-25-2014 14:07 PM",'Budapest', '+1');$('#Budapest').html(Budapest);
    Rome =calcTime("12-25-2014 14:07 PM",'Rome', '+1');$('#Rome').html(Rome);
    Jerusalem =calcTime("12-25-2014 14:07 PM",'Jerusalem', '+2');$('#Jerusalem').html(Jerusalem);
    Dublin =calcTime("12-25-2014 14:07 PM",'Dublin', '+0');$('#Dublin').html(Dublin);
    Baghdad =calcTime("12-25-2014 14:07 PM",'Baghdad', '+3');$('#Baghdad').html(Baghdad);
    Kingston =calcTime("12-25-2014 14:07 PM",'Kingston', '-5');$('#Kingston').html(Kingston);
    Amman =calcTime("12-25-2014 14:07 PM",'Amman', '+2');$('#Amman').html(Amman);
    Nairobi =calcTime("12-25-2014 14:07 PM",'Nairobi', '+3');$('#Nairobi').html(Nairobi);
    Riga =calcTime("12-25-2014 14:07 PM",'Riga', '+2');$('#Riga').html(Riga);
    Tripoli =calcTime("12-25-2014 14:07 PM",'Tripoli', '+2');$('#Tripoli').html(Tripoli);
    Amsterdam =calcTime("12-25-2014 14:07 PM",'Amsterdam', '+1');$('#Amsterdam').html(Amsterdam);
    Norway =calcTime("12-25-2014 14:07 PM",'Norway', '+1');$('#Norway').html(Norway);
    Oslo =calcTime("12-25-2014 14:07 PM",'Oslo', '+1');$('#Oslo').html(Oslo);
    Muscat =calcTime("12-25-2014 14:07 PM",'Muscat', '+4');$('#Muscat').html(Muscat);
    Lima =calcTime("12-25-2014 14:07 PM",'Lima', '-5');$('#Lima').html(Lima);
    Manila =calcTime("12-25-2014 14:07 PM",'Manila', '+8');$('#Manila').html(Manila);
    Warsaw =calcTime("12-25-2014 14:07 PM",'Warsaw', '+1');$('#Warsaw').html(Warsaw);
    Lisbon =calcTime("12-25-2014 14:07 PM",'Lisbon', '+0');$('#Lisbon').html(Lisbon);
    Doha =calcTime("12-25-2014 14:07 PM",'Doha', '+3');$('#Doha').html(Doha);
    Singapore =calcTime("12-25-2014 14:07 PM",'Singapore', '+8');$('#Singapore').html(Singapore);
    Seoul =calcTime("12-25-2014 14:07 PM",'Seoul', '+9');$('#Seoul').html(Seoul);
    madrid =calcTime("12-25-2014 14:07 PM",'madrid', '+1');$('#madrid').html(madrid);
    Khartoum =calcTime("12-25-2014 14:07 PM",'Khartoum', '+3');$('#Khartoum').html(Khartoum);
    Stockholm =calcTime("12-25-2014 14:07 PM",'Stockholm', '+1');$('#Stockholm').html(Stockholm);
    Bern =calcTime("12-25-2014 14:07 PM",'Bern', '+1');$('#Bern').html(Bern);
    Damascus =calcTime("12-25-2014 14:07 PM",'Damascus', '+2');$('#Damascus').html(Damascus);
    Bangkok =calcTime("12-25-2014 14:07 PM",'Bangkok', '+7');$('#Bangkok').html(Bangkok);
    Ankara =calcTime("12-25-2014 14:07 PM",'Ankara', '+2');$('#Ankara').html(Ankara);
    Kampala =calcTime("12-25-2014 14:07 PM",'Kampala', '+3');$('#Kampala').html(Kampala);
    Kiev =calcTime("12-25-2014 14:07 PM",'Kiev', '+2');$('#Kiev').html(Kiev);
    Montevideo =calcTime("12-25-2014 14:07 PM",'Montevideo', '-2');$('#Montevideo').html(Montevideo);
    Hanoi =calcTime("12-25-2014 14:07 PM",'Hanoi', '+7');$('#Hanoi').html(Hanoi);
    Harare =calcTime("12-25-2014 14:07 PM",'Harare', '+2');$('#Harare').html(Harare);
    Sanjose =calcTime("12-25-2014 14:07 PM",'Sanjose', '-8');$('#Sanjose').html(Sanjose);
    hongkong  =calcTime("12-25-2014 14:07 PM",'hong-kong ', '+8');$('#hongkong ').html(hongkong );
    kualalumpur =calcTime("12-25-2014 14:07 PM",'kualalumpur', '+8');$('#kualalumpur').html(kualalumpur);
    MexicoCity =calcTime("12-25-2014 14:07 PM",'MexicoCity', '-6');$('#MexicoCity').html(MexicoCity);
    Nigeria=calcTime("12-25-2014 14:07 PM",'Nigeria', '+1');$('#Nigeria').html(Nigeria);

},1000);