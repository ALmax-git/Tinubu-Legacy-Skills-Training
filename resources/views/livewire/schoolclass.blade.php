<div class="container-fluid px-4 pt-4">
  <div class="bg-secondary h-100 rounded p-4">
    <button class="btn btn-primary fload-end mb-3" wire:click="create">Add Class</button>

    @if (session()->has('message'))
      <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="table-responsive">
      <table class="hover mt-3 table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th>Name</th>
            <th>Type</th>
            <th>Student Count</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @php
            $count = 0;
          @endphp
          @foreach ($classes as $class)
            <tr>
              <td scope="row">{{ ++$count }}</td>
              <td>{{ $class->name }}</td>
              <td>{{ $class->type }}</td>
              <td>{{ $class->students_count }}</td>
              <td>
                <button class="btn btn-warning btn-sm" wire:click="edit({{ $class->id }})">Edit</button>
                <button class="btn btn-danger btn-sm" wire:click="delete({{ $class->id }})">Delete</button>
                <button class="btn btn-info btn-sm" wire:click="viewStudents({{ $class->id }})">View
                  Students</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      {{ $classes->links() }}
    </div>
    <!-- Add/Edit Modal -->
    @if ($showModal)
      <div class="modal d-block" style="background: rgba(0, 0, 0, 0.546);">
        <div class="modal-dialog">
          <div class="modal-content bg-black" style="border: 1px solid rgb(255, 0, 0);">
            <div class="modal-header" style="background: rgb(0, 0, 0);">
              <h5 class="modal-title">{{ $class_id ? 'Edit Class' : 'Create Class' }}</h5>
              <button class="close" type="button"
                style="border: 1px solid red; color: red; font-weight: 800; border-radius: 50%;"
                wire:click="$set('showModal', false)">&times;</button>
            </div>
            <div class="modal-body scroll scrollable"
              style="background: rgb(0, 0, 0) !important; max-height: 75vh; overflow-y: scroll;">
              <label>Name:</label>
              <input class="form-control" type="text" style="border: 1px solid red;" wire:model="name">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>

              <label>Type:</label>
              <select class="form-control" style="border: 1px solid red;" wire:model="type">
                <option value="">-- Select Type --</option>
                <option value="BEGINNER 1">BEGINNER 1</option>
                <option value="BEGINNER 2">BEGINNER 2</option>
                <option value="INTERMEDIATE">INTERMEDIATE</option>
                <option value="ADVANCE">ADVANCE</option>
              </select>
              @error('type')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>

              <label class="mb-1">School</label>
              <select class="form-control mb-2" style="border: 1px solid red;" wire:model="school_id">
                <option value="">Select School</option>
                @foreach ($schools as $school)
                  <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
              </select>
              @error('school_id')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
            </div>
            <div class="modal-footer" style="background: rgb(0, 0, 0);">
              <button class="btn btn-success" wire:click="save">Save</button>
              <button class="btn btn-secondary" wire:click="$set('showModal', false)">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endif

    <!-- Student List Modal -->
    @if ($viewingStudents)
      <div class="modal d-block" style="background: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Students in Class</h5>
              <button class="close" type="button" wire:click="$set('viewingStudents', false)">&times;</button>
            </div>
            <div class="modal-body">
              @if (count($students) > 0)
                <ul>
                  @foreach ($students as $student)
                    <li>{{ $student->first_name }} {{ $student->last_name }}</li>
                  @endforeach
                </ul>
              @else
                <p>No students in this class.</p>
              @endif
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" wire:click="$set('viewingStudents', false)">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
