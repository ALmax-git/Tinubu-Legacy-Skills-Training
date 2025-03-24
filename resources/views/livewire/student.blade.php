<div class="container-fluid px-4 pt-4">
  <div class="bg-secondary h-100 rounded p-4">
    <button class="btn btn-primary float-end mb-3" wire:click="create">Add Student</button>

    @if (session()->has('message'))
      <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <input class="form-control mb-3" type="text" wire:model.live="search" placeholder="Search by Name, Phone, State">

    <div class="nav nav-tabs">
      <button class="nav-link {{ !$selectedClass ? 'active' : '' }}" wire:click="$set('selectedClass', null)">All
        Classes</button>
      @foreach ($classes as $class)
        <button class="nav-link {{ $selectedClass == $class->id ? 'active' : '' }}"
          wire:click="$set('selectedClass', {{ $class->id }})">
          {{ $class->name }}
        </button>
      @endforeach
    </div>
    <div class="table-responsive">
      <table class="hover mt-3 table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Phone</th>
            <th scope="col">State</th>
            <th scope="col">Class</th>
            <th class="text-right" style="justify-content: end;" scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          @php
            $count = 0;
          @endphp
          @foreach ($students as $student)
            <tr>
              <td scope="row">{{ ++$count }}</td>
              <td>{{ $student->first_name }} {{ $student->surname }} {{ $student->last_name }}</td>
              <td>{{ $student->gender }}</td>
              <td>{{ $student->phone_number }}</td>
              <td>{{ $student->state }}</td>
              <td>{{ $student->schoolClass->name }}</td>
              <td class="text-right" style="justify-content: right; justify-items: end;">
                <button class="btn btn-info btn-sm" wire:click="view({{ $student->id }})">View</button>
                <button class="btn btn-warning btn-sm" wire:click="edit({{ $student->id }})">Edit</button>
                <button class="btn btn-danger btn-sm" wire:click="delete({{ $student->id }})">Delete</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      {{ $students->links() }}
    </div>
    {{-- View --}}
    @if ($viewModal)
      <div class="modal d-block" style="background: rgba(0, 0, 0, 0.546);">
        <div class="modal-dialog">
          <div class="modal-content bg-black" style="border: 1px solid rgb(255, 0, 0);">
            <div class="modal-header" style="background: rgb(0, 0, 0);">
              <h5 class="modal-title">View Student</h5>
              <button class="close" type="button"
                style="border: 1px solid red; color: red; font-weight: 800; border-radius: 50%;"
                wire:click="$set('viewModal', false)">&times;</button>
            </div>
            <div class="modal-body scroll scrollable p-4"
              style="background: rgb(0, 0, 0) !important; max-height: 75vh; overflow-y: scroll; font-size: larger; color: white !important;">
              <strong style="color: rgb(248, 221, 221);">Name:</strong> {{ $first_name }} {{ $surname }}
              {{ $last_name }}
              <br>
              <strong style="color: rgb(248, 221, 221);">Gender:</strong> {{ $gender }}<br>
              <strong style="color: rgb(248, 221, 221);">Phone Number:</strong> {{ $phone_number }}<br>
              <strong style="color: rgb(248, 221, 221);">DOB:</strong> {{ $dob }}<br>
              <hr style="color: rgb(255, 0, 0);">
              <strong style="color: rgb(248, 221, 221);">State:</strong> {{ $state }}<br>
              <strong style="color: rgb(248, 221, 221);">LGA:</strong> {{ $lga }}<br>
              <strong style="color: rgb(248, 221, 221);">Address:</strong> {{ $address }}<br>
              <hr style="color: rgb(255, 0, 0);">
              <strong style="color: rgb(248, 221, 221);">Mentor's Name:</strong> {{ $mentors_name }}<br>
              <strong style="color: rgb(248, 221, 221);">Mentor's Address:</strong> {{ $mentors_address }}<br>
              <strong style="color: rgb(248, 221, 221);">Mentor's Phone Number:</strong> {{ $mentors_phone }}<br>
              <hr style="color: rgb(255, 0, 0);">
              <strong style="color: rgb(248, 221, 221);">Father's Name:</strong> {{ $fathers_name }}<br>
              <strong style="color: rgb(248, 221, 221);">Father's Address:</strong> {{ $fathers_address }}<br>
              <strong style="color: rgb(248, 221, 221);">Father's Phone Number:</strong>
              {{ $fathers_phone_number }}<br>

            </div>
            <div class="modal-footer" style="background: rgb(0, 0, 0);">
              <button class="btn btn-secondary" wire:click="$set('viewModal', false)">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endif

    <!-- Add/Edit Modal -->
    @if ($showModal)
      <div class="modal d-block" style="background: rgba(0, 0, 0, 0.546);">
        <div class="modal-dialog">
          <div class="modal-content bg-black" style="border: 1px solid rgb(255, 0, 0); background-color: black;">
            <div class="modal-header" style="background: rgb(0, 0, 0);">
              <h5 class="modal-title">{{ $student_id ? 'Edit Student' : 'Add Student' }}</h5>
              <button class="close" type="button"
                style="border: 1px solid red; color: red; font-weight: 800; border-radius: 50%;"
                wire:click="$set('showModal', false)">X</button>
            </div>
            <div class="modal-body scroll scrollable"
              style="background: rgb(0, 0, 0) !important; height: 75vh; overflow-y: scroll;">
              <input class="form-control mb-2" type="text" style="border: 1px solid red;" wire:model="first_name"
                placeholder="First Name">
              @error('first_name')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;" wire:model="surname"
                placeholder="Surname">
              @error('surname')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;" wire:model="last_name"
                placeholder="Last Name">
              @error('last_name')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>

              <input class="form-control mb-2" type="text" style="border: 1px solid red;" wire:model="state"
                placeholder="State">
              @error('state')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;" wire:model="lga"
                placeholder="LGA">
              @error('lga')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;" wire:model="address"
                placeholder="Address">
              @error('address')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>

              <input class="form-control mb-2" type="text" style="border: 1px solid red;"
                wire:model="phone_number" placeholder="Phone Number">
              @error('phone_number')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>

              <label class="mb-1">Student Photo</label>
              <input class="form-control mb-2" type="file" style="border: 1px solid red;"
                wire:model="student_photo">

              @error('student_photo')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <label class="mb-1">Date of Birth</label>
              <input class="form-control mb-2" type="date" style="border: 1px solid red;" wire:model="dob">

              @error('dob')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <label class="mb-1">Gender</label>
              <select class="form-control mb-2" style="border: 1px solid red;" wire:model="gender">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>

              @error('gender')
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

              <label class="mb-1">Class</label>
              <select class="form-control mb-2" style="border: 1px solid red;" wire:model="school_class_id">
                <option value="">Select Class</option>
                @foreach ($classes as $class)
                  <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
              </select>

              @error('school_class_id')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <h5 class="mt-3">Mentor's Information</h5>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;"
                wire:model="mentors_name" placeholder="Mentor's Name">
              @error('mentors_name')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;"
                wire:model="mentors_address" placeholder="Mentor's Address">

              @error('mentors_address')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;"
                wire:model="mentors_phone" placeholder="Mentor's Phone">
              @error('mentors_phone')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>

              <h5 class="mt-3">Father's Information</h5>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;"
                wire:model="fathers_name" placeholder="Father's Name">

              @error('fathers_name')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;"
                wire:model="fathers_address" placeholder="Father's Address">
              @error('fathers_address')
                <span class="text-danger">{{ $message }}</span>
              @enderror <br>
              <input class="form-control mb-2" type="text" style="border: 1px solid red;"
                wire:model="fathers_phone_number" placeholder="Father's Phone Number">
              @error('fathers_phone_number')
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
  </div>
</div>
