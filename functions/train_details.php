<?php 
    /**
    
    OSMTrainRouteAnalysis Copyright © 2014, 2015 sb12 osm.mapper999@gmail.com
    
    This file is part of OSMTrainRouteAnalysis.
    
    OSMTrainRouteAnalysis is free software: you can redistribute it 
    and/or modify it under the terms of the GNU General Public License 
    as published by the Free Software Foundation, either version 3 of 
    the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
    
    */
?>
<?php
/**
 * This file includes all trains and their details
 * Please see CONTRIBUTING.md and provide a pull request if you want to add a train.
 * Images are located in /img/trains/
 */

/** high speed trains **/


$tr_name["highspeed"] = "Generic High Speed Train";
$tr_type["highspeed"] = "highspeed";
$tr_maxspeed["highspeed"] = 320;// km/h
$tr_mass_empty["highspeed"] = 850;// t
$tr_power["highspeed"] = 16000;// kW
$tr_torque["highspeed"] = 400;// kN
$tr_seats["highspeed"] = 900;
$tr_acc["highspeed"] = 0.6;// m/s²
$tr_brake["highspeed"] = 0.6;// m/s²
$tr_length["highspeed"] = 0.4; //
$tr_image["highspeed"] = "highspeed.svg";


// DB ICE 1 (Germany)
// source: http://www.lok-report.de/ice/ICE-1-Text-.pdf (page 24)
$tr_name["ICE1"] = "DB ICE 1";
$tr_type["ICE1"] = "highspeed";
$tr_maxspeed["ICE1"] = 280; // km/h
$tr_mass_empty["ICE1"] = 796; // t
$tr_power["ICE1"] = 9600; // kW
$tr_torque["ICE1"] = 300; // kN
$tr_traction["ICE1"] = "EPP"; // experimental, not used yet
$tr_seats["ICE1"] = 703;
$tr_acc["ICE1"] = 0.5; // m/s²
$tr_brake["ICE1"] = 0.6; // m/s²
$tr_length["ICE1"] = 0.358; // with 12 carriages
$tr_image["ICE1"] = "ICE1.png";


// DB ICE 2 (Germany)
// source: http://de.wikipedia.org/wiki/ICE_2
$tr_name["ICE2"] = "DB ICE 2";
$tr_type["ICE2"] = "highspeed";
$tr_maxspeed["ICE2"] = 280; // km/h
$tr_mass_empty["ICE2"] = 412; // t
$tr_power["ICE2"] = 4800; // kW
$tr_torque["ICE2"] = 300; // kN
$tr_traction["ICE2"] = "EPP"; // experimental, not used yet
$tr_seats["ICE2"] = 381;
$tr_acc["ICE2"] = 0.5; // m/s²
$tr_brake["ICE2"] = 0.6; // m/s²
$tr_length["ICE2"] = 0.205;
$tr_image["ICE2"] = "ICE2.png";


// DB ICE 3 (Germany)
$tr_name["ICE3"] = "DB ICE 3";
$tr_type["ICE3"] = "highspeed";
$tr_maxspeed["ICE3"] = 330; // km/h
$tr_mass_empty["ICE3"] = 410; // t
$tr_power["ICE3"] = 8000; // kW
$tr_torque["ICE3"] = 300; // kN
$tr_traction["ICE3"] = "EMU"; // experimental, not used yet
$tr_seats["ICE3"] = 454;
$tr_acc["ICE3"] = 0.5; // m/s²
$tr_brake["ICE3"] = 0.6; // m/s²
$tr_length["ICE3"] = 0.201;
$tr_image["ICE3"] = "ICE3.png";


// DB ICE 3 Velaro (Germany)
$tr_name["ICE3V"] = "DB ICE 3 Velaro";
$tr_type["ICE3V"] = "highspeed";
$tr_maxspeed["ICE3V"] = 320; // km/h
$tr_mass_empty["ICE3V"] = 454; // t
$tr_power["ICE3V"] = 8000; // kW
$tr_torque["ICE3V"] = 300; // kN
$tr_traction["ICE3V"] = "EMU"; // experimental, not used yet
$tr_seats["ICE3V"] = 460;
$tr_acc["ICE3V"] = 0.5; // m/s²
$tr_brake["ICE3V"] = 0.6; // m/s²
$tr_length["ICE3V"] = 0.201;
$tr_image["ICE3V"] = "ICE3Velaro.png";


// DB ICE 4 7-teilig (Germany)
$tr_name["ICE4_7"] = "DB ICE 4 7-teilig";
$tr_type["ICE4_7"] = "highspeed";
$tr_maxspeed["ICE4_7"] = 230; // km/h
$tr_mass_empty["ICE4_7"] = 455; // t
$tr_power["ICE4_7"] = 4950; // kW
$tr_torque["ICE4_7"] = 250; // kN
$tr_traction["ICE4_7"] = "EMU"; // experimental, not used yet
$tr_seats["ICE4_7"] = 456;
$tr_acc["ICE4_7"] = 0.55; // m/s²
$tr_brake["ICE4_7"] = 0.6; // m/s²
$tr_length["ICE4_7"] = 0.200;
$tr_image["ICE4_7"] = "highspeed.svg";


