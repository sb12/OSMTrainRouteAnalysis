<?php 
    /**
    
    OSMTrainRouteAnalyzer Copyright © 2014 sb12 osm.mapper999@gmail.com
    
    This file is part of OSMTrainRouteAnalyzer.
    
    OSMTrainRouteAnalyzer is free software: you can redistribute it 
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
$tr_name["ICE1"] = "DB ICE 1";
$tr_type["ICE1"] = "highspeed";
$tr_maxspeed["ICE1"] = 280; // km/h
$tr_mass_empty["ICE1"] = 860; // t
$tr_power["ICE1"] = 9600; // kW
$tr_torque["ICE1"] = 300; // kN
$tr_seats["ICE1"] = 206;
$tr_acc["ICE1"] = 0.6; // m/s²
$tr_brake["ICE1"] = 0.6; // m/s²
$tr_length["ICE1"] = 0.410; // with 14 carriages
$tr_image["ICE1"] = "ICE1.png";


// DB ICE 2 (Germany)
$tr_name["ICE2"] = "DB ICE 2";
$tr_type["ICE2"] = "highspeed";
$tr_maxspeed["ICE2"] = 280; // km/h
$tr_mass_empty["ICE2"] = 420; // t
$tr_power["ICE2"] = 4800; // kW
$tr_torque["ICE2"] = 300; // kN
$tr_seats["ICE2"] = 206;
$tr_acc["ICE2"] = 0.6; // m/s²
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
$tr_seats["ICE3"] = 206;
$tr_acc["ICE3"] = 0.6; // m/s²
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
$tr_seats["ICE3V"] = 460;
$tr_acc["ICE3V"] = 0.6; // m/s²
$tr_brake["ICE3V"] = 0.6; // m/s²
$tr_length["ICE3V"] = 0.201;
$tr_image["ICE3V"] = "ICE3Velaro.png";


// DB ICE T 7-teilig (Germany)
$tr_name["ICE-T7"] = "DB ICE T 7-teilig";
$tr_type["ICE-T7"] = "long_distance";
$tr_maxspeed["ICE-T7"] = 230; // km/h
$tr_mass_empty["ICE-T7"] = 368; // t
$tr_power["ICE-T7"] = 4000; // kW
$tr_torque["ICE-T7"] = 200; // kN
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


/** long distance trains **/

//BR 101 + 12 IC-Wagen (Germany)
$tr_name["BR101IC"] = "DB Baureihe 101 mit 12 IC-Wagen";
$tr_type["BR101IC"] = "long_distance";
$tr_maxspeed["BR101IC"] = 200; // km/h
$tr_mass_empty["BR101IC"] = 42*12+84; // t
$tr_power["BR101IC"] = 6400; // kW
$tr_torque["BR101IC"] = 300; // kN
$tr_seats["BR101IC"] = 206;
$tr_acc["BR101IC"] = 1;
$tr_brake["BR101IC"] = 0.9;
$tr_length["BR101IC"] = 0.017+12*0.027;
$tr_image["BR101IC"] = "BR101IC.png";


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
