<?php

namespace App\Livewire\Components;

use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class FeedbackPopup extends Component
{
    public $show = false;
    public $rating = 0;
    public $message = '';
    public $submitted = false;

    public function mount()
    {
        if (session('show_feedback_popup')) {
            $this->show = true;
        }
    }

    #[On('open-feedback-popup')]
    public function open()
    {
        $this->show = true;
        $this->submitted = false;
        $this->rating = 0;
        $this->message = '';
    }

    public function close()
    {
        $this->show = false;
    }

    public function submit()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'message' => 'nullable|string|max:500',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'rating' => $this->rating,
            'message' => $this->message,
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.components.feedback-popup');
    }
}