// DB ICE 4 12-teilig (Germany)
$tr_name["ICE4_12"] = "DB ICE 4 12-teilig";
$tr_type["ICE4_12"] = "highspeed";
$tr_maxspeed["ICE4_12"] = 250; // km/h
$tr_mass_empty["ICE4_12"] = 670; // t
$tr_power["ICE4_12"] = 9900; // kW
$tr_torque["ICE4_12"] = 360; // kN
$tr_traction["ICE4_12"] = "EMU"; // experimental, not used yet
$tr_seats["ICE4_12"] = 830;
$tr_acc["ICE4_12"] = 0.53; // m/s²
$tr_brake["ICE4_12"] = 0.6; // m/s²
$tr_length["ICE4_12"] = 0.346;
$tr_image["ICE4_12"] = "highspeed.svg";


// DB ICE T 7-teilig (Germany)
$tr_name["ICE-T7"] = "DB ICE T 7-teilig";
$tr_type["ICE-T7"] = "highspeed";
$tr_maxspeed["ICE-T7"] = 230; // km/h
$tr_mass_empty["ICE-T7"] = 368; // t
$tr_power["ICE-T7"] = 4000; // kW
$tr_torque["ICE-T7"] = 200; // kN
$tr_traction["ICE-T7"] = "EMU"; // experimental, not used yet
$tr_seats["ICE-T7"] = 390;
$tr_acc["ICE-T7"] = 0.6; // m/s²
$tr_brake["ICE-T7"] = 0.6; // m/s²
$tr_length["ICE-T7"] = 0.1844;
$tr_image["ICE-T7"] = "ICET.png";


// EuroStar BR Class 373 (United Kingdom/France)
$tr_name["Class373"] = "EuroStar BR Class 373";
$tr_type["Class373"] = "highspeed";
$tr_maxspeed["Class373"] = 300; // km/h
$tr_mass_empty["Class373"] = 752; // t
$tr_power["Class373"] = 12200; // kW
$tr_torque["Class373"] = 410; // kN
$tr_seats["Class373"] = 750;
$tr_acc["Class373"] = 0.6; // m/s²
$tr_brake["Class373"] = 0.6; // m/s²
$tr_length["Class373"] = 0.387; //with 14 carriages
$tr_image["Class373"] = "Eurostar.png";


// EuroStar BR Class 374 (United Kingdom/France)
$tr_name["Class374"] = "EuroStar BR Class 374";
$tr_type["Class374"] = "highspeed";
$tr_maxspeed["Class374"] = 320; // km/h
$tr_mass_empty["Class374"] = 850; // t (estimated)
$tr_power["Class374"] = 16000; // kW
$tr_torque["Class374"] = 410; // kN (estimated)
$tr_seats["Class374"] = 900;
$tr_acc["Class374"] = 0.6; // m/s²
$tr_brake["Class374"] = 0.6; // m/s²
$tr_length["Class374"] = 0.390; //
$tr_image["Class374"] = "highspeed.svg"; //FIXME


// SNCF TGV Duplex (France)
$tr_name["TGVDuplex"] = "SNCF TGV Duplex";
$tr_type["TGVDuplex"] = "highspeed";
$tr_maxspeed["TGVDuplex"] = 320; // km/h
$tr_mass_empty["TGVDuplex"] = 380; // t
$tr_power["TGVDuplex"] = 8800; // kW
$tr_torque["TGVDuplex"] = 410; // kN
$tr_seats["TGVDuplex"] = 508;
$tr_acc["TGVDuplex"] = 0.6; // m/s²
$tr_brake["TGVDuplex"] = 0.6; // m/s²
$tr_length["TGVDuplex"] = 0.200; 
$tr_image["TGVDuplex"] = "TGV2N2.svg";


// ÖBB Railjet  (Austria)
$tr_name["railjet"] = "ÖBB Railjet";
$tr_type["railjet"] = "highspeed";
$tr_maxspeed["railjet"] = 230; // km/h
$tr_mass_empty["railjet"] = 419; // t
$tr_power["railjet"] = 6400; // kW
$tr_torque["railjet"] = 300; // kN
$tr_seats["railjet"] = 408;
$tr_acc["railjet"] = 0.6; // m/s²
$tr_brake["railjet"] = 0.6; // m/s²
$tr_length["railjet"] = 0.205; //mit 6 Wagen + Steuerwagen
$tr_image["railjet"] = "highspeed.svg"; //FIXME


// KTX-1  (Korea)
$tr_name["KTX1"] = "Korail KTX-1";
$tr_type["KTX1"] = "highspeed";
$tr_maxspeed["KTX1"] = 305; // km/h
$tr_mass_empty["KTX1"] = 701; // t
$tr_power["KTX1"] = 13560; // kW
$tr_torque["KTX1"] = 310; // kN (estimated)
$tr_traction["KTX1"] = "EPP"; // experimental, not used yet
$tr_seats["KTX1"] = 965;
$tr_acc["KTX1"] = 0.44; // m/s²
$tr_brake["KTX1"] = 0.97; // m/s²
$tr_length["KTX1"] = 0.388; // km
$tr_image["KTX1"] = "highspeed.svg"; //FIXME

