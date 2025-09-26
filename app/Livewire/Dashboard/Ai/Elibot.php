<?php

namespace App\Livewire\Dashboard\Ai;


use Livewire\Component;

class Elibot extends Component
{
    public $body;
    public array $messages = [];


    protected $rules = [
        'body' => 'required|max:1000'
    ];


    public function mount()
    {

// 2️⃣ گرفتن System Prompt از config و جایگزینی اسم کاربر
        $systemPrompt = config('elibot.system_prompt'); // فقط رشته system_prompt
        $userName = auth()->user()->name ?? 'دوست عزیز';
        $systemPrompt = str_replace(':name', $userName, $systemPrompt);

        $this->messages[] =
//            'role' => 'system', 'content' => ' تو دستیار هوشمند اپلیکیشن اربور هستی ، اسم تو الی بات هست و فقط فارسی تایپ میکنی ';
          [  'role' => 'system',
              'content' => [
                  ['type' => 'text', 'text' => $systemPrompt]
              ]
          ];



    }


    public function send()
    {

        $this->validate();


        $this->messages[] = ['role' => 'user', 'content' => $this->body];
        $this->messages[] = ['role' => 'assistant', 'content' => ''];
        $this->body = "";
    }



    public function render()
    {
        return view('livewire.dashboard.ai.elibot')->layout('components.layouts.admin');
    }
}
