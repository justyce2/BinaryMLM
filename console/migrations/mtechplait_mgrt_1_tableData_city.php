<?php

use hzhihua\dump\Migration;

/**
 * Class mtechplait_mgrt_1_tableData_city
 * @property \yii\db\Transaction $_transaction
 * @Github https://github.com/Hzhihua
 */
class mtechplait_mgrt_1_tableData_city extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        
        $this->_transaction = $this->getDb()->beginTransaction();
        $this->batchInsert('{{%city}}', 
            ['id', 'state_id', 'name'],
            [
                [1, 1, 'Bombuflat'],
                [2, 1, 'Garacharma'],
                [3, 1, 'Port Blair'],
                [4, 1, 'Rangat'],
                [5, 2, 'Addanki'],
                [6, 2, 'Adivivaram'],
                [7, 2, 'Adoni'],
                [8, 2, 'Aganampudi'],
                [9, 2, 'Ajjaram'],
                [10, 2, 'Akividu'],
                [11, 2, 'Akkarampalle'],
                [12, 2, 'Akkayapalle'],
                [13, 2, 'Akkireddipalem'],
                [14, 2, 'Alampur'],
                [15, 2, 'Amalapuram'],
                [16, 2, 'Amudalavalasa'],
                [17, 2, 'Amur'],
                [18, 2, 'Anakapalle'],
                [19, 2, 'Anantapur'],
                [20, 2, 'Andole'],
                [21, 2, 'Atmakur'],
                [22, 2, 'Attili'],
                [23, 2, 'Avanigadda'],
                [24, 2, 'Badepalli'],
                [25, 2, 'Badvel'],
                [26, 2, 'Balapur'],
                [27, 2, 'Bandarulanka'],
                [28, 2, 'Banganapalle'],
                [29, 2, 'Bapatla'],
                [30, 2, 'Bapulapadu'],
                [31, 2, 'Belampalli'],
                [32, 2, 'Bestavaripeta'],
                [33, 2, 'Betamcherla'],
                [34, 2, 'Bhattiprolu'],
                [35, 2, 'Bhimavaram'],
                [36, 2, 'Bhimunipatnam'],
                [37, 2, 'Bobbili'],
                [38, 2, 'Bombuflat'],
                [39, 2, 'Bommuru'],
                [40, 2, 'Bugganipalle'],
                [41, 2, 'Challapalle'],
                [42, 2, 'Chandur'],
                [43, 2, 'Chatakonda'],
                [44, 2, 'Chemmumiahpet'],
                [45, 2, 'Chidiga'],
                [46, 2, 'Chilakaluripet'],
                [47, 2, 'Chimakurthy'],
                [48, 2, 'Chinagadila'],
                [49, 2, 'Chinagantyada'],
                [50, 2, 'Chinnachawk'],
                [51, 2, 'Chintalavalasa'],
                [52, 2, 'Chipurupalle'],
                [53, 2, 'Chirala'],
                [54, 2, 'Chittoor'],
                [55, 2, 'Chodavaram'],
                [56, 2, 'Choutuppal'],
                [57, 2, 'Chunchupalle'],
                [58, 2, 'Cuddapah'],
                [59, 2, 'Cumbum'],
                [60, 2, 'Darnakal'],
                [61, 2, 'Dasnapur'],
                [62, 2, 'Dauleshwaram'],
                [63, 2, 'Dharmavaram'],
                [64, 2, 'Dhone'],
                [65, 2, 'Dommara Nandyal'],
                [66, 2, 'Dowlaiswaram'],
                [67, 2, 'East Godavari Dist.'],
                [68, 2, 'Eddumailaram'],
                [69, 2, 'Edulapuram'],
                [70, 2, 'Ekambara kuppam'],
                [71, 2, 'Eluru'],
                [72, 2, 'Enikapadu'],
                [73, 2, 'Fakirtakya'],
                [74, 2, 'Farrukhnagar'],
                [75, 2, 'Gaddiannaram'],
                [76, 2, 'Gajapathinagaram'],
                [77, 2, 'Gajularega'],
                [78, 2, 'Gajuvaka'],
                [79, 2, 'Gannavaram'],
                [80, 2, 'Garacharma'],
                [81, 2, 'Garimellapadu'],
                [82, 2, 'Giddalur'],
                [83, 2, 'Godavarikhani'],
                [84, 2, 'Gopalapatnam'],
                [85, 2, 'Gopalur'],
                [86, 2, 'Gorrekunta'],
                [87, 2, 'Gudivada'],
                [88, 2, 'Gudur'],
                [89, 2, 'Guntakal'],
                [90, 2, 'Guntur'],
                [91, 2, 'Guti'],
                [92, 2, 'Hindupur'],
                [93, 2, 'Hukumpeta'],
                [94, 2, 'Ichchapuram'],
                [95, 2, 'Isnapur'],
                [96, 2, 'Jaggayyapeta'],
                [97, 2, 'Jallaram Kamanpur'],
                [98, 2, 'Jammalamadugu'],
                [99, 2, 'Jangampalli'],
                [100, 2, 'Jarjapupeta'],
                [101, 2, 'Kadiri'],
                [102, 2, 'Kaikalur'],
                [103, 2, 'Kakinada'],
                [104, 2, 'Kallur'],
                [105, 2, 'Kalyandurg'],
                [106, 2, 'Kamalapuram'],
                [107, 2, 'Kamareddi'],
                [108, 2, 'Kanapaka'],
                [109, 2, 'Kanigiri'],
                [110, 2, 'Kanithi'],
                [111, 2, 'Kankipadu'],
                [112, 2, 'Kantabamsuguda'],
                [113, 2, 'Kanuru'],
                [114, 2, 'Karnul'],
                [115, 2, 'Katheru'],
                [116, 2, 'Kavali'],
                [117, 2, 'Kazipet'],
                [118, 2, 'Khanapuram Haveli'],
                [119, 2, 'Kodar'],
                [120, 2, 'Kollapur'],
                [121, 2, 'Kondapalem'],
                [122, 2, 'Kondapalle'],
                [123, 2, 'Kondukur'],
                [124, 2, 'Kosgi'],
                [125, 2, 'Kothavalasa'],
                [126, 2, 'Kottapalli'],
                [127, 2, 'Kovur'],
                [128, 2, 'Kovurpalle'],
                [129, 2, 'Kovvur'],
                [130, 2, 'Krishna'],
                [131, 2, 'Kuppam'],
                [132, 2, 'Kurmannapalem'],
                [133, 2, 'Kurnool'],
                [134, 2, 'Lakshettipet'],
                [135, 2, 'Lalbahadur Nagar'],
                [136, 2, 'Machavaram'],
                [137, 2, 'Macherla'],
                [138, 2, 'Machilipatnam'],
                [139, 2, 'Madanapalle'],
                [140, 2, 'Madaram'],
                [141, 2, 'Madhuravada'],
                [142, 2, 'Madikonda'],
                [143, 2, 'Madugule'],
                [144, 2, 'Mahabubnagar'],
                [145, 2, 'Mahbubabad'],
                [146, 2, 'Malkajgiri'],
                [147, 2, 'Mamilapalle'],
                [148, 2, 'Mancheral'],
                [149, 2, 'Mandapeta'],
                [150, 2, 'Mandasa'],
                [151, 2, 'Mangalagiri'],
                [152, 2, 'Manthani'],
                [153, 2, 'Markapur'],
                [154, 2, 'Marturu'],
                [155, 2, 'Metpalli'],
                [156, 2, 'Mindi'],
                [157, 2, 'Mirpet'],
                [158, 2, 'Moragudi'],
                [159, 2, 'Mothugudam'],
                [160, 2, 'Nagari'],
                [161, 2, 'Nagireddipalle'],
                [162, 2, 'Nandigama'],
                [163, 2, 'Nandikotkur'],
                [164, 2, 'Nandyal'],
                [165, 2, 'Narasannapeta'],
                [166, 2, 'Narasapur'],
                [167, 2, 'Narasaraopet'],
                [168, 2, 'Narayanavanam'],
                [169, 2, 'Narsapur'],
                [170, 2, 'Narsingi'],
                [171, 2, 'Narsipatnam'],
                [172, 2, 'Naspur'],
                [173, 2, 'Nathayyapalem'],
                [174, 2, 'Nayudupeta'],
                [175, 2, 'Nelimaria'],
                [176, 2, 'Nellore'],
                [177, 2, 'Nidadavole'],
                [178, 2, 'Nuzvid'],
                [179, 2, 'Omerkhan daira'],
                [180, 2, 'Ongole'],
                [181, 2, 'Osmania University'],
                [182, 2, 'Pakala'],
                [183, 2, 'Palakole'],
                [184, 2, 'Palakurthi'],
                [185, 2, 'Palasa'],
                [186, 2, 'Palempalle'],
                [187, 2, 'Palkonda'],
                [188, 2, 'Palmaner'],
                [189, 2, 'Pamur'],
                [190, 2, 'Panjim'],
                [191, 2, 'Papampeta'],
                [192, 2, 'Parasamba'],
                [193, 2, 'Parvatipuram'],
                [194, 2, 'Patancheru'],
                [195, 2, 'Payakaraopet'],
                [196, 2, 'Pedagantyada'],
                [197, 2, 'Pedana'],
                [198, 2, 'Peddapuram'],
                [199, 2, 'Pendurthi'],
                [200, 2, 'Penugonda'],
                [201, 2, 'Penukonda'],
                [202, 2, 'Phirangipuram'],
                [203, 2, 'Pithapuram'],
                [204, 2, 'Ponnur'],
                [205, 2, 'Port Blair'],
                [206, 2, 'Pothinamallayyapalem'],
                [207, 2, 'Prakasam'],
                [208, 2, 'Prasadampadu'],
                [209, 2, 'Prasantinilayam'],
                [210, 2, 'Proddatur'],
                [211, 2, 'Pulivendla'],
                [212, 2, 'Punganuru'],
                [213, 2, 'Puttur'],
                [214, 2, 'Qutubullapur'],
                [215, 2, 'Rajahmundry'],
                [216, 2, 'Rajamahendri'],
                [217, 2, 'Rajampet'],
                [218, 2, 'Rajendranagar'],
                [219, 2, 'Rajoli'],
                [220, 2, 'Ramachandrapuram'],
                [221, 2, 'Ramanayyapeta'],
                [222, 2, 'Ramapuram'],
                [223, 2, 'Ramarajupalli'],
                [224, 2, 'Ramavarappadu'],
                [225, 2, 'Rameswaram'],
                [226, 2, 'Rampachodavaram'],
                [227, 2, 'Ravulapalam'],
                [228, 2, 'Rayachoti'],
                [229, 2, 'Rayadrug'],
                [230, 2, 'Razam'],
                [231, 2, 'Razole'],
                [232, 2, 'Renigunta'],
                [233, 2, 'Repalle'],
                [234, 2, 'Rishikonda'],
                [235, 2, 'Salur'],
                [236, 2, 'Samalkot'],
                [237, 2, 'Sattenapalle'],
                [238, 2, 'Seetharampuram'],
                [239, 2, 'Serilungampalle'],
                [240, 2, 'Shankarampet'],
                [241, 2, 'Shar'],
                [242, 2, 'Singarayakonda'],
                [243, 2, 'Sirpur'],
                [244, 2, 'Sirsilla'],
                [245, 2, 'Sompeta'],
                [246, 2, 'Sriharikota'],
                [247, 2, 'Srikakulam'],
                [248, 2, 'Srikalahasti'],
                [249, 2, 'Sriramnagar'],
                [250, 2, 'Sriramsagar'],
                [251, 2, 'Srisailam'],
                [252, 2, 'Srisailamgudem Devasthanam'],
                [253, 2, 'Sulurpeta'],
                [254, 2, 'Suriapet'],
                [255, 2, 'Suryaraopet'],
                [256, 2, 'Tadepalle'],
                [257, 2, 'Tadepalligudem'],
                [258, 2, 'Tadpatri'],
                [259, 2, 'Tallapalle'],
                [260, 2, 'Tanuku'],
                [261, 2, 'Tekkali'],
                [262, 2, 'Tenali'],
                [263, 2, 'Tigalapahad'],
                [264, 2, 'Tiruchanur'],
                [265, 2, 'Tirumala'],
                [266, 2, 'Tirupati'],
                [267, 2, 'Tirvuru'],
                [268, 2, 'Trimulgherry'],
                [269, 2, 'Tuni'],
                [270, 2, 'Turangi'],
                [271, 2, 'Ukkayapalli'],
                [272, 2, 'Ukkunagaram'],
                [273, 2, 'Uppal Kalan'],
                [274, 2, 'Upper Sileru'],
                [275, 2, 'Uravakonda'],
                [276, 2, 'Vadlapudi'],
                [277, 2, 'Vaparala'],
                [278, 2, 'Vemalwada'],
                [279, 2, 'Venkatagiri'],
                [280, 2, 'Venkatapuram'],
                [281, 2, 'Vepagunta'],
                [282, 2, 'Vetapalem'],
                [283, 2, 'Vijayapuri'],
                [284, 2, 'Vijayapuri South'],
                [285, 2, 'Vijayawada'],
                [286, 2, 'Vinukonda'],
                [287, 2, 'Visakhapatnam'],
                [288, 2, 'Vizianagaram'],
                [289, 2, 'Vuyyuru'],
                [290, 2, 'Wanparti'],
                [291, 2, 'West Godavari Dist.'],
                [292, 2, 'Yadagirigutta'],
                [293, 2, 'Yarada'],
                [294, 2, 'Yellamanchili'],
                [295, 2, 'Yemmiganur'],
                [296, 2, 'Yenamalakudru'],
                [297, 2, 'Yendada'],
                [298, 2, 'Yerraguntla'],
                [299, 3, 'Along'],
                [300, 3, 'Basar'],
                [301, 3, 'Bondila'],
                [302, 3, 'Changlang'],
                [303, 3, 'Daporijo'],
                [304, 3, 'Deomali'],
                [305, 3, 'Itanagar'],
                [306, 3, 'Jairampur'],
                [307, 3, 'Khonsa'],
                [308, 3, 'Naharlagun'],
                [309, 3, 'Namsai'],
                [310, 3, 'Pasighat'],
                [311, 3, 'Roing'],
                [312, 3, 'Seppa'],
                [313, 3, 'Tawang'],
                [314, 3, 'Tezu'],
                [315, 3, 'Ziro'],
                [316, 4, 'Abhayapuri'],
                [317, 4, 'Ambikapur'],
                [318, 4, 'Amguri'],
                [319, 4, 'Anand Nagar'],
                [320, 4, 'Badarpur'],
                [321, 4, 'Badarpur Railway Town'],
                [322, 4, 'Bahbari Gaon'],
                [323, 4, 'Bamun Sualkuchi'],
                [324, 4, 'Barbari'],
                [325, 4, 'Barpathar'],
                [326, 4, 'Barpeta'],
                [327, 4, 'Barpeta Road'],
                [328, 4, 'Basugaon'],
                [329, 4, 'Bihpuria'],
                [330, 4, 'Bijni'],
                [331, 4, 'Bilasipara'],
                [332, 4, 'Biswanath Chariali'],
                [333, 4, 'Bohori'],
                [334, 4, 'Bokajan'],
                [335, 4, 'Bokokhat'],
                [336, 4, 'Bongaigaon'],
                [337, 4, 'Bongaigaon Petro-chemical Town'],
                [338, 4, 'Borgolai'],
                [339, 4, 'Chabua'],
                [340, 4, 'Chandrapur Bagicha'],
                [341, 4, 'Chapar'],
                [342, 4, 'Chekonidhara'],
                [343, 4, 'Choto Haibor'],
                [344, 4, 'Dergaon'],
                [345, 4, 'Dharapur'],
                [346, 4, 'Dhekiajuli'],
                [347, 4, 'Dhemaji'],
                [348, 4, 'Dhing'],
                [349, 4, 'Dhubri'],
                [350, 4, 'Dhuburi'],
                [351, 4, 'Dibrugarh'],
                [352, 4, 'Digboi'],
                [353, 4, 'Digboi Oil Town'],
                [354, 4, 'Dimaruguri'],
                [355, 4, 'Diphu'],
                [356, 4, 'Dispur'],
                [357, 4, 'Doboka'],
                [358, 4, 'Dokmoka'],
                [359, 4, 'Donkamokan'],
                [360, 4, 'Duliagaon'],
                [361, 4, 'Duliajan'],
                [362, 4, 'Duliajan No.1'],
                [363, 4, 'Dum Duma'],
                [364, 4, 'Durga Nagar'],
                [365, 4, 'Gauripur'],
                [366, 4, 'Goalpara'],
                [367, 4, 'Gohpur'],
                [368, 4, 'Golaghat'],
                [369, 4, 'Golakganj'],
                [370, 4, 'Gossaigaon'],
                [371, 4, 'Guwahati'],
                [372, 4, 'Haflong'],
                [373, 4, 'Hailakandi'],
                [374, 4, 'Hamren'],
                [375, 4, 'Hauli'],
                [376, 4, 'Hauraghat'],
                [377, 4, 'Hojai'],
                [378, 4, 'Jagiroad'],
                [379, 4, 'Jagiroad Paper Mill'],
                [380, 4, 'Jogighopa'],
                [381, 4, 'Jonai Bazar'],
                [382, 4, 'Jorhat'],
                [383, 4, 'Kampur Town'],
                [384, 4, 'Kamrup'],
                [385, 4, 'Kanakpur'],
                [386, 4, 'Karimganj'],
                [387, 4, 'Kharijapikon'],
                [388, 4, 'Kharupetia'],
                [389, 4, 'Kochpara'],
                [390, 4, 'Kokrajhar'],
                [391, 4, 'Kumar Kaibarta Gaon'],
                [392, 4, 'Lakhimpur'],
                [393, 4, 'Lakhipur'],
                [394, 4, 'Lala'],
                [395, 4, 'Lanka'],
                [396, 4, 'Lido Tikok'],
                [397, 4, 'Lido Town'],
                [398, 4, 'Lumding'],
                [399, 4, 'Lumding Railway Colony'],
                [400, 4, 'Mahur'],
                [401, 4, 'Maibong'],
                [402, 4, 'Majgaon'],
                [403, 4, 'Makum'],
                [404, 4, 'Mangaldai'],
                [405, 4, 'Mankachar'],
                [406, 4, 'Margherita'],
                [407, 4, 'Mariani'],
                [408, 4, 'Marigaon'],
                [409, 4, 'Moran'],
                [410, 4, 'Moranhat'],
                [411, 4, 'Nagaon'],
                [412, 4, 'Naharkatia'],
                [413, 4, 'Nalbari'],
                [414, 4, 'Namrup'],
                [415, 4, 'Naubaisa Gaon'],
                [416, 4, 'Nazira'],
                [417, 4, 'New Bongaigaon Railway Colony'],
                [418, 4, 'Niz-Hajo'],
                [419, 4, 'North Guwahati'],
                [420, 4, 'Numaligarh'],
                [421, 4, 'Palasbari'],
                [422, 4, 'Panchgram'],
                [423, 4, 'Pathsala'],
                [424, 4, 'Raha'],
                [425, 4, 'Rangapara'],
                [426, 4, 'Rangia'],
                [427, 4, 'Salakati'],
                [428, 4, 'Sapatgram'],
                [429, 4, 'Sarthebari'],
                [430, 4, 'Sarupathar'],
                [431, 4, 'Sarupathar Bengali'],
                [432, 4, 'Senchoagaon'],
                [433, 4, 'Sibsagar'],
                [434, 4, 'Silapathar'],
                [435, 4, 'Silchar'],
                [436, 4, 'Silchar Part-X'],
                [437, 4, 'Sonari'],
                [438, 4, 'Sorbhog'],
                [439, 4, 'Sualkuchi'],
                [440, 4, 'Tangla'],
                [441, 4, 'Tezpur'],
                [442, 4, 'Tihu'],
                [443, 4, 'Tinsukia'],
                [444, 4, 'Titabor'],
                [445, 4, 'Udalguri'],
                [446, 4, 'Umrangso'],
                [447, 4, 'Uttar Krishnapur Part-I'],
                [448, 5, 'Amarpur'],
                [449, 5, 'Ara'],
                [450, 5, 'Araria'],
                [451, 5, 'Areraj'],
                [452, 5, 'Asarganj'],
                [453, 5, 'Aurangabad'],
                [454, 5, 'Bagaha'],
                [455, 5, 'Bahadurganj'],
                [456, 5, 'Bairgania'],
                [457, 5, 'Bakhtiyarpur'],
                [458, 5, 'Banka'],
                [459, 5, 'Banmankhi'],
                [460, 5, 'Bar Bigha'],
                [461, 5, 'Barauli'],
                [462, 5, 'Barauni Oil Township'],
                [463, 5, 'Barh'],
                [464, 5, 'Barhiya'],
                [465, 5, 'Bariapur'],
                [466, 5, 'Baruni'],
                [467, 5, 'Begusarai'],
                [468, 5, 'Behea'],
                [469, 5, 'Belsand'],
                [470, 5, 'Bettiah'],
                [471, 5, 'Bhabua'],
                [472, 5, 'Bhagalpur'],
                [473, 5, 'Bhimnagar'],
                [474, 5, 'Bhojpur'],
                [475, 5, 'Bihar'],
                [476, 5, 'Bihar Sharif'],
                [477, 5, 'Bihariganj'],
                [478, 5, 'Bikramganj'],
                [479, 5, 'Birpur'],
                [480, 5, 'Bodh Gaya'],
                [481, 5, 'Buxar'],
                [482, 5, 'Chakia'],
                [483, 5, 'Chanpatia'],
                [484, 5, 'Chhapra'],
                [485, 5, 'Chhatapur'],
                [486, 5, 'Colgong'],
                [487, 5, 'Dalsingh Sarai'],
                [488, 5, 'Darbhanga'],
                [489, 5, 'Daudnagar'],
                [490, 5, 'Dehri'],
                [491, 5, 'Dhaka'],
                [492, 5, 'Dighwara'],
                [493, 5, 'Dinapur'],
                [494, 5, 'Dinapur Cantonment'],
                [495, 5, 'Dumra'],
                [496, 5, 'Dumraon'],
                [497, 5, 'Fatwa'],
                [498, 5, 'Forbesganj'],
                [499, 5, 'Gaya'],
                [500, 5, 'Gazipur'],
            ]
        );
        $this->batchInsert('{{%city}}', 
            ['id', 'state_id', 'name'],
            [
                [501, 5, 'Ghoghardiha'],
                [502, 5, 'Gogri Jamalpur'],
                [503, 5, 'Gopalganj'],
                [504, 5, 'Habibpur'],
                [505, 5, 'Hajipur'],
                [506, 5, 'Hasanpur'],
                [507, 5, 'Hazaribagh'],
                [508, 5, 'Hilsa'],
                [509, 5, 'Hisua'],
                [510, 5, 'Islampur'],
                [511, 5, 'Jagdispur'],
                [512, 5, 'Jahanabad'],
                [513, 5, 'Jamalpur'],
                [514, 5, 'Jamhaur'],
                [515, 5, 'Jamui'],
                [516, 5, 'Janakpur Road'],
                [517, 5, 'Janpur'],
                [518, 5, 'Jaynagar'],
                [519, 5, 'Jha Jha'],
                [520, 5, 'Jhanjharpur'],
                [521, 5, 'Jogbani'],
                [522, 5, 'Kanti'],
                [523, 5, 'Kasba'],
                [524, 5, 'Kataiya'],
                [525, 5, 'Katihar'],
                [526, 5, 'Khagaria'],
                [527, 5, 'Khagaul'],
                [528, 5, 'Kharagpur'],
                [529, 5, 'Khusrupur'],
                [530, 5, 'Kishanganj'],
                [531, 5, 'Koath'],
                [532, 5, 'Koilwar'],
                [533, 5, 'Lakhisarai'],
                [534, 5, 'Lalganj'],
                [535, 5, 'Lauthaha'],
                [536, 5, 'Madhepura'],
                [537, 5, 'Madhubani'],
                [538, 5, 'Maharajganj'],
                [539, 5, 'Mahnar Bazar'],
                [540, 5, 'Mairwa'],
                [541, 5, 'Makhdumpur'],
                [542, 5, 'Maner'],
                [543, 5, 'Manihari'],
                [544, 5, 'Marhaura'],
                [545, 5, 'Masaurhi'],
                [546, 5, 'Mirganj'],
                [547, 5, 'Mohiuddinagar'],
                [548, 5, 'Mokama'],
                [549, 5, 'Motihari'],
                [550, 5, 'Motipur'],
                [551, 5, 'Munger'],
                [552, 5, 'Murliganj'],
                [553, 5, 'Muzaffarpur'],
                [554, 5, 'Nabinagar'],
                [555, 5, 'Narkatiaganj'],
                [556, 5, 'Nasriganj'],
                [557, 5, 'Natwar'],
                [558, 5, 'Naugachhia'],
                [559, 5, 'Nawada'],
                [560, 5, 'Nirmali'],
                [561, 5, 'Nokha'],
                [562, 5, 'Paharpur'],
                [563, 5, 'Patna'],
                [564, 5, 'Phulwari'],
                [565, 5, 'Piro'],
                [566, 5, 'Purnia'],
                [567, 5, 'Pusa'],
                [568, 5, 'Rafiganj'],
                [569, 5, 'Raghunathpur'],
                [570, 5, 'Rajgir'],
                [571, 5, 'Ramnagar'],
                [572, 5, 'Raxaul'],
                [573, 5, 'Revelganj'],
                [574, 5, 'Rusera'],
                [575, 5, 'Sagauli'],
                [576, 5, 'Saharsa'],
                [577, 5, 'Samastipur'],
                [578, 5, 'Sasaram'],
                [579, 5, 'Shahpur'],
                [580, 5, 'Shaikhpura'],
                [581, 5, 'Sherghati'],
                [582, 5, 'Shivhar'],
                [583, 5, 'Silao'],
                [584, 5, 'Sitamarhi'],
                [585, 5, 'Siwan'],
                [586, 5, 'Sonepur'],
                [587, 5, 'Sultanganj'],
                [588, 5, 'Supaul'],
                [589, 5, 'Teghra'],
                [590, 5, 'Tekari'],
                [591, 5, 'Thakurganj'],
                [592, 5, 'Vaishali'],
                [593, 5, 'Waris Aliganj'],
                [594, 6, 'Chandigarh'],
                [595, 7, 'Ahiwara'],
                [596, 7, 'Akaltara'],
                [597, 7, 'Ambagarh Chauki'],
                [598, 7, 'Ambikapur'],
                [599, 7, 'Arang'],
                [600, 7, 'Bade Bacheli'],
                [601, 7, 'Bagbahara'],
                [602, 7, 'Baikunthpur'],
                [603, 7, 'Balod'],
                [604, 7, 'Baloda'],
                [605, 7, 'Baloda Bazar'],
                [606, 7, 'Banarsi'],
                [607, 7, 'Basna'],
                [608, 7, 'Bemetra'],
                [609, 7, 'Bhanpuri'],
                [610, 7, 'Bhatapara'],
                [611, 7, 'Bhatgaon'],
                [612, 7, 'Bhilai'],
                [613, 7, 'Bilaspur'],
                [614, 7, 'Bilha'],
                [615, 7, 'Birgaon'],
                [616, 7, 'Bodri'],
                [617, 7, 'Champa'],
                [618, 7, 'Charcha'],
                [619, 7, 'Charoda'],
                [620, 7, 'Chhuikhadan'],
                [621, 7, 'Chirmiri'],
                [622, 7, 'Dantewada'],
                [623, 7, 'Deori'],
                [624, 7, 'Dhamdha'],
                [625, 7, 'Dhamtari'],
                [626, 7, 'Dharamjaigarh'],
                [627, 7, 'Dipka'],
                [628, 7, 'Doman Hill Colliery'],
                [629, 7, 'Dongargaon'],
                [630, 7, 'Dongragarh'],
                [631, 7, 'Durg'],
                [632, 7, 'Frezarpur'],
                [633, 7, 'Gandai'],
                [634, 7, 'Gariaband'],
                [635, 7, 'Gaurela'],
                [636, 7, 'Gelhapani'],
                [637, 7, 'Gharghoda'],
                [638, 7, 'Gidam'],
                [639, 7, 'Gobra Nawapara'],
                [640, 7, 'Gogaon'],
                [641, 7, 'Hatkachora'],
                [642, 7, 'Jagdalpur'],
                [643, 7, 'Jamui'],
                [644, 7, 'Jashpurnagar'],
                [645, 7, 'Jhagrakhand'],
                [646, 7, 'Kanker'],
                [647, 7, 'Katghora'],
                [648, 7, 'Kawardha'],
                [649, 7, 'Khairagarh'],
                [650, 7, 'Khamhria'],
                [651, 7, 'Kharod'],
                [652, 7, 'Kharsia'],
                [653, 7, 'Khonga Pani'],
                [654, 7, 'Kirandu'],
                [655, 7, 'Kirandul'],
                [656, 7, 'Kohka'],
                [657, 7, 'Kondagaon'],
                [658, 7, 'Korba'],
                [659, 7, 'Korea'],
                [660, 7, 'Koria Block'],
                [661, 7, 'Kota'],
                [662, 7, 'Kumhari'],
                [663, 7, 'Kumud Katta'],
                [664, 7, 'Kurasia'],
                [665, 7, 'Kurud'],
                [666, 7, 'Lingiyadih'],
                [667, 7, 'Lormi'],
                [668, 7, 'Mahasamund'],
                [669, 7, 'Mahendragarh'],
                [670, 7, 'Mehmand'],
                [671, 7, 'Mongra'],
                [672, 7, 'Mowa'],
                [673, 7, 'Mungeli'],
                [674, 7, 'Nailajanjgir'],
                [675, 7, 'Namna Kalan'],
                [676, 7, 'Naya Baradwar'],
                [677, 7, 'Pandariya'],
                [678, 7, 'Patan'],
                [679, 7, 'Pathalgaon'],
                [680, 7, 'Pendra'],
                [681, 7, 'Phunderdihari'],
                [682, 7, 'Pithora'],
                [683, 7, 'Raigarh'],
                [684, 7, 'Raipur'],
                [685, 7, 'Rajgamar'],
                [686, 7, 'Rajhara'],
                [687, 7, 'Rajnandgaon'],
                [688, 7, 'Ramanuj Ganj'],
                [689, 7, 'Ratanpur'],
                [690, 7, 'Sakti'],
                [691, 7, 'Saraipali'],
                [692, 7, 'Sarajpur'],
                [693, 7, 'Sarangarh'],
                [694, 7, 'Shivrinarayan'],
                [695, 7, 'Simga'],
                [696, 7, 'Sirgiti'],
                [697, 7, 'Takhatpur'],
                [698, 7, 'Telgaon'],
                [699, 7, 'Tildanewra'],
                [700, 7, 'Urla'],
                [701, 7, 'Vishrampur'],
                [702, 8, 'Amli'],
                [703, 8, 'Silvassa'],
                [704, 9, 'Daman'],
                [705, 9, 'Diu'],
                [706, 10, 'Delhi'],
                [707, 10, 'New Delhi'],
                [708, 11, 'Aldona'],
                [709, 11, 'Altinho'],
                [710, 11, 'Aquem'],
                [711, 11, 'Arpora'],
                [712, 11, 'Bambolim'],
                [713, 11, 'Bandora'],
                [714, 11, 'Bardez'],
                [715, 11, 'Benaulim'],
                [716, 11, 'Betora'],
                [717, 11, 'Bicholim'],
                [718, 11, 'Calapor'],
                [719, 11, 'Candolim'],
                [720, 11, 'Caranzalem'],
                [721, 11, 'Carapur'],
                [722, 11, 'Chicalim'],
                [723, 11, 'Chimbel'],
                [724, 11, 'Chinchinim'],
                [725, 11, 'Colvale'],
                [726, 11, 'Corlim'],
                [727, 11, 'Cortalim'],
                [728, 11, 'Cuncolim'],
                [729, 11, 'Curchorem'],
                [730, 11, 'Curti'],
                [731, 11, 'Davorlim'],
                [732, 11, 'Dona Paula'],
                [733, 11, 'Goa'],
                [734, 11, 'Guirim'],
                [735, 11, 'Jua'],
                [736, 11, 'Kalangat'],
                [737, 11, 'Kankon'],
                [738, 11, 'Kundaim'],
                [739, 11, 'Loutulim'],
                [740, 11, 'Madgaon'],
                [741, 11, 'Mapusa'],
                [742, 11, 'Margao'],
                [743, 11, 'Margaon'],
                [744, 11, 'Miramar'],
                [745, 11, 'Morjim'],
                [746, 11, 'Mormugao'],
                [747, 11, 'Navelim'],
                [748, 11, 'Pale'],
                [749, 11, 'Panaji'],
                [750, 11, 'Parcem'],
                [751, 11, 'Parra'],
                [752, 11, 'Penha de Franca'],
                [753, 11, 'Pernem'],
                [754, 11, 'Pilerne'],
                [755, 11, 'Pissurlem'],
                [756, 11, 'Ponda'],
                [757, 11, 'Porvorim'],
                [758, 11, 'Quepem'],
                [759, 11, 'Queula'],
                [760, 11, 'Raia'],
                [761, 11, 'Reis Magos'],
                [762, 11, 'Salcette'],
                [763, 11, 'Saligao'],
                [764, 11, 'Sancoale'],
                [765, 11, 'Sanguem'],
                [766, 11, 'Sanquelim'],
                [767, 11, 'Sanvordem'],
                [768, 11, 'Sao Jose-de-Areal'],
                [769, 11, 'Sattari'],
                [770, 11, 'Serula'],
                [771, 11, 'Sinquerim'],
                [772, 11, 'Siolim'],
                [773, 11, 'Taleigao'],
                [774, 11, 'Tivim'],
                [775, 11, 'Valpoi'],
                [776, 11, 'Varca'],
                [777, 11, 'Vasco'],
                [778, 11, 'Verna'],
                [779, 12, 'Abrama'],
                [780, 12, 'Adalaj'],
                [781, 12, 'Adityana'],
                [782, 12, 'Advana'],
                [783, 12, 'Ahmedabad'],
                [784, 12, 'Ahwa'],
                [785, 12, 'Alang'],
                [786, 12, 'Ambaji'],
                [787, 12, 'Ambaliyasan'],
                [788, 12, 'Amod'],
                [789, 12, 'Amreli'],
                [790, 12, 'Amroli'],
                [791, 12, 'Anand'],
                [792, 12, 'Andada'],
                [793, 12, 'Anjar'],
                [794, 12, 'Anklav'],
                [795, 12, 'Ankleshwar'],
                [796, 12, 'Anklesvar INA'],
                [797, 12, 'Antaliya'],
                [798, 12, 'Arambhada'],
                [799, 12, 'Asarma'],
                [800, 12, 'Atul'],
                [801, 12, 'Babra'],
                [802, 12, 'Bag-e-Firdosh'],
                [803, 12, 'Bagasara'],
                [804, 12, 'Bahadarpar'],
                [805, 12, 'Bajipura'],
                [806, 12, 'Bajva'],
                [807, 12, 'Balasinor'],
                [808, 12, 'Banaskantha'],
                [809, 12, 'Bansda'],
                [810, 12, 'Bantva'],
                [811, 12, 'Bardoli'],
                [812, 12, 'Barwala'],
                [813, 12, 'Bayad'],
                [814, 12, 'Bechar'],
                [815, 12, 'Bedi'],
                [816, 12, 'Beyt'],
                [817, 12, 'Bhachau'],
                [818, 12, 'Bhanvad'],
                [819, 12, 'Bharuch'],
                [820, 12, 'Bharuch INA'],
                [821, 12, 'Bhavnagar'],
                [822, 12, 'Bhayavadar'],
                [823, 12, 'Bhestan'],
                [824, 12, 'Bhuj'],
                [825, 12, 'Bilimora'],
                [826, 12, 'Bilkha'],
                [827, 12, 'Billimora'],
                [828, 12, 'Bodakdev'],
                [829, 12, 'Bodeli'],
                [830, 12, 'Bopal'],
                [831, 12, 'Boria'],
                [832, 12, 'Boriavi'],
                [833, 12, 'Borsad'],
                [834, 12, 'Botad'],
                [835, 12, 'Cambay'],
                [836, 12, 'Chaklasi'],
                [837, 12, 'Chala'],
                [838, 12, 'Chalala'],
                [839, 12, 'Chalthan'],
                [840, 12, 'Chanasma'],
                [841, 12, 'Chandisar'],
                [842, 12, 'Chandkheda'],
                [843, 12, 'Chanod'],
                [844, 12, 'Chaya'],
                [845, 12, 'Chenpur'],
                [846, 12, 'Chhapi'],
                [847, 12, 'Chhaprabhatha'],
                [848, 12, 'Chhatral'],
                [849, 12, 'Chhota Udepur'],
                [850, 12, 'Chikhli'],
                [851, 12, 'Chiloda'],
                [852, 12, 'Chorvad'],
                [853, 12, 'Chotila'],
                [854, 12, 'Dabhoi'],
                [855, 12, 'Dadara'],
                [856, 12, 'Dahod'],
                [857, 12, 'Dakor'],
                [858, 12, 'Damnagar'],
                [859, 12, 'Deesa'],
                [860, 12, 'Delvada'],
                [861, 12, 'Devgadh Baria'],
                [862, 12, 'Devsar'],
                [863, 12, 'Dhandhuka'],
                [864, 12, 'Dhanera'],
                [865, 12, 'Dhangdhra'],
                [866, 12, 'Dhansura'],
                [867, 12, 'Dharampur'],
                [868, 12, 'Dhari'],
                [869, 12, 'Dhola'],
                [870, 12, 'Dholka'],
                [871, 12, 'Dholka Rural'],
                [872, 12, 'Dhoraji'],
                [873, 12, 'Dhrangadhra'],
                [874, 12, 'Dhrol'],
                [875, 12, 'Dhuva'],
                [876, 12, 'Dhuwaran'],
                [877, 12, 'Digvijaygram'],
                [878, 12, 'Disa'],
                [879, 12, 'Dungar'],
                [880, 12, 'Dungarpur'],
                [881, 12, 'Dungra'],
                [882, 12, 'Dwarka'],
                [883, 12, 'Flelanganj'],
                [884, 12, 'GSFC Complex'],
                [885, 12, 'Gadhda'],
                [886, 12, 'Gandevi'],
                [887, 12, 'Gandhidham'],
                [888, 12, 'Gandhinagar'],
                [889, 12, 'Gariadhar'],
                [890, 12, 'Ghogha'],
                [891, 12, 'Godhra'],
                [892, 12, 'Gondal'],
                [893, 12, 'Hajira INA'],
                [894, 12, 'Halol'],
                [895, 12, 'Halvad'],
                [896, 12, 'Hansot'],
                [897, 12, 'Harij'],
                [898, 12, 'Himatnagar'],
                [899, 12, 'Ichchhapor'],
                [900, 12, 'Idar'],
                [901, 12, 'Jafrabad'],
                [902, 12, 'Jalalpore'],
                [903, 12, 'Jambusar'],
                [904, 12, 'Jamjodhpur'],
                [905, 12, 'Jamnagar'],
                [906, 12, 'Jasdan'],
                [907, 12, 'Jawaharnagar'],
                [908, 12, 'Jetalsar'],
                [909, 12, 'Jetpur'],
                [910, 12, 'Jodiya'],
                [911, 12, 'Joshipura'],
                [912, 12, 'Junagadh'],
                [913, 12, 'Kadi'],
                [914, 12, 'Kadodara'],
                [915, 12, 'Kalavad'],
                [916, 12, 'Kali'],
                [917, 12, 'Kaliawadi'],
                [918, 12, 'Kalol'],
                [919, 12, 'Kalol INA'],
                [920, 12, 'Kandla'],
                [921, 12, 'Kanjari'],
                [922, 12, 'Kanodar'],
                [923, 12, 'Kapadwanj'],
                [924, 12, 'Karachiya'],
                [925, 12, 'Karamsad'],
                [926, 12, 'Karjan'],
                [927, 12, 'Kathial'],
                [928, 12, 'Kathor'],
                [929, 12, 'Katpar'],
                [930, 12, 'Kavant'],
                [931, 12, 'Keshod'],
                [932, 12, 'Kevadiya'],
                [933, 12, 'Khambhaliya'],
                [934, 12, 'Khambhat'],
                [935, 12, 'Kharaghoda'],
                [936, 12, 'Khed Brahma'],
                [937, 12, 'Kheda'],
                [938, 12, 'Kheralu'],
                [939, 12, 'Kodinar'],
                [940, 12, 'Kosamba'],
                [941, 12, 'Kundla'],
                [942, 12, 'Kutch'],
                [943, 12, 'Kutiyana'],
                [944, 12, 'Lakhtar'],
                [945, 12, 'Lalpur'],
                [946, 12, 'Lambha'],
                [947, 12, 'Lathi'],
                [948, 12, 'Limbdi'],
                [949, 12, 'Limla'],
                [950, 12, 'Lunavada'],
                [951, 12, 'Madhapar'],
                [952, 12, 'Maflipur'],
                [953, 12, 'Mahemdavad'],
                [954, 12, 'Mahudha'],
                [955, 12, 'Mahuva'],
                [956, 12, 'Mahuvar'],
                [957, 12, 'Makarba'],
                [958, 12, 'Makarpura'],
                [959, 12, 'Makassar'],
                [960, 12, 'Maktampur'],
                [961, 12, 'Malia'],
                [962, 12, 'Malpur'],
                [963, 12, 'Manavadar'],
                [964, 12, 'Mandal'],
                [965, 12, 'Mandvi'],
                [966, 12, 'Mangrol'],
                [967, 12, 'Mansa'],
                [968, 12, 'Meghraj'],
                [969, 12, 'Mehsana'],
                [970, 12, 'Mendarla'],
                [971, 12, 'Mithapur'],
                [972, 12, 'Modasa'],
                [973, 12, 'Mogravadi'],
                [974, 12, 'Morbi'],
                [975, 12, 'Morvi'],
                [976, 12, 'Mundra'],
                [977, 12, 'Nadiad'],
                [978, 12, 'Naliya'],
                [979, 12, 'Nanakvada'],
                [980, 12, 'Nandej'],
                [981, 12, 'Nandesari'],
                [982, 12, 'Nandesari INA'],
                [983, 12, 'Naroda'],
                [984, 12, 'Navagadh'],
                [985, 12, 'Navagam Ghed'],
                [986, 12, 'Navsari'],
                [987, 12, 'Ode'],
                [988, 12, 'Okaf'],
                [989, 12, 'Okha'],
                [990, 12, 'Olpad'],
                [991, 12, 'Paddhari'],
                [992, 12, 'Padra'],
                [993, 12, 'Palanpur'],
                [994, 12, 'Palej'],
                [995, 12, 'Pali'],
                [996, 12, 'Palitana'],
                [997, 12, 'Paliyad'],
                [998, 12, 'Pandesara'],
                [999, 12, 'Panoli'],
                [1000, 12, 'Pardi'],
            ]
        );
        $this->_transaction->commit();

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        
        $this->_transaction->rollBack();

    }
}