// KTX-Sancheon  (Korea)
$tr_name["KTX2"] = "Korail KTX-Sancheon";
$tr_type["KTX2"] = "highspeed";
$tr_maxspeed["KTX2"] = 305; // km/h
$tr_mass_empty["KTX2"] = 403; // t
$tr_power["KTX2"] = 8800; // kW
$tr_torque["KTX2"] = 180; // kN (estimated)
$tr_traction["KTX2"] = "EPP"; // experimental, not used yet
$tr_seats["KTX2"] = 363;
$tr_acc["KTX2"] = 0.45; // m/s²
$tr_brake["KTX2"] = 0.97; // m/s²
$tr_length["KTX2"] = 0.201; // km
$tr_image["KTX2"] = "highspeed.svg"; //FIXME


/** long distance trains **/

//BR 101 + 12 IC-Wagen (Germany)
$tr_name["BR101IC"] = "DB Baureihe 101 mit 12 IC-Wagen";
$tr_type["BR101IC"] = "long_distance";
$tr_maxspeed["BR101IC"] = 200; // km/h
$tr_mass_empty["BR101IC"] = 42*12+84; // t
$tr_power["BR101IC"] = 6400; // kW
$tr_torque["BR101IC"] = 300; // kN
$tr_traction["BR101IC"] = "EPP"; // experimental, not used yet
$tr_seats["BR101IC"] = 206;
$tr_acc["BR101IC"] = 1;
$tr_brake["BR101IC"] = 0.9;
$tr_length["BR101IC"] = 0.017+12*0.027;
$tr_image["BR101IC"] = "BR101IC.png";

//BR 146.2 + 5 Doppelstock IC-Wagen (Germany)
$tr_name["DoStoIC"] = "DB Baureihe 146.2 mit 5 IC-Doppelstockwagen";
$tr_type["DoStoIC"] = "long_distance";
$tr_maxspeed["DoStoIC"] = 	160; // km/h
$tr_mass_empty["DoStoIC"] = 50*4+52+85; // t
$tr_power["DoStoIC"] = 4200; // kW
$tr_torque["DoStoIC"] = 300; // kN
$tr_traction["DoStoIC"] = "EPP"; // experimental, not used yet
$tr_seats["DoStoIC"] = 469;
$tr_acc["DoStoIC"] = 1;
$tr_brake["DoStoIC"] = 0.9;
$tr_length["DoStoIC"] = 0.017+5*0.027;
$tr_image["DoStoIC"] = "highspeed.svg";


// DB ICE TD (Germany)
$tr_name["ICE-TD"] = "DB ICE TD";
$tr_type["ICE-TD"] = "long_distance";
$tr_maxspeed["ICE-TD"] = 200; // km/h
$tr_mass_empty["ICE-TD"] = 219; // t
$tr_power["ICE-TD"] = 1700; // kW
$tr_torque["ICE-TD"] = 160; // kN
$tr_traction["ICE-TD"] = "DEMU"; //experimental, note used yet
$tr_seats["ICE-TD"] = 195;
$tr_acc["ICE-TD"] = 0.6; // m/s²
$tr_brake["ICE-TD"] = 0.6; // m/s²
$tr_length["ICE-TD"] = 0.1067; //km
$tr_image["ICE-TD"] = "ICET.png"; //FIXME: adjust images


/** regional trains **/


//Generic Regional Train
$tr_name["regional"] = "Generic Regional Train";
$tr_type["regional"] = "regional";
$tr_maxspeed["regional"] = 160; // km/h
$tr_mass_empty["regional"] = 110; // t
$tr_power["regional"] = 2400; // kW
$tr_torque["regional"] = 150; // kN
$tr_seats["regional"] = 200;
$tr_acc["regional"] = 1;
$tr_brake["regional"] = 0.9;
$tr_length["regional"] = 0.1;
$tr_image["regional"] = "regional.svg";


//BR 143 + 3 DoSto-Wagen (Germany)
$tr_name["DoSto-DR"] = "DB Baureihe 143 mit 3 Doppelstockwagen";
$tr_type["DoSto-DR"] = "regional";
$tr_maxspeed["DoSto-DR"] = 120; // kmh/
$tr_mass_empty["DoSto-DR"] = 55*3+82; // t
$tr_power["DoSto-DR"] = 3500; // kW
$tr_torque["DoSto-DR"] = 240; // kN
$tr_seats["DoSto-DR"] = 120;
$tr_acc["DoSto-DR"] = 0.7;
$tr_brake["DoSto-DR"] = 0.9;
$tr_length["DoSto-DR"] = 0.016+3*0.027;
$tr_image["DoSto-DR"] = "regional.svg";


//BR 146 + 5 DoSto-Wagen (Germany)
$tr_name["DoSto"] = "DB Baureihe 146 mit 5 Doppelstockwagen";
$tr_type["DoSto"] = "regional";
$tr_maxspeed["DoSto"] = 160; // km/h
$tr_mass_empty["DoSto"] = 55*5+82; // t
$tr_power["DoSto"] = 4200; // kW
$tr_torque["DoSto"] = 300; // kN
$tr_seats["DoSto"] = 206;
$tr_acc["DoSto"] = 1;
$tr_brake["DoSto"] = 0.9;
$tr_length["DoSto"] = 0.019+5*0.027;
$tr_image["DoSto"] = "Dosto_DB_Regio_5Wagen.svg";


