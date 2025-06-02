<?php

require_once 'config.php';

class HoroskopuGeneretajs {
    private $zodiakaRaksturiezimes;
    private $houses;
    private $pedejaNoskana;

    private function tulkotZodiaku($en) {
        $translations = [
            'Aries' => 'Auns',
            'Taurus' => 'Vērsis',
            'Gemini' => 'Dvīņi',
            'Cancer' => 'Vēzis',
            'Leo' => 'Lauva',
            'Virgo' => 'Jaunava',
            'Libra' => 'Svari',
            'Scorpio' => 'Skorpions',
            'Sagittarius' => 'Strēlnieks',
            'Capricorn' => 'Mežāzis',
            'Aquarius' => 'Ūdensvīrs',
            'Pisces' => 'Zivis',
        ];
        return $translations[$en] ?? $en;
    }
    

    public function __construct() {
        $this->zodiakaRaksturiezimes = json_decode(file_get_contents('zodiac_personalities.json'), true) ?? [];
        $this->houses = json_decode(file_get_contents('houses.json'), true) ?? [];
    }

    public function generetDienasHoroskopu($zodiakaZime, $datums) {
        if (!$this->isValidZodiac($zodiakaZime)) {
            $zodiakaZime = 'Aries'; // Noklusējuma
        }

        $planetuPozicijas = $this->SimuletPlanetasPozicijas($datums);
        $teksts = $this->generetPamatekstu($datums, $planetuPozicijas, $zodiakaZime);


        return $this->MIAtbilde($teksts);
    }

    private function SimuletPlanetasPozicijas($datums) {
        $planetas = ['Sun', 'Moon', 'Mercury', 'Venus', 'Mars', 
                     'Jupiter', 'Saturn', 'Uranus', 'Neptune', 'Pluto'];

        $pozicijas = [];
        foreach ($planetas as $planeta) {
            $pozicijas[$planeta] = rand(1, 12);
        }
        return $pozicijas;
    }

    private function izveletiesNoskanu() {
        $noskanasVarianti = [
            'negatīva', 'negatīva', 'negatīva',
            'neitrāla', 'neitrāla', 'neitrāla',                         
            'pozitīva', 'pozitīva', 'pozitīva'                                      
        ];
        $this->pedejaNoskana = $noskanasVarianti[array_rand($noskanasVarianti)];
        return $this->pedejaNoskana;
    }
    public function iegutPedejoNoskanu() {
        return $this->pedejaNoskana;
    }


    private function generetPamatekstu($datums, $pozicijas, $zime) {
    $latviskaisNosaukums = $this->tulkotZodiaku($zime);
    $pozicijuApraksts = '';
    foreach ($pozicijas as $planeta => $house) {
        $desc = $this->houses[$house] ?? 'nav apraksta';
        $pozicijuApraksts .= "{$planeta} ir {$house}. mājā ({$desc}). ";
    }

    $raksturs = $this->zodiakaRaksturiezimes[$zime] ?? [
        'element' => 'Nezināms',
        'modality' => 'Nezināms',
        'personality' => 'Nezināms'
    ];

    $noskana = $this->izveletiesNoskanu();

    return "Uzraksti tikai vienu īsu, gramatiski pareizu, emocionālu un iedvesmojošu horoskopa tekstu latviešu valodā zodiaka zīmei \"{$latviskaisNosaukums}\" ({$datums}). 
            Nelieto ievadu, virsrakstus vai datuma atkārtošanu, un **neapraksti zodiaka zīmi, tikai raksturo tās raksturu un ietekmi.** 
            Zīmes raksturs: elements – {$raksturs['element']}, modalitāte – {$raksturs['modality']}, personība – {$raksturs['personality']}. 
            Planētu pozīcijas: {$pozicijuApraksts} 
            Tekstam jābūt plūstošam, vienmērīgam, ar skaidru nobeigumu un punktu. 
            **Izvairies no jebkādas zodiaka zīmes nosaukuma lietošanas (piemēram, Auns, Vēzis, Dvīņi).** 
            Teksta emocionālajai noskaņai jābūt: **{$noskana}**.";
}

    
    

private function MIAtbilde($prompt) {
    $url = 'https://api.openai.com/v1/chat/completions';
    $data = [
        "model" => "gpt-3.5-turbo",
        "messages" => [
            ["role" => "system", "content" => "Tu esi radošs, emocionāls un simbolisks horoskopu autors."],
            ["role" => "user", "content" => $prompt]
        ],
        "temperature" => 0.8,
        "max_tokens" => 600, // Samazina atbildes garumu
        "top_p" => 1,
        "frequency_penalty" => 0,
        "presence_penalty" => 0
    ];

    $headers = [
        'Content-Type: application/json',
        'Authorization: ' . 'Bearer ' . OPENAI_KEY
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    $json = json_decode($response, true);
    $responseText = $json['choices'][0]['message']['content'] ?? 'Horoskops nav pieejams.';

    // Pievieno punktu, ja nav beigu pieturzīmes
    $responseText = rtrim($responseText);
    if (!preg_match('/[\.!?]$/u', $responseText)) {
        $responseText .= '.';
    }

    return $responseText;
}


    

    private function isValidZodiac($sign) {
        return in_array($sign, ['Aries', 'Taurus', 'Gemini', 'Cancer', 'Leo', 
                                'Virgo', 'Libra', 'Scorpio', 'Sagittarius', 
                                'Capricorn', 'Aquarius', 'Pisces']);
    }
}