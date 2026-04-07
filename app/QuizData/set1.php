<?php

namespace App\QuizData; // Mesti App (A besar) dan QuizData (Q & D besar)

class Set1 { // Mesti Set1 (S besar)
    public static function questions() {
        return [
            [
                'question' => 'What is the core principle of informed consent in PHCAS ethics?',
                'options' => ['Respecting patient’s right to make decisions about their care', 'Only required for paediatric cases', 'Consent only from next of kin', 'Ignored in mass casualty incidents', 'Providing treatment without explanation'],
                'answer' => 'Respecting patient’s right to make decisions about their care'
            ],
            [
                'question' => 'Which of the following is considered a high-alert medication in PHCAS?',
                'options' => ['Paracetamol', 'Ipratropium bromide', 'Acetylsalicylic acid', 'Glucose gel', 'Adrenaline 1 mg/ml'],
                'answer' => 'Adrenaline 1 mg/ml'
            ],
            [
                'question' => 'Which of the following is a TOR (termination of resuscitation) exclusion criterion?',
                'options' => ['No ROSC after 8 minutes', 'Asystole on first rhythm check', 'Patient with one shockable rhythm', 'Absence of bystander CPR', 'Persistent asystole after 3 CPR cycles'],
                'answer' => 'Patient with one shockable rhythm'
            ],
            [
                'question' => 'The acronym PMS in PHCAS stands for:',
                'options' => ['Pulse, Movement, Sensation', 'Pain, Mood, Stability', 'Pressure, Muscle, Shock', 'Perfusion, Mental, Saturation', 'Palpation, Motion, Status'],
                'answer' => 'Pulse, Movement, Sensation'
            ],
            [
                'question' => 'In paediatric cardiac arrest, what is the most common cause?',
                'options' => ['Ventricular fibrillation', 'Asystole due to trauma', 'Respiratory failure or shock', 'Myocardial infarction', 'Bradycardia from fever'],
                'answer' => 'Respiratory failure or shock'
            ],
            [
                'question' => 'What is the primary tool used for initial visual assessment of a sick child in PHCAS?',
                'options' => ['Paediatric Assessment Triangle (PAT)', 'Glasgow Coma Scale', 'AVPU Scale', 'SBAR', 'ABCDE'],
                'answer' => 'Paediatric Assessment Triangle (PAT)'
            ],
            [
                'question' => 'Which of the following signs may indicate brain injury post-ROSC and requires neuroprotection?',
                'options' => ['GCS 15 with anxiety', 'Alert patient speaking fluently', 'Oxygen saturation >98%', 'Stable vitals with good skin tone', 'GCS 3 with seizures'],
                'answer' => 'GCS 3 with seizures'
            ],
            [
                'question' => 'What was the main focus of emergency services in Malaysia during the 1970s?',
                'options' => ['Advanced cardiac life support', 'Comprehensive medical intervention on scene', 'Hospital-based patient transportation', 'Trauma system integration', 'Air ambulance development'],
                'answer' => 'Hospital-based patient transportation'
            ],
            [
                'question' => 'After each shift, what is the requirement for medication handling?',
                'options' => ['Mix all expired drugs with new ones', 'Forward all items to the pharmacist', 'Record and restock used medications in a logbook', 'Freeze unused ampoules', 'Clean the box with alcohol'],
                'answer' => 'Record and restock used medications in a logbook'
            ],
            [
                'question' => 'What defines a mass casualty incident (MCI) according to NADMA Directive No. 1?',
                'options' => ['An incident that overwhelms local EMS or healthcare capacity', 'An event involving >10 casualties', 'Any natural disaster', 'Hospital-based incidents', 'Any road traffic accident'],
                'answer' => 'An incident that overwhelms local EMS or healthcare capacity'
            ],
            
        ];
    }
}