//Metronom BR 146 + 6 DoSto-Wagen (Germany -> Niedersachsen)
$tr_name["DoStoMetronom"] = "Metronom Baureihe 146 mit 6 Doppelstockwagen";
$tr_type["DoStoMetronom"] = "regional";
$tr_maxspeed["DoStoMetronom"] = 160; // km/h
$tr_mass_empty["DoStoMetronom"] = 55*6+82; // t
$tr_power["DoStoMetronom"] = 4200; // kW
$tr_torque["DoStoMetronom"] = 300; // kN
$tr_seats["DoStoMetronom"] = 206;
$tr_acc["DoStoMetronom"] = 1;
$tr_brake["DoStoMetronom"] = 0.9;
$tr_length["DoStoMetronom"] = 0.019+6*0.027;
$tr_image["DoStoMetronom"] = "Metronom_6DostoWagen.svg";


//BR 111 + 5 n-Wagen (Germany)
$tr_name["BR111"] = "DB Baureihe 111 mit 5 n-Wagen";
$tr_type["BR111"] = "regional";
$tr_maxspeed["BR111"] = 140; // km/h
$tr_mass_empty["BR111"] = 40*5+83; // t
$tr_power["BR111"] = 3700; // kW
$tr_torque["BR111"] = 274; // kN
$tr_seats["BR111"] = 206;
$tr_acc["BR111"] = 1;
$tr_brake["BR111"] = 0.9;
$tr_length["BR111"] = 0.017+5*0.027;
$tr_image["BR111"] = "nWagenBR111.png";


//DB BR 420 (Germany)
$tr_name["BR420"] = "DB Baureihe 420";
$tr_type["BR420"] = "regional";
$tr_maxspeed["BR420"] = 120; // km/h
$tr_mass_empty["BR420"] = 129; // t
$tr_power["BR420"] = 2400; // kW
$tr_torque["BR420"] = 145; // kN
$tr_seats["BR420"] = 192;
$tr_acc["BR420"] = 1;
$tr_brake["BR420"] = 0.9;
$tr_length["BR420"] = 0.067;
$tr_image["BR420"] = "regional.svg"; // FIXME


//DB BR 422 (Germany)
$tr_name["BR422"] = "DB Baureihe 422";
$tr_type["BR422"] = "regional";
$tr_maxspeed["BR422"] = 140; // km/h
$tr_mass_empty["BR422"] = 112; // t
$tr_power["BR422"] = 2350; // kW
$tr_torque["BR422"] = 145; // kN
$tr_seats["BR422"] = 192;
$tr_acc["BR422"] = 1;
$tr_brake["BR422"] = 0.9;
$tr_length["BR422"] = 0.069;
$tr_image["BR422"] = "BR422.svg";


//DB BR 423 (Germany)
$tr_name["BR423"] = "DB Baureihe 423";
$tr_type["BR423"] = "regional";
$tr_maxspeed["BR423"] = 140; // km/h
$tr_mass_empty["BR423"] = 105; // t
$tr_power["BR423"] = 2350; // kW
$tr_torque["BR423"] = 145; // kN
$tr_seats["BR423"] = 192;
$tr_acc["BR423"] = 1;
$tr_brake["BR423"] = 0.9;
$tr_length["BR423"] = 0.069;
$tr_image["BR423"] = "BR423.svg";


//DB BR 425 (Germany)
$tr_name["BR425"] = "DB Baureihe 425";
$tr_type["BR425"] = "regional";
$tr_maxspeed["BR425"] = 140; // km/h
$tr_mass_empty["BR425"] = 114; // t
$tr_power["BR425"] = 2350; // kW
$tr_torque["BR425"] = 150; // kN
$tr_seats["BR425"] = 206;
$tr_acc["BR425"] = 1;
$tr_brake["BR425"] = 0.9;
$tr_length["BR425"] = 0.068;
$tr_image["BR425"] = "BR425.svg";

//DB BR 429 FLIRT 3 Süwex (Germany)
$tr_name["BR429Süwex"] = "DB Baureihe 429 Stadler FLIRT 3 5-teilig SÜWEX";
$tr_type["BR429Süwex"] = "regional";
$tr_maxspeed["BR429Süwex"] = 160; // km/h
$tr_mass_empty["BR429Süwex"] = 130; // t
$tr_power["BR429Süwex"] = 2000; // kW
$tr_torque["BR429Süwex"] = 175; // kN
$tr_seats["BR429Süwex"] = 270;
$tr_acc["BR429Süwex"] = 0.9;
$tr_brake["BR429Süwex"] = 0.9;
$tr_length["BR429Süwex"] = 0.098;
$tr_image["BR429Süwex"] = "StadlerFlirt_SÜWEX.svg";

//DB BR 430 (Germany)
$tr_name["BR430"] = "DB Baureihe 430";
$tr_type["BR430"] = "regional";
$tr_maxspeed["BR430"] = 140; // km/h
$tr_mass_empty["BR430"] = 119; // t
$tr_power["BR430"] = 2350; // kW
$tr_torque["BR430"] = 145; // kN
$tr_seats["BR430"] = 184;
$tr_acc["BR430"] = 1;
$tr_brake["BR430"] = 0.9;
$tr_length["BR430"] = 0.068;
$tr_image["BR430"] = "BR430.svg";

