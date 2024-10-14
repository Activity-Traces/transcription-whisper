<?php

class html
{

    public function Message($message)
    {

        echo <<<HTML

                <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
                    <div class="toast-container position-fixed top-0 left-0 p-3">

                        <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <strong class="me-auto">Info</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>

                        <div class="toast-body">
                            $message
                        </div>
                        
                        </div>
                    </div>
                </div>
HTML;
    }



    /****************************************************************************************************************************************** */

    public function Table($headers, $contents, $page, $param, $editpage, $canEdit, $canDelete)
    {

        echo <<<HTML
            <div class="table-wrapper"><table id="tb$page" class="table table-hover"><thead><tr>
HTML;

        foreach ($headers as $header) {

            if ($header != "")
                echo "<th style='width: 5%'>{$header}</th>";

            else
                echo "<th style='width: 2%'>{$header}</th>";
        }

        echo <<<HTML
            </tr></thead><tbody>
HTML;

        while ($row = $contents->fetch_row()) {

            $id = $row[0];

            foreach ($row as $content)
                echo "<td>" . $content . "</td>";

            if ($page == 'Utilisateurs') {


                if ($row[6]   == 1) {
                    $icon = "fas fa-user";
                    $titre = 'Actif';
                    $color = '#B03A2E';
                    $access = 1;
                } else {
                    $icon = "fas fa-user-lock";
                    $titre = 'Bloqué';
                    $color = '#212F3C';
                    $access = 0;
                }


                echo <<<HTML
                    <td >
                        <a href='../../Controller/utilisateursController.php?userid=$id&actif=$access&title=$titre'>
                            <i class='$icon' style='color:$color;'></i>
                        </a>
                    </td>
HTML;
            }

            if ($canEdit)
                echo <<<HTML
                    <td >
                        <a href='$editpage.php?edit=$id' title='Editer'>
                            <i class='fas fa-marker'></i>
                        </a>
                    </td>
HTML;

            if ($canDelete)
                echo <<<HTML
                    <td >
                        <a href='$page.php?$param=$id'  titre='Supprimer' 
                            OnClick="return confirm('Vouslez-vous supprimer définitivement cet enregistrement?');">
                            <i class='fas fa-trash'></i>
                        </a>
                    </td>

                    </tr>

HTML;
        }
        echo <<<HTML
            </tbody></table></div>  
HTML;
    }




    /****************************************************************************************************************************************** */

    public function SavedList($contents)
    {
        echo '<div class="list-group">';


        while ($row = $contents->fetch_row()) {

            echo <<<HTML
                <div class="list-group-item list-group-item-linkable"
                    data-link="http://www.google.com">
                    <a msok="yes" href="../../Controller/savedTranscriptionController.php?mode=1&FileId=$row[0]&TransId=$row[1]"><i class="fa-solid fa-trash-can"></i></a>                    
                    &nbsp; 
                    <a msok="yes" href="../../Controller/savedTranscriptionController.php?mode=2&FileId=$row[0]&TransId=$row[1]">$row[2]</a>
                </div>
HTML;
        }
        echo '</div>';
    }

    /****************************************************************************************************************************************** */

    public function TranscrptionTable($table, $headers, $contents, $voirLink, $Folder)
    {

        echo <<<HTML
             <div class="table-wrapper"><table id="tb$table" class="table table-striped"><thead><tr>
             <th style='width: 2%; color: white; background-color: #34495E'>#</th>
             <th style='width: 10%; color: white; background-color: #34495E'>Nom</th>
             <th style='width: 5%; color: white; background-color: #34495E'>Créer le</th>

             <th style='width: 10%; color: white; background-color: #34495E'>Description</th>
             <th style='width: 2%; color: white; background-color: #34495E'></th>        
             </tr></thead><tbody>
HTML;

        $i = 1;
        while ($row = $contents->fetch_row()) {

            $ToPlay = $Folder . $row[1] . '.' . $row[3];
            $id = $row[0];

            echo <<<HTML

             <td>$i</td>

             <td>$row[1]</td>
             <td>$row[4]</td>
             <td>$row[2]</td>                            
             <td >
                 <div class=float-right'>

                     <a href='' title='Voir le fichier multimedia' id='$row[1]' onclick="play('$ToPlay', '$row[1]')"
                         type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasBottom' aria-controls='offcanvasBottom' >
                         <i class='fa-regular fa-circle-play'></i>
                     </a>

                     &nbsp; 

                     <a href='Template/Transcription/ouvrirTranscription.php?open=$id' title='Ouvrir la transcription'>
                         <i class='fa-solid fa-book-open'></i>                    
                     </a>
                     &nbsp; 
                 
                     <a href='index.php?delete=$id'  titre='Supprimer' OnClick="return confirm('Vouslez-vous supprimer définitivement cette transcription?');">
                         <i class='fas fa-trash'></i>
                     </a>

                 </div>
             </td>
                                         
         </tr>
HTML;
            $i++;
        }
        echo <<<HTML
         </tbody></table></div>

HTML;
    }


