<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    private function sharedData(): array
    {
        return [
            'appName' => 'StudyGenie AI',
            'navLinks' => [
                ['label' => 'Features',  'href' => '#features'],
                ['label' => 'About',     'href' => '#vision'],
                ['label' => 'Our Goal',  'href' => '#goal'],
                ['label' => 'Contact',   'href' => '#contact'],
            ],
        ];
    }

    public function index()
    {
        $data = array_merge($this->sharedData(), [
            'stats' => [
                ['value' => '100%', 'label' => 'Study Time on Actual Learning'],
                ['value' => '5x',   'label' => 'Faster Note Processing'],
                ['value' => 'Zero', 'label' => 'Study Friction'],
                ['value' => 'SRS',  'label' => 'Spaced Repetition Built In'],
            ],
            'pillars' => [
                [
                    'icon'  => '🔭',
                    'title' => 'Vision',
                    'body'  => 'To be the world\'s primary cognitive partner, ensuring that no student is ever overwhelmed by the volume of information they need to master.',
                ],
                [
                    'icon'  => '🎯',
                    'title' => 'Mission',
                    'body'  => 'To democratize personalized education by using AI to transform static information into interactive, high-retention learning experiences accessible to every student, everywhere.',
                ],
                [
                    'icon'  => '🌉',
                    'title' => 'Goal',
                    'body'  => 'To bridge the gap between "having information" and "understanding concepts" through automated, data-driven study workflows.',
                ],
            ],
            'features' => [
                [
                    'icon'   => '🤖',
                    'title'  => 'AI Study Material Generator',
                    'desc'   => 'Uses StudyGenie AI to generate comprehensive study materials automatically from any source.',
                    'value'  => 'Zero manual work — AI does the heavy lifting',
                    'color'  => 'blue',
                    'route'  => '/features/ai-study-materials',
                ],
                [
                    'icon'   => '🎯',
                    'title'  => 'Personalized Quizzes',
                    'desc'   => 'Personalized quizzes based on difficulty level that adapt as your knowledge grows.',
                    'value'  => 'Challenges you at exactly the right level',
                    'color'  => 'violet',
                    'route'  => '/features/personalized-quizzes',
                ],
                [
                    'icon'   => '📝',
                    'title'  => 'Smart Notes Converter',
                    'desc'   => 'Turns raw notes into smart learning tools instantly — upload PDFs, photos, or voice memos.',
                    'value'  => 'Saves hours of manual organizing',
                    'color'  => 'teal',
                    'route'  => '/features/smart-notes',
                ],
                [
                    'icon'   => '🃏',
                    'title'  => 'Smart Flashcard Deck (SRS)',
                    'desc'   => 'Automatically generates cards with Spaced Repetition System logic for long-term retention.',
                    'value'  => 'Ensures long-term memory, not just cramming',
                    'color'  => 'amber',
                    'route'  => '/features/flashcard-deck',
                ],
                [
                    'icon'   => '📊',
                    'title'  => 'Adaptive Mock Exams',
                    'desc'   => 'Quizzes that get harder as you get answers right, simulating real exam pressure.',
                    'value'  => 'Prepares you for the actual pressure of an exam',
                    'color'  => 'rose',
                    'route'  => '/features/mock-exams',
                ],
                [
                    'icon'   => '🎙️',
                    'title'  => 'Voice-Over Tutor Mode',
                    'desc'   => 'An AI voice that explains complex topics in simple, conversational language.',
                    'value'  => 'Great for auditory learners or studying on the go',
                    'color'  => 'indigo',
                    'route'  => '/features/tutor-mode',
                ],
            ],
        ]);

        return view('landing', $data);
    }

    public function contact()
    {
        return view('contact', $this->sharedData());
    }

    public function features()
    {
        return view('index', $this->sharedData());
    }

    public function aiStudyMaterials()
    {
        $data = array_merge($this->sharedData(), [
            'feature' => [
                'icon'        => '🤖',
                'color'       => 'blue',
                'title'       => 'AI Study Material Generator',
                'tagline'     => 'Let AI do the work. You do the learning.',
                'description' => 'StudyGenie\'s AI engine reads any content you upload and instantly creates structured, comprehensive study materials — outlines, summaries, key points, and more.',
                'highlights'  => [
                    'Upload PDFs, Word docs, images, or paste text',
                    'AI extracts key concepts and structures them',
                    'Generates summaries at multiple depth levels',
                    'Creates topic outlines with sub-points',
                    'Identifies and highlights critical terms',
                ],
                'how_it_works' => [
                    ['step' => '1', 'title' => 'Upload Your Content', 'desc' => 'Drop in any file format — PDF, image, audio, or plain text.'],
                    ['step' => '2', 'title' => 'AI Processes It',     'desc' => 'StudyGenie\'s engine extracts structure, key ideas, and relationships.'],
                    ['step' => '3', 'title' => 'Get Study Materials', 'desc' => 'Receive organized summaries, outlines, and notes in seconds.'],
                ],
            ],
        ]);
        return view('features.ai-study-materials', $data);
    }

    public function personalizedQuizzes()
    {
        $data = array_merge($this->sharedData(), [
            'feature' => [
                'icon'        => '🎯',
                'color'       => 'violet',
                'title'       => 'Personalized Quizzes',
                'tagline'     => 'Quizzes that know exactly what you need.',
                'description' => 'Not all students are the same. StudyGenie builds quizzes tailored to your current knowledge level and dynamically adjusts difficulty as you improve.',
                'highlights'  => [
                    'Difficulty auto-adjusts to your performance',
                    'Covers weak areas more frequently',
                    'Multiple question formats: MCQ, True/False, Fill-in',
                    'Detailed explanations for every answer',
                    'Progress tracked across sessions',
                ],
                'how_it_works' => [
                    ['step' => '1', 'title' => 'Set Your Level',       'desc' => 'Tell us your current comfort level or let AI assess you.'],
                    ['step' => '2', 'title' => 'Take the Quiz',        'desc' => 'Answer questions generated from your own study materials.'],
                    ['step' => '3', 'title' => 'AI Adjusts & Repeats', 'desc' => 'Difficulty shifts in real time based on your accuracy.'],
                ],
            ],
        ]);
        return view('features.personalized-quizzes', $data);
    }

    public function smartNotes()
    {
        $data = array_merge($this->sharedData(), [
            'feature' => [
                'icon'        => '📝',
                'color'       => 'teal',
                'title'       => 'Smart Notes Converter',
                'tagline'     => 'Raw notes in. Smart tools out.',
                'description' => 'Stop spending hours organizing handwritten or messy notes. StudyGenie converts any raw input into structured, actionable learning tools instantly.',
                'highlights'  => [
                    'Handwritten photo → clean digital notes',
                    'Voice memo → structured outline',
                    'Messy PDF → organized summary',
                    'Auto-tags topics and subtopics',
                    'Exports to multiple formats',
                ],
                'how_it_works' => [
                    ['step' => '1', 'title' => 'Upload Raw Notes',       'desc' => 'Photo of handwriting, audio recording, or a messy document.'],
                    ['step' => '2', 'title' => 'AI Cleans & Structures', 'desc' => 'Transforms chaos into clean, tagged, organized notes.'],
                    ['step' => '3', 'title' => 'Use Instantly',          'desc' => 'Your notes are now searchable, shareable, and study-ready.'],
                ],
            ],
        ]);
        return view('features.smart-notes', $data);
    }

    public function flashcardDeck()
    {
        $data = $this->sharedData();
        return view('features.flashcard-deck', $data);
    }

    public function mockExams()
    {
        $data = $this->sharedData();
        return view('features.mock-exams', $data);
    }

    public function tutorMode()
    {
        $data = $this->sharedData();
        return view('features.tutor-mode', $data);
    }

    public function studyTimeReminders()
    {
        $data = array_merge($this->sharedData(), [
            'feature' => [
                'title' => 'Study Time Reminders',
                'icon' => '⏰',
                'tagline' => 'Never miss a study session',
                'description' => 'Smart notifications that help keep you on track with personalized study schedules and session reminders.',
                'features' => [
                    [
                        'title' => 'Personalized Schedules',
                        'description' => 'Set your own study times and StudyGenie will adapt to your routine.',
                    ],
                    [
                        'title' => 'Smart Reminders',
                        'description' => 'Get notified at the perfect time to start your next study session.',
                    ],
                    [
                        'title' => 'Progress Tracking',
                        'description' => 'Monitor your study consistency and see improvement over time.',
                    ],
                    [
                        'title' => 'Flexible Notifications',
                        'description' => 'Customize reminder frequency, timing, and delivery methods.',
                    ],
                ],
                'benefits' => [
                    'Build consistent study habits with daily reminders.',
                    'Never forget important study sessions or review dates.',
                    'Optimize learning with reminders based on spaced repetition.',
                    'Balance study and life with smart scheduling.',
                ],
            ],
        ]);
        return view('features.study-time-reminders', $data);
    }
}