//DB BR 442.0 Talent 2 (Germany)
$tr_name["BR442.0"] = "DB Baureihe 442.0 Bombardier Talent 2 2-teilig";
$tr_type["BR442.0"] = "regional";
$tr_maxspeed["BR442.0"] = 160; // km/h
$tr_mass_empty["BR442.0"] = 70; // t
$tr_power["BR442.0"] = 2020; // kW
$tr_torque["BR442.0"] = 150; // kN
$tr_seats["BR442.0"] = 280;
$tr_acc["BR442.0"] = 1.1;
$tr_brake["BR442.0"] = 0.9;
$tr_length["BR442.0"] = 0.0401;
$tr_image["BR442.0"] = "BR442.0.svg";

//DB BR 442.1 Talent 2 (Germany)
$tr_name["BR442.1"] = "DB Baureihe 442.1 Bombardier Talent 2 3-teilig";
$tr_type["BR442.1"] = "regional";
$tr_maxspeed["BR442.1"] = 160; // km/h
$tr_mass_empty["BR442.1"] = 100; // t
$tr_power["BR442.1"] = 2020; // kW
$tr_torque["BR442.1"] = 150; // kN
$tr_seats["BR442.1"] = 280;
$tr_acc["BR442.1"] = 1.1;
$tr_brake["BR442.1"] = 0.9;
$tr_length["BR442.1"] = 0.0562;
$tr_image["BR442.1"] = "BR442.1.svg";

//DB BR 442.2 Talent 2 (Germany)
$tr_name["BR442.2"] = "DB Baureihe 442.2 Bombardier Talent 2 4-teilig";
$tr_type["BR442.2"] = "regional";
$tr_maxspeed["BR442.2"] = 160; // km/h
$tr_mass_empty["BR442.2"] = 130; // t
$tr_power["BR442.2"] = 3030; // kW
$tr_torque["BR442.2"] = 150; // kN
$tr_seats["BR442.2"] = 280;
$tr_acc["BR442.2"] = 1.1;
$tr_brake["BR442.2"] = 0.9;
$tr_length["BR442.2"] = 0.0723;
$tr_image["BR442.2"] = "BR442.2.svg";

//DB BR 442.3 Talent 2 (Germany)
$tr_name["BR442.3"] = "DB Baureihe 442.3 Bombardier Talent 2 5-teilig";
$tr_type["BR442.3"] = "regional";
$tr_maxspeed["BR442.3"] = 160; // km/h
$tr_mass_empty["BR442.3"] = 160; // t
$tr_power["BR442.3"] = 3030; // kW
$tr_torque["BR442.3"] = 150; // kN
$tr_seats["BR442.3"] = 280;
$tr_acc["BR442.3"] = 1.1;
$tr_brake["BR442.3"] = 0.9;
$tr_length["BR442.3"] = 0.0884;
$tr_image["BR442.3"] = "BR442.3.svg";

//DB BR 612 (Germany)
$tr_name["BR612"] = "DB Baureihe 612";
$tr_type["BR612"] = "regional";
$tr_maxspeed["BR612"] = 160; // km/h
$tr_mass_empty["BR612"] = 116; // t
$tr_power["BR612"] = 2*560; // kW
$tr_torque["BR612"] = 100; // estimated
$tr_seats["BR612"] = 156;
$tr_acc["BR612"] = 0.6; // m/s²
$tr_brake["BR612"] = 1; // m/s² estimated
$tr_length["BR612"] = 0.052; //in Einzeltraktion
$tr_image["BR612"] = "regional.svg"; //FIXME

//DB BR 628.4 (Germany)
$tr_name["BR628"] = "DB Baureihe 628";
$tr_type["BR628"] = "regional";
$tr_maxspeed["BR628"] = 120; // km/h
$tr_mass_empty["BR628"] = 70; // t
$tr_power["BR628"] = 485; // kW
$tr_torque["BR628"] = 50; // estimated
$tr_seats["BR628"] = 120;
$tr_acc["BR628"] = 1.2; // m/s²
$tr_brake["BR628"] = 1; // m/s²
$tr_length["BR628"] = 0.046; //in Einzeltraktion
$tr_image["BR628"] = "regional.svg"; //FIXME


//DB BR 642 (Germany)
$tr_name["BR642"] = "DB Baureihe 642 Siemens Desiro Classic";
$tr_type["BR642"] = "regional";
$tr_maxspeed["BR642"] = 120; // km/h
$tr_mass_empty["BR642"] = 69; // t
$tr_power["BR642"] = 550; // kW
$tr_torque["BR642"] = 50; // estimated
$tr_seats["BR642"] = 110;
$tr_acc["BR642"] = 1.2; // m/s²
$tr_brake["BR642"] = 1; // m/s²
$tr_length["BR642"] = 0.042; //in Einzeltraktion
$tr_image["BR642"] = "BR642.svg";


//DB BR 644 (Germany)
$tr_name["BR644"] = "DB Baureihe 644 Bombardier Talent 3-teilig";
$tr_type["BR644"] = "regional";
$tr_maxspeed["BR644"] = 120; // km/h
$tr_mass_empty["BR644"] = 96; // t
$tr_power["BR644"] = 1520; // kW
$tr_torque["BR644"] = 150; // estimated
$tr_seats["BR644"] = 161;
$tr_acc["BR644"] = 1; // m/s²
$tr_brake["BR644"] = 1.2; // m/s²
$tr_length["BR644"] = 0.052; //in Einzeltraktion
$tr_image["BR644"] = "regional.svg";