    /****************************************************************************************************************************************** */

    public function OuvrirTranscription($contents, $authorList, $play)
    {

        echo <<<HTML
            <div><table id="ouvrirTranscription" class="table table-hover table-borderless">
            <thead>
                <tr>
                    <th style='width: 0.2%'>#</th>
                    <th style='width: 0.5%'>Locuteur</th>
                    <th style='width: 2.5%'>Durée</th>
                    <th style='width: 1%'></th>
                    <th style='width: 10%'>Texte</th>
                </tr>
            </thead>
            <tbody>
HTML;

        $temp = $authorList;

        while ($row = $contents->fetch_row()) {

            $color = '';
            if ($row[3] == "") $color = "background-color: #D9E9D4;";

            echo '';



            echo <<<HTML
            <tr style="$color">
                <td>
                    <input msok="yes" 
                        class="form-check-input" 
                        type="checkbox"  
                        iddebut=$row[4] 
                        idfin=$row[5] 
                        id="ListCheked" 
                        name="ListCheked" 
                        value=$row[0]
                        id=$row[0]
                        
                    >
                </td>
       
            <td>
                <select 
                    msok='yes' 
                    Id='Authors[$row[0]]' 
                    name='Authors[$row[0]]' 
                    class=' form-control form-control-sm border-0 shadow-none'
                >
HTML;

            for ($i = 0; $i < count($authorList); $i++) {
                $OptionValue = $authorList[$i][0];
                $optionLabelValue = $authorList[$i][1];
                if ($row[1] == $optionLabelValue)
                    echo "<option value='$OptionValue' selected>$optionLabelValue</option>";
                else
                    echo "<option value='$OptionValue'>$optionLabelValue</option>";
            }


            echo <<<HTML
            </select>
            </td>
            <td>
                <input type='text' msok='yes' Id='MyDates[$row[0]]' 
                name='MyDates[$row[0]]' 
                class=' form-control form-control-sm border-0 shadow-none' 
                value='$row[2]'></td>
            <td >
                <a href='' title='Play'
                    id='playme' 
                    TimeVal='$row[2]'
                    type='button' data-bs-toggle='offcanvas' 
                    data-bs-target='#offcanvasBottom' 
                    aria-controls='offcanvasBottom' >
                    <i class='fa-solid fa-circle-play'></i>
                </a>

                <a href='' title='Pause'
                    id='$row[1]'  onclick="stopPosition()"
                    type='button' data-bs-toggle='offcanvas' 
                    data-bs-target='#offcanvasBottom' 
                    aria-controls='offcanvasBottom' >
                    <i class='fa-regular fa-circle-pause'></i>
                </a>
            </td>
                   
            <td>

                <textarea 
                    Id = "MyTextarea[$row[0]]" 
                    class=" form-control form-control-sm border-0 shadow-none auto-resize" 
                    name="MyTextarea[$row[0]]">$row[3]</textarea>
            </td>
HTML;
        }
        $authorList = $temp;

        echo <<<HTML
            </tbody></table></div>

HTML;
    }


