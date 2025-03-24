<?php

namespace App\Livewire;

use App\Models\School;
use Livewire\Component;

use Livewire\WithPagination;
// use App\Models\Schoolclass as ClassModel;
use App\Models\SchoolClass as ModelsSchoolClass;
use App\Models\Student;
use Illuminate\Support\Collection;

class  Schoolclass extends Component
{
    use WithPagination;
    public $name, $type, $school_id, $class_id;
    public $showModal = false, $viewingStudents = false;
    public $students = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|in:BEGINNER 1,BEGINNER 2,INTERMEDIATE,ADVANCE',
        'school_id' => 'required|exists:schools,id',
    ];

    public function create()
    {
        $this->reset(['name', 'type', 'school_id', 'class_id']);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $class = ModelsSchoolClass::findOrFail($id);
        $this->class_id = $id;
        $this->name = $class->name;
        $this->type = $class->type;
        $this->school_id = $class->school_id;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        ModelsSchoolClass::updateOrCreate(
            ['id' => $this->class_id],
            ['name' => $this->name, 'type' => $this->type, 'school_id' => $this->school_id]
        );

        session()->flash('message', $this->class_id ? 'Class updated!' : 'Class added!');
        $this->showModal = false;
    }

    public function delete($id)
    {
        ModelsSchoolClass::findOrFail($id)->delete();
        session()->flash('message', 'Class deleted!');
    }

    public function viewStudents($id)
    {
        $this->students = Student::where('school_class_id', $id)->get();
        $this->viewingStudents = true;
    }
    public function render()
    {
        $schools = School::all();
        $classes = ModelsSchoolClass::withCount('students')->paginate(5);
        return view('livewire.schoolclass',  compact('classes', 'schools'));
    }
}