//SJ X31K (Sweden)
$tr_name["SJX31K"] = "SJ X31K Øresundståg";
$tr_type["SJX31K"] = "regional";
$tr_maxspeed["SJX31K"] = 180; // km/h
$tr_mass_empty["SJX31K"] = 156; // t
$tr_power["SJX31K"] = 2300; // kW
$tr_torque["SJX31K"] = 135; // estimated
$tr_traction["SJX31K"] = "EMU"; // experimental, not used yet
$tr_seats["SJX31K"] = 198;
$tr_acc["SJX31K"] = 0.87; // m/s²
$tr_brake["SJX31K"] = 1.0; // m/s²
$tr_length["SJX31K"] = 0.0789; //km
$tr_image["SJX31K"] = "regional.svg";


//SJ X60 Alstom Coradia Nordic (Sweden)
$tr_name["SJX60"] = "SJ X60 Alstom Coradia Nordic";
$tr_type["SJX60"] = "regional";
$tr_maxspeed["SJX60"] = 160; // km/h
$tr_mass_empty["SJX60"] = 206; // t
$tr_power["SJX60"] = 3000; // kW
$tr_torque["SJX60"] = 230; // kN // estimated
$tr_traction["SJX60"] = "EMU"; // experimental, not used yet
$tr_seats["SJX60"] = 374;
$tr_acc["SJX60"] = 1.12; // m/s²
$tr_brake["SJX60"] = 1.0; // m/s²
$tr_length["SJX60"] = 0.1071; //km
$tr_image["SJX60"] = "regional.svg";


//SJ X61 Alstom Coradia Nordic (Sweden)
$tr_name["SJX61"] = "SJ X61 Alstom Coradia Nordic";
$tr_type["SJX61"] = "regional";
$tr_maxspeed["SJX61"] = 160; // km/h
$tr_mass_empty["SJX61"] = 138; // t // estimated
$tr_power["SJX61"] = 3000; // kW
$tr_torque["SJX61"] = 160; // kN // estimated
$tr_traction["SJX61"] = "EMU"; // experimental, not used yet
$tr_seats["SJX61"] = 240; // estimated
$tr_acc["SJX61"] = 1.12; // m/s²
$tr_brake["SJX61"] = 1.0; // m/s²
$tr_length["SJX61"] = 0.0743; //km
$tr_image["SJX61"] = "regional.svg";


//SJ X62 Alstom Coradia Nordic (Sweden)
$tr_name["SJX62"] = "SJ X62 Alstom Coradia Nordic";
$tr_type["SJX62"] = "regional";
$tr_maxspeed["SJX62"] = 180; // km/h
$tr_mass_empty["SJX62"] = 138; // t // estimated
$tr_power["SJX62"] = 3000; // kW
$tr_torque["SJX62"] = 160; // kN // estimated
$tr_traction["SJX62"] = "EMU"; // experimental, not used yet
$tr_seats["SJX62"] = 240; // estimated
$tr_acc["SJX62"] = 1.12; // m/s²
$tr_brake["SJX62"] = 1.0; // m/s²
$tr_length["SJX62"] = 0.0743; //km
$tr_image["SJX62"] = "regional.svg";


//Stadler FLIRT 3 (Germany)
$tr_name["Flirt3_5t"] = "Stadler FLIRT 3 5-teilig";
$tr_type["Flirt3_5t"] = "regional";
$tr_maxspeed["Flirt3_5t"] = 160; // km/h
$tr_mass_empty["Flirt3_5t"] = 130; // t
$tr_power["Flirt3_5t"] = 2000; // kW
$tr_torque["Flirt3_5t"] = 175; // kN
$tr_seats["Flirt3_5t"] = 270;
$tr_acc["Flirt3_5t"] = 0.9;
$tr_brake["Flirt3_5t"] = 0.9;
$tr_length["Flirt3_5t"] = 0.098;
$tr_image["Flirt3_5t"] = "StadlerFlirt.svg";

//Stadler Regioshuttle RS1
$tr_name["RS1"] = "Stadler Regioshuttle RS1";
$tr_type["RS1"] = "regional";
$tr_maxspeed["RS1"] = 120; // km/h
$tr_mass_empty["RS1"] = 40; // t
$tr_power["RS1"] = 514; // kW //2*257kW
$tr_torque["RS1"] = 48; // kN
$tr_seats["RS1"] = 100;
$tr_acc["RS1"] = 1.2; // m/s²
$tr_brake["RS1"] = 1; // m/s²
$tr_length["RS1"] = 0.025; //in Einzeltraktion
$tr_image["RS1"] = "regional.svg";


//Alstom Coradia LINT 41
$tr_name["LINT41"] = "Alstom Coradia LINT 41";
$tr_type["LINT41"] = "regional";
$tr_maxspeed["LINT41"] = 120; // km/h
$tr_mass_empty["LINT41"] = 63.5; // t
$tr_power["LINT41"] = 630; // kW //2*315kW
$tr_torque["LINT41"] = 38; // kN
$tr_seats["LINT41"] = 110;
$tr_acc["LINT41"] = 0.6; // m/s²
$tr_brake["LINT41"] = 0.6; // m/s²
$tr_length["LINT41"] = 0.042;
$tr_image["LINT41"] = "Lint41.svg";


