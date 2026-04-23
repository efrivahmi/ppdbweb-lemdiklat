<?php

namespace App\Livewire\Admin;

use App\Models\Feedback;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.admin')]
#[Title('Feedback Reviews')]
class FeedbackList extends Component
{
    use WithPagination;

    public function render()
    {
        $feedbacks = Feedback::with('user')->latest()->paginate(10);
        
        return view('livewire.admin.feedback-list', [
            'feedbacks' => $feedbacks
        ]);
    }
}
