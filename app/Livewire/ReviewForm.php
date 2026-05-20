<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;

class ReviewForm extends Component
{
    public $animalId;
    public $rating = 5;
    public $title = '';
    public $body = '';

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'title'  => 'required|string|max:100',
        'body'   => 'required|string|min:10|max:1000',
    ];

    public function submit()
    {
        $this->validate();

        Review::create([
            'user_id'   => auth()->id(),
            'animal_id' => $this->animalId,
            'rating'    => $this->rating,
            'title'     => $this->title,
            'body'      => $this->body,
            'is_approved' => false,
        ]);

        $this->reset(['rating', 'title', 'body']);
        $this->rating = 5;

        session()->flash('review_success', 'Your review has been submitted and is awaiting approval. Thank you!');
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