//erixx LINT 41 (Germany -> Niedersachsen)
$tr_name["LINT41erixx"] = "erixx LINT 41";
$tr_type["LINT41erixx"] = "regional";
$tr_maxspeed["LINT41erixx"] = 120; // km/h
$tr_mass_empty["LINT41erixx"] = 63.5; // t
$tr_power["LINT41erixx"] = 630; // kW //2*315kW
$tr_torque["LINT41erixx"] = 38; // kN
$tr_seats["LINT41erixx"] = 110;
$tr_acc["LINT41erixx"] = 0.6; // m/s²
$tr_brake["LINT41erixx"] = 0.6; // m/s²
$tr_length["LINT41erixx"] = 0.042; // in Einzeltraktion
$tr_image["LINT41erixx"] = "Lint41erixx.svg";


//British Rail Class 153 (United Kingdom)
$tr_name["Class153"] = "British Rail Class 153 DMU";
$tr_type["Class153"] = "regional";
$tr_maxspeed["Class153"] = 121; // km/h (75 mph)
$tr_mass_empty["Class153"] = 41.2; // t
$tr_power["Class153"] = 213; // kW 
$tr_torque["Class153"] = 38; // kN //FIXME
$tr_seats["Class153"] = 110;
$tr_acc["Class153"] = 0.6; // m/s²
$tr_brake["Class153"] = 0.6; // m/s²
$tr_length["Class153"] = 0.023;
$tr_image["Class153"] = "Class153.svg";


//British Rail Class 153 Arriva Trains Wales (United Kingdom)
$tr_name["Class153ATW"] = "Arriva Trains Wales Class 153 DMU";
$tr_type["Class153ATW"] = "regional";
$tr_maxspeed["Class153ATW"] = 121; // km/h (75 mph)
$tr_mass_empty["Class153ATW"] = 41.2; // t
$tr_power["Class153ATW"] = 213; // kW
$tr_torque["Class153ATW"] = 38; // kN //FIXME
$tr_seats["Class153ATW"] = 110;
$tr_acc["Class153ATW"] = 0.6; // m/s²
$tr_brake["Class153ATW"] = 0.6; // m/s²
$tr_length["Class153ATW"] = 0.023;
$tr_image["Class153ATW"] = "Class153_ATW.svg";


/** light rail trains **/

//Generic Light Rail Train
$tr_name["light_rail"] = "Generic Light Rail Train";
$tr_type["light_rail"] = "light_rail";
$tr_maxspeed["light_rail"] = 100; // km/h
$tr_mass_empty["light_rail"] = 60; // t
$tr_power["light_rail"] = 600; // kW //2*257kW
$tr_torque["light_rail"] = 50; // kN
$tr_seats["light_rail"] = 100;
$tr_acc["light_rail"] = 0.9; // m/s²
$tr_brake["light_rail"] = 1.6; // m/s²
$tr_length["light_rail"] = 0.04;
$tr_image["light_rail"] = "light_rail.svg";


//AVG Stadtbahn GT8-100C/2S (Germany -> Karlsruhe)
$tr_name["GT8-100C"] = "AVG Stadtbahn GT8-100C/2S";
$tr_type["GT8-100C"] = "light_rail";
$tr_maxspeed["GT8-100C"] = 95; // km/h
$tr_mass_empty["GT8-100C"] = 58.6; // t
$tr_power["GT8-100C"] = 560; // kW //2*257kW
$tr_torque["GT8-100C"] = 49.8; // kN
$tr_seats["GT8-100C"] = 95;
$tr_acc["GT8-100C"] = 0.85; // m/s²
$tr_brake["GT8-100C"] = 1.6; // m/s²
$tr_length["GT8-100C"] = 0.025; // in Einzeltraktion
$tr_image["GT8-100C"] = "GT8-100C2S.png";


//AVG Stadtbahn GT8-100D/2S (Germany -> Karlsruhe)
$tr_name["GT8-100D"] = "AVG Stadtbahn GT8-100D/2S-M";
$tr_type["GT8-100D"] = "light_rail";
$tr_maxspeed["GT8-100D"] = 100; // km/h
$tr_mass_empty["GT8-100D"] = 59; // t
$tr_power["GT8-100D"] = 508; // kW //2*257kW
$tr_torque["GT8-100D"] = 59; // kN
$tr_seats["GT8-100D"] = 95;
$tr_acc["GT8-100D"] = 0.85; // m/s²
$tr_brake["GT8-100D"] = 1.6; // m/s²
$tr_length["GT8-100D"] = 0.025; // in Einzeltraktion
$tr_image["GT8-100D"] = "GT8-100D2SM.png";


//AVG Stadtbahn ET2010 (Germany -> Karlsruhe)
$tr_name["ET2010"] = "AVG Stadtbahn ET2010";
$tr_type["ET2010"] = "light_rail";
$tr_maxspeed["ET2010"] = 100; // km/h
$tr_mass_empty["ET2010"] = 62; // t
$tr_power["ET2010"] = 600; // kW //2*257kW
$tr_torque["ET2010"] = 74; // kN
$tr_seats["ET2010"] = 95;
$tr_acc["ET2010"] = 1.2; // m/s²
$tr_brake["ET2010"] = 1.5; // m/s²
$tr_length["ET2010"] = 0.037; //in Einzeltraktion
$tr_image["ET2010"] = "ET2010.png";


