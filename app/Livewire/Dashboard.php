<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Student;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{

    public $school_name, $school_address;
    public $name, $email, $phone;

    public function mount()
    {
        $school = School::first(); // Fetch first school (adjust if needed)
        if ($school) {
            $this->school_name = $school->name;
            $this->school_address = $school->address;
        }

        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
    }

    public function updateSchool()
    {
        $school = School::first();
        if ($school) {
            $school->update([
                'name' => $this->school_name,
                'address' => $this->school_address,
            ]);
        }
        session()->flash('message', 'School updated successfully.');
    }

    public function updateProfile()
    {
        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
        session()->flash('message', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'total_students' => Student::count(),
            'total_class' => SchoolClass::count(),
            'recent_students' => Student::latest()->limit(5)->get(),
        ]);
    }
}