    public function auteurs($contents)
    {

        $langue = [
            "fr" => "French - français",
            "fr-CA" => "French (Canada) - français (Canada)",
            "fr-FR" => "French (France) - français (France)",
            "fr-CH" => "French (Switzerland) - français (Suisse)",
            "en" => "English",
            "en-AU" => "English (Australia)",
            "en-CA" => "English (Canada)",
            "en-IN" => "English (India)",
            "en-NZ" => "English (New Zealand)",
            "en-ZA" => "English (South Africa)",
            "en-GB" => "English (United Kingdom)",
            "en-US" => "English (United States)",

            "af" => "Afrikaans",
            "sq" => "Albanian - shqip",
            "am" => "Amharic - አማርኛ",
            "ar" => "Arabic - العربية",
            "an" => "Aragonese - aragonés",
            "hy" => "Armenian - հայերեն",
            "ast" => "Asturian - asturianu",
            "az" => "Azerbaijani - azərbaycan dili",
            "eu" => "Basque - euskara",
            "be" => "Belarusian - беларуская",
            "bn" => "Bengali - বাংলা",
            "bs" => "Bosnian - bosanski",
            "br" => "Breton - brezhoneg",
            "bg" => "Bulgarian - български",
            "ca" => "Catalan - català",
            "ckb" => "Central Kurdish - کوردی (دەستنوسی عەرەبی)",
            "zh" => "Chinese - 中文",
            "zh-HK" => "Chinese (Hong Kong) - 中文（香港）",
            "zh-CN" => "Chinese (Simplified) - 中文（简体）",
            "zh-TW" => "Chinese (Traditional) - 中文（繁體）",
            "co" => "Corsican",
            "hr" => "Croatian - hrvatski",
            "cs" => "Czech - čeština",
            "da" => "Danish - dansk",
            "nl" => "Dutch - Nederlands",
            "eo" => "Esperanto - esperanto",
            "et" => "Estonian - eesti",
            "fo" => "Faroese - føroyskt",
            "fil" => "Filipino",
            "fi" => "Finnish - suomi",
            "gl" => "Galician - galego",
            "ka" => "Georgian - ქართული",
            "de" => "German - Deutsch",
            "de-AT" => "German (Austria) - Deutsch (Österreich)",
            "de-DE" => "German (Germany) - Deutsch (Deutschland)",
            "de-LI" => "German (Liechtenstein) - Deutsch (Liechtenstein)",
            "de-CH" => "German (Switzerland) - Deutsch (Schweiz)",
            "el" => "Greek - Ελληνικά",
            "gn" => "Guarani",
            "gu" => "Gujarati - ગુજરાતી",
            "ha" => "Hausa",
            "haw" => "Hawaiian - ʻŌlelo Hawaiʻi",
            "he" => "Hebrew - עברית",
            "hi" => "Hindi - हिन्दी",
            "hu" => "Hungarian - magyar",
            "is" => "Icelandic - íslenska",
            "id" => "Indonesian - Indonesia",
            "ia" => "Interlingua",
            "ga" => "Irish - Gaeilge",
            "it" => "Italian - italiano",
            "it-IT" => "Italian (Italy) - italiano (Italia)",
            "it-CH" => "Italian (Switzerland) - italiano (Svizzera)",
            "ja" => "Japanese - 日本語",
            "kn" => "Kannada - ಕನ್ನಡ",
            "kk" => "Kazakh - қазақ тілі",
            "km" => "Khmer - ខ្មែរ",
            "ko" => "Korean - 한국어",
            "ku" => "Kurdish - Kurdî",
            "ky" => "Kyrgyz - кыргызча",
            "lo" => "Lao - ລາວ",
            "la" => "Latin",
            "lv" => "Latvian - latviešu",
            "ln" => "Lingala - lingála",
            "lt" => "Lithuanian - lietuvių",
            "mk" => "Macedonian - македонски",
            "ms" => "Malay - Bahasa Melayu",
            "ml" => "Malayalam - മലയാളം",
            "mt" => "Maltese - Malti",
            "mr" => "Marathi - मराठी",
            "mn" => "Mongolian - монгол",
            "ne" => "Nepali - नेपाली",
            "no" => "Norwegian - norsk",
            "nb" => "Norwegian Bokmål - norsk bokmål",
            "nn" => "Norwegian Nynorsk - nynorsk",
            "oc" => "Occitan",
            "or" => "Oriya - ଓଡ଼ିଆ",
            "om" => "Oromo - Oromoo",
            "ps" => "Pashto - پښتو",
            "fa" => "Persian - فارسی",
            "pl" => "Polish - polski",
            "pt" => "Portuguese - português",
            "pt-BR" => "Portuguese (Brazil) - português (Brasil)",
            "pt-PT" => "Portuguese (Portugal) - português (Portugal)",
            "pa" => "Punjabi - ਪੰਜਾਬੀ",
            "qu" => "Quechua",
            "ro" => "Romanian - română",
            "mo" => "Romanian (Moldova) - română (Moldova)",
            "rm" => "Romansh - rumantsch",
            "ru" => "Russian - русский",
            "gd" => "Scottish Gaelic",
            "sr" => "Serbian - српски",
            "sh" => "Serbo-Croatian - Srpskohrvatski",
            "sn" => "Shona - chiShona",
            "sd" => "Sindhi",
            "si" => "Sinhala - සිංහල",
            "sk" => "Slovak - slovenčina",
            "sl" => "Slovenian - slovenščina",
            "so" => "Somali - Soomaali",
            "st" => "Southern Sotho",
            "es" => "Spanish - español",
            "es-AR" => "Spanish (Argentina) - español (Argentina)",
            "es-419" => "Spanish (Latin America) - español (Latinoamérica)",
            "es-MX" => "Spanish (Mexico) - español (México)",
            "es-ES" => "Spanish (Spain) - español (España)",
            "es-US" => "Spanish (United States) - español (Estados Unidos)",
            "su" => "Sundanese",
            "sw" => "Swahili - Kiswahili",
            "sv" => "Swedish - svenska",
            "tg" => "Tajik - тоҷикӣ",
            "ta" => "Tamil - தமிழ்",
            "tt" => "Tatar",
            "te" => "Telugu - తెలుగు",
            "th" => "Thai - ไทย",
            "ti" => "Tigrinya - ትግርኛ",
            "to" => "Tongan - lea fakatonga",
            "tr" => "Turkish - Türkçe",
            "tk" => "Turkmen",
            "tw" => "Twi",
            "uk" => "Ukrainian - українська",
            "ur" => "Urdu - اردو",
            "ug" => "Uyghur",
            "uz" => "Uzbek - o‘zbek",
            "vi" => "Vietnamese - Tiếng Việt",
            "wa" => "Walloon - wa",
            "cy" => "Welsh - Cymraeg",
            "fy" => "Western Frisian",
            "xh" => "Xhosa",
            "yi" => "Yiddish",
            "yo" => "Yoruba - Èdè Yorùbá",
            "zu" => "Zulu - isiZulu"
        ];

        echo <<<HTML
            <div class="table-wrapper"><table id="auteurs" class="table table-hover">
                <thead>
                    <tr>
                        <th style='width: 2%'>Visible</th>

                        <th style='width: 10%'>Identifiant</th>
                        <th style='width: 10%'>Sexe</th>
                        <th style='width: 15%'>Langue</th>
                    </tr>
                </thead>
            <tbody>
HTML;
        while ($row = $contents->fetch_row()) {

            $selected1 = '';
            $selected2 = '';
            $selected3 = '';

            if ($row[2] == 0)
                $selected1 = 'selected';

            if ($row[2] == 1)
                $selected2 = 'selected';

            if ($row[2] == 2)
                $selected3 = 'selected';

            echo "<tr>";

            $checked = "";
            if ($row[4] == 1)
                $checked = "checked";

            echo <<<HTML
                <td>
                    <input msok="yes" 
                    class="form-check-input" 
                    type="checkbox" $checked 
                    name="voirAuteur[$row[0]]" 
                    value=$row[0] 
                    id="ViewAuthor$row[0]">
                </td>

            <td>
                <input msok='yes' 
                        type='text' 
                        name='Identifiant[$row[0]]'   
                        class=' form-control form-control-sm' 
                        value=$row[1]
                >
            </td>

            <td>
            
                <select name='Sexe[$row[0]]'  id='Sexe' class=' form-control form-control-sm'>
                    <option value='0' $selected1>Masculin</option>
                    <option value='1' $selected2>Faminin</option>
                    <option value='2' $selected3>Aucun</option>
                </select>

            </td>

            <td>
                <select name='Langue[$row[0]]'  id='Sexe' class=' form-control form-control-sm'>";
HTML;

            foreach ($langue as $key => $value) {
                if ($key == $row[3])
                    echo "<option value= '$key' selected>$value</option>";
                else
                    echo "<option value= '$key' >$value</option>";
            }

            echo "</select></td></tr>";
        }
        echo <<<HTML
            </tbody></table></div>
   
HTML;
    }
}
