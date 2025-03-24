<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Student as ModelsStudent;

class Student extends Component
{

    use WithPagination, WithFileUploads;

    public $first_name, $surname, $last_name, $state, $lga, $address, $phone_number, $student_photo;
    public $dob, $gender, $school_id, $school_class_id;
    public $mentors_name, $mentors_address, $mentors_phone;
    public $fathers_name, $fathers_address, $fathers_phone_number;
    public $search = '', $selectedClass, $selectedSchool;
    public $showModal = false, $viewModal = false, $student_id;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'surname' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'lga' => 'nullable|string|max:255',
        'address' => 'required|string|max:255',
        'phone_number' => 'required|string|max:20',
        'dob' => 'required|date',
        'gender' => 'required|in:Male,Female',
        'school_id' => 'required|exists:schools,id',
        'school_class_id' => 'required|exists:school_classes,id',
        'mentors_name' => 'nullable|string|max:255',
        'mentors_address' => 'nullable|string|max:255',
        'mentors_phone' => 'nullable|string|max:20',
        'fathers_name' => 'required|string|max:255',
        'fathers_address' => 'required|string|max:255',
        'fathers_phone_number' => 'required|string|max:20',
        'student_photo' => 'nullable|image|max:2048'
    ];

    public function render()
    {
        $schools = School::all();
        $classes = SchoolClass::when($this->selectedSchool, function ($query) {
            return $query->where('school_id', $this->selectedSchool);
        })->get();

        $students = ModelsStudent::where('first_name', 'like', "%{$this->search}%")
            ->orWhere('phone_number', 'like', "%{$this->search}%")
            ->orWhere('state', 'like', "%{$this->search}%")
            ->when($this->selectedClass, function ($query) {
                $query->where('school_class_id', $this->selectedClass);
            })
            ->when($this->selectedSchool, function ($query) {
                $query->where('school_id', $this->selectedSchool);
            })
            ->paginate(10);

        return view('livewire.student', compact('students', 'schools', 'classes'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset([
            'first_name',
            'surname',
            'last_name',
            'state',
            'lga',
            'address',
            'phone_number',
            'student_photo',
            'dob',
            'gender',
            'school_id',
            'school_class_id',
            'mentors_name',
            'mentors_address',
            'mentors_phone',
            'fathers_name',
            'fathers_address',
            'fathers_phone_number',
            'student_id'
        ]);
        $this->showModal = true;
    }
    public function view($id)
    {
        $student = ModelsStudent::findOrFail($id);
        $this->student_id = $id;
        $this->fill($student->toArray());
        $this->viewModal = true;
    }

    public function edit($id)
    {
        $student = ModelsStudent::findOrFail($id);
        $this->student_id = $id;
        $this->fill($student->toArray());
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->student_photo) {
            $photoPath = $this->student_photo->store('students', 'public');
        } else {
            $photoPath = null;
        }

        ModelsStudent::updateOrCreate(
            ['id' => $this->student_id],
            [
                'first_name' => $this->first_name,
                'surname' => $this->surname,
                'last_name' => $this->last_name,
                'state' => $this->state,
                'lga' => $this->lga,
                'address' => $this->address,
                'phone_number' => $this->phone_number,
                'dob' => $this->dob,
                'gender' => $this->gender,
                'school_id' => $this->school_id,
                'school_class_id' => $this->school_class_id,
                'mentors_name' => $this->mentors_name,
                'mentors_address' => $this->mentors_address,
                'mentors_phone' => $this->mentors_phone,
                'fathers_name' => $this->fathers_name,
                'fathers_address' => $this->fathers_address,
                'fathers_phone_number' => $this->fathers_phone_number,
                'student_photo' => $photoPath,
            ]
        );

        session()->flash('message', $this->student_id ? 'Student updated!' : 'Student added!');
        $this->showModal = false;
    }

    public function delete($id)
    {
        ModelsStudent::findOrFail($id)->delete();
        session()->flash('message', 'Student deleted!');
    }
}