//Docklands Light Railway B07 (United Kingdom -> London)
$tr_name["DLR_B07"] = "Docklands Light Railway B07";
$tr_type["DLR_B07"] = "light_rail";
$tr_maxspeed["DLR_B07"] = 100; // km/h
$tr_mass_empty["DLR_B07"] = 2 * 36; // t
$tr_power["DLR_B07"] = 2 * 600; // kW //unknown
$tr_torque["DLR_B07"] = 2 * 74; // kN //unknown
$tr_seats["DLR_B07"] = 140;
$tr_acc["DLR_B07"] = 1.2; // m/s²
$tr_brake["DLR_B07"] = 1.5; // m/s²
$tr_length["DLR_B07"] = 0.0576; // 2 cars
$tr_image["DLR_B07"] = "DLR_double.svg";


/** trams **/

//Generic Tram
$tr_name["tram"] = "Generic Tram";
$tr_type["tram"] = "tram";
$tr_maxspeed["tram"] = 70;// km/h
$tr_mass_empty["tram"] = 60;// t
$tr_power["tram"] = 500;// kW //2*257kW
$tr_torque["tram"] = 80;// kN
$tr_seats["tram"] = 100;
$tr_acc["tram"] = 1.5;// m/s²
$tr_brake["tram"] = 1.5;// m/s²
$tr_length["tram"] = 0.04; //in Einzeltraktion
$tr_image["tram"] = "tram.svg";


//Edinburgh Tram (United Kingdom -> Edinburgh)
$tr_name["Edinburgh"] = "Edinburgh Tram";
$tr_type["Edinburgh"] = "tram";
$tr_maxspeed["Edinburgh"] = 70; // km/h
$tr_mass_empty["Edinburgh"] = 56; // t
$tr_power["Edinburgh"] = 960; // kW ( 12 * 80kW )
$tr_torque["Edinburgh"] = 75; // kN (estimated)
$tr_seats["Edinburgh"] = 78;
$tr_acc["Edinburgh"] = 1.3; // m/s²
$tr_brake["Edinburgh"] = 1.6; // m/s²
$tr_length["Edinburgh"] = 0.0428;
$tr_image["Edinburgh"] = "Edinburgh_tram.svg";


//VBK Straßenbahn NET2012 (Germany -> Karlsruhe)
$tr_name["NET2012"] = "VBK Straßenbahn NET2012";
$tr_type["NET2012"] = "tram";
$tr_maxspeed["NET2012"] = 80;// km/h
$tr_mass_empty["NET2012"] = 57.5;// t
$tr_power["NET2012"] = 500;// kW //2*257kW
$tr_torque["NET2012"] = 75;// kN
$tr_seats["NET2012"] = 107;
$tr_acc["NET2012"] = 1.3;// m/s²
$tr_brake["NET2012"] = 1.6;// m/s²
$tr_length["NET2012"] = 0.037; //in Einzeltraktion
$tr_image["NET2012"] = "NET2012.png";


/** subway trains **/

// generic subway train
$tr_name["subway"] = "Generic Subway Train";
$tr_type["subway"] = "subway";
$tr_maxspeed["subway"] = 80;// km/h
$tr_mass_empty["subway"] = 50;// t
$tr_power["subway"] = 600;// kW //Stundenleistung
$tr_torque["subway"] = 60;// kN
$tr_seats["subway"] = 80;
$tr_acc["subway"] = 1.5;// m/s²
$tr_brake["subway"] = 1.5;// m/s²
$tr_length["subway"] = 0.04; //in Einzeltraktion
$tr_image["subway"] = "subway.svg";

//BVG Großprofil-Baureihe F (Germany -> Berlin)
$tr_name["BVG-F"] = "BVG Baureihe F";
$tr_type["BVG-F"] = "subway";
$tr_maxspeed["BVG-F"] = 72;// km/h
$tr_mass_empty["BVG-F"] = 40;// t
$tr_power["BVG-F"] = 540;// kW //Stundenleistung
$tr_torque["BVG-F"] = 60;// kN
$tr_seats["BVG-F"] = 76;
$tr_acc["BVG-F"] = 1.5;// m/s²
$tr_brake["BVG-F"] = 1.6;// m/s²
$tr_length["BVG-F"] = 0.032; //in Einzeltraktion
$tr_image["BVG-F"] = "subway.svg";


//BVG Großprofil-Baureihe H (Germany -> Berlin)
$tr_name["BVG-H"] = "BVG Baureihe H";
$tr_type["BVG-H"] = "subway";
$tr_maxspeed["BVG-H"] = 72;// km/h
$tr_mass_empty["BVG-H"] = 141.4;// t
$tr_power["BVG-H"] = 2160;// kW //Stundenleistung
$tr_torque["BVG-H"] = 210;// kN
$tr_seats["BVG-H"] = 76;
$tr_acc["BVG-H"] = 1.5;// m/s²
$tr_brake["BVG-H"] = 1.6;// m/s²
$tr_length["BVG-H"] = 0.0987; //in Einzeltraktion
$tr_image["BVG-H"] = "BVG-H.svg"; //in Einzeltraktion
?